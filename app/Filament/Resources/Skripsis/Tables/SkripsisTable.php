<?php

namespace App\Filament\Resources\Skripsis\Tables;

use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use App\Models\Skripsi;

class SkripsisTable
{
    public static function configure(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('nim')->label('NIM')->searchable()->sortable(),
            TextColumn::make('mahasiswa.nama')->label('Nama Mahasiswa')->searchable(),
            TextColumn::make('judul')->limit(30),
            TextColumn::make('tanggal')->date()->sortable(),
            TextColumn::make('notifikasi_whatsapp')
                ->label('WA')
                ->formatStateUsing(fn ($state) => $state ? 'Terkirim' : 'Belum')
                ->badge()
                ->color(fn ($state) => $state === 'Terkirim' ? 'success' : 'gray'),
            TextColumn::make('status_dokumen')
                ->label('Berkas')
                ->state(function (Skripsi $record): string {
                    return ($record->bukti_bayar && $record->transkrip_nilai && $record->toefl) ? 'Lengkap' : 'Belum Lengkap';
                })
                ->badge()
                ->color(fn ($state) => $state === 'Lengkap' ? 'success' : 'warning'),
        ])
        ->actions([
            EditAction::make(),
            
            Action::make('generateKesediaan')
                ->label('Surat Kesediaan')
                ->icon('heroicon-o-document-text')
                ->color('info')
                ->visible(fn (Skripsi $record) => $record->canDownloadKesediaan())
                ->action(function (Skripsi $record) {
                    $user = auth()->user();
                    $mahasiswa = $record->mahasiswa;
                    $prodi = $mahasiswa->programStudi;

                    $filename = 'surat_kesediaan_sidang_' . $record->nim . '_' . time() . '.pdf';
                    $path = 'pdf/surat/' . $filename;

                    $surat = \App\Models\Surat::create([
                        'jenis_surat' => 'Surat Kesediaan Sidang Skripsi',
                        'no_surat' => 'UN1/FP/KES-SKR-' . rand(100, 999) . '/2026',
                        'tujuan_surat' => $mahasiswa->nama,
                        'file_path' => $path,
                    ]);

                    $data = [
                        'skripsi' => $record,
                        'mahasiswa' => $mahasiswa,
                        'prodi' => $prodi,
                        'surat' => $surat,
                        'with_signature' => true,
                        'ttd_path' => $prodi->ttd_ketua_prodi ?? null,
                        'ketua_nama' => $prodi->ketuaProdi?->nama ?? null,
                        'ketua_nip' => $prodi->ketuaProdi?->nidn ?? null,
                    ];

                    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.surat-kesediaan-sidang', $data);

                    \Illuminate\Support\Facades\Storage::disk('public')->put($path, $pdf->output());

                    $record->update(['surat_kesediaan_id' => $surat->id]);

                    return response()->streamDownload(fn () => print($pdf->output()), $filename);
                }),

            Action::make('validateKesediaan')
                ->label('Validasi Kesediaan')
                ->icon('heroicon-o-check-badge')
                ->color('success')
                ->requiresConfirmation()
                ->visible(fn (Skripsi $record) => $record->file_kesediaan && !$record->is_kesediaan_valid)
                ->action(function (Skripsi $record) {
                    $record->update(['is_kesediaan_valid' => true]);
                    \Filament\Notifications\Notification::make()
                        ->title('Surat Kesediaan Skripsi divalidasi')
                        ->success()
                        ->send();
                }),

            Action::make('generateUndangan')
                ->label('Surat Undangan')
                ->icon('heroicon-o-document-arrow-down')
                ->color('success')
                ->visible(fn (Skripsi $record) => $record->is_kesediaan_valid)
                ->action(function (Skripsi $record) {
                    $user = auth()->user();
                    $mahasiswa = $record->mahasiswa;
                    $prodi = $mahasiswa->programStudi;

                    $filename = 'surat_undangan_sidang_' . $record->nim . '_' . time() . '.pdf';
                    $path = 'pdf/surat/' . $filename;

                    $surat = \App\Models\Surat::create([
                        'jenis_surat' => 'Undangan Sidang Skripsi',
                        'no_surat' => 'UN1/FP/SKR-' . rand(100, 999) . '/2026',
                        'tujuan_surat' => $mahasiswa->nama,
                        'file_path' => $path,
                    ]);

                    $data = [
                        'skripsi' => $record,
                        'mahasiswa' => $mahasiswa,
                        'surat' => $surat,
                        'with_signature' => $user->hasAnyRole(['admin', 'kaprodi']),
                        'ttd_path' => $prodi->ttd_ketua_prodi,
                        'ketua_nama' => $prodi->ketuaProdi?->nama,
                        'ketua_nip' => $prodi->ketuaProdi?->nidn,
                    ];

                    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.surat-undangan-sidang', $data);

                    \Illuminate\Support\Facades\Storage::disk('public')->put($path, $pdf->output());

                    $record->update(['surat_undangan_id' => $surat->id]);

                    return response()->streamDownload(fn () => print($pdf->output()), $filename);
                }),

            Action::make('kirimWa')
                ->label('Kirim WA')
                ->icon('heroicon-o-chat-bubble-left-ellipsis')
                ->color('success')
                ->form([
                    \Filament\Forms\Components\Textarea::make('message')
                        ->label('Pesan WhatsApp')
                        ->rows(5)
                        ->default(function (Skripsi $record) {
                            $hour = now()->format('H');
                            $greeting = ($hour < 12) ? 'pagi' : (($hour < 15) ? 'siang' : (($hour < 18) ? 'sore' : 'malam'));
                            $mahasiswa = $record->mahasiswa;
                            $brandText = "kami dari Fakultas Pertanian, Sains dan Teknologi Universitas Panca Bhakti Pontianak.";
                            
                            if ($record->is_kesediaan_valid) {
                                return "Selamat {$greeting} " . ($mahasiswa->nama ?? '') . ". {$brandText} Surat Undangan Sidang Skripsi Anda sudah dapat didownload pada sistem informasi FPST UPB. Terima Kasih.";
                            } elseif ($record->file_kesediaan) {
                                return "Selamat {$greeting} " . ($mahasiswa->nama ?? '') . ". {$brandText} Surat Kesediaan Sidang Skripsi Anda sedang divalidasi. Mohon cek berkala. Terima Kasih.";
                            } elseif ($record->surat_kesediaan_id) {
                                return "Selamat {$greeting} " . ($mahasiswa->nama ?? '') . ". {$brandText} Surat Kesediaan Sidang Skripsi sudah dapat diunduh di sistem. Silakan diprint dan dimintakan tanda tangan tim sidang skripsi (Pembimbing & Penguji), lalu unggah kembali scan surat tersebut ke portal. Terima Kasih.";
                            } else {
                                return "Selamat {$greeting} " . ($mahasiswa->nama ?? '') . ". {$brandText} Pendaftaran skripsi Anda sedang dalam proses verifikasi staff. Terima Kasih.";
                            }
                        })
                        ->required(),
                ])
                ->modalHeading('Kirim Notifikasi WhatsApp')
                ->modalDescription('Tinjau dan ubah isi pesan sebelum mengirim.')
                ->action(function (Skripsi $record, array $data) {
                    \App\Jobs\SendWhatsAppNotification::dispatch($record, 'skripsi', $data['message']);
                    \Filament\Notifications\Notification::make()
                        ->title('Notifikasi WA sedang dikirim')
                        ->success()
                        ->send();
                }),
        ])
        ->toolbarActions([
            BulkActionGroup::make([DeleteBulkAction::make()]),
        ]);
    }
}
