<?php

namespace App\Filament\Resources\Seminars\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use App\Models\Seminar;
use App\Models\Surat;
use App\Jobs\SendWhatsAppNotification;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class SeminarsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nim')->label('NIM')->searchable()->sortable(),
                TextColumn::make('mahasiswa.nama')->label('Nama Mahasiswa')->searchable(),
                TextColumn::make('judul')->limit(20),
                
                TextColumn::make('notifikasi_whatsapp')
                    ->label('WA')
                    ->formatStateUsing(fn ($state) => $state ? 'Terkirim' : 'Belum')
                    ->badge()
                    ->color(fn ($state) => $state === 'Terkirim' ? 'success' : 'gray'),

                TextColumn::make('is_kesediaan_valid')
                    ->label('Kesediaan')
                    ->formatStateUsing(fn ($state) => $state ? 'Valid' : 'Pending')
                    ->badge()
                    ->color(fn ($state) => $state ? 'success' : 'warning'),

                TextColumn::make('status_kelengkapan')
                    ->label('Status Undangan')
                    ->state(fn (Seminar $record) => $record->canGenerateSurat() ? 'Siap' : 'Belum')
                    ->badge()
                    ->color(fn ($state) => $state === 'Siap' ? 'success' : 'warning'),
            ])
            ->filters([])
            ->recordActions([
                EditAction::make(),
                
                Action::make('generatePDF')
                    ->label('Surat Undangan')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('success')
                    ->visible(fn (Seminar $record) => $record->canGenerateSurat())
                    ->action(function (Seminar $record) {
                        $user = auth()->user();
                        $prodi = $record->mahasiswa->programStudi;
                        
                        $surat = Surat::create([
                            'jenis_surat' => 'Undangan Seminar',
                            'no_surat' => 'UN1/FP/STUDI-' . rand(100, 999) . '/2026',
                            'tujuan_surat' => $record->mahasiswa->nama,
                        ]);

                        $data = [
                            'seminar' => $record,
                            'mahasiswa' => $record->mahasiswa,
                            'surat' => $surat,
                            'with_signature' => $user->hasAnyRole(['admin', 'kaprodi']),
                            'ttd_path' => $prodi->ttd_ketua_prodi,
                            'ketua_nama' => $prodi->ketuaProdi?->nama,
                            'ketua_nip' => $prodi->ketuaProdi?->nidn,
                        ];

                        $pdf = Pdf::loadView('pdf.surat-undangan-seminar', $data);
                        $filename = 'surat_undangan_' . $record->nim . '_' . time() . '.pdf';
                        $path = 'pdf/surat/' . $filename;

                        Storage::disk('public')->put($path, $pdf->output());

                        $record->update(['surat_undangan_id' => $surat->id]);

                        // DISPATCH NOTIFIKASI WHATSAPP
                        SendWhatsAppNotification::dispatch($record, 'seminar');

                        return response()->streamDownload(function () use ($pdf) {
                            echo $pdf->stream();
                        }, $filename);
                    }),

                Action::make('validateKesediaan')
                    ->label('Validasi Kesediaan')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Validasi Surat Kesediaan')
                    ->modalDescription('Apakah Anda yakin ingin memvalidasi surat kesediaan ini? Data akan otomatis diteruskan ke tabel skripsi dengan status menunggu.')
                    ->visible(fn (Seminar $record) => $record->file_kesediaan && !$record->is_kesediaan_valid)
                    ->action(function (Seminar $record) {
                        $record->update(['is_kesediaan_valid' => true]);
                        
                        \App\Models\Skripsi::updateOrCreate(
                            ['nim' => $record->nim],
                            [
                                'judul' => $record->judul,
                                'pembimbing1_id' => $record->pembimbing1_id,
                                'pembimbing2_id' => $record->pembimbing2_id,
                                'status' => 'menunggu',
                                'pengajuan_judul_id' => $record->pengajuan_judul_id,
                            ]
                        );

                        \Filament\Notifications\Notification::make()
                            ->title('Surat kesediaan divalidasi & data diteruskan ke skripsi')
                            ->success()
                            ->send();
                    }),

                Action::make('kirimWa')
                    ->label('Kirim WA')
                    ->icon('heroicon-o-chat-bubble-left-ellipsis')
                    ->color('success')
                    ->form([
                        \Filament\Forms\Components\Textarea::make('message')
                            ->label('Pesan WhatsApp')
                            ->rows(5)
                            ->default(function (Seminar $record) {
                                $hour = now()->format('H');
                                $greeting = ($hour < 12) ? 'pagi' : (($hour < 15) ? 'siang' : (($hour < 18) ? 'sore' : 'malam'));
                                $mahasiswa = $record->mahasiswa;
                                $brandText = "kami dari Fakultas Pertanian, Sains dan Teknologi Universitas Panca Bhakti Pontianak.";
                                
                                if ($record->canGenerateSurat()) {
                                    return "Selamat {$greeting} " . ($mahasiswa->nama ?? '') . ". {$brandText} Surat Undangan seminar sudah dapat didownload pada sistem informasi FPST UPB. Terima Kasih.";
                                } elseif ($record->file_kesediaan) {
                                    return "Selamat {$greeting} " . ($mahasiswa->nama ?? '') . ". {$brandText} Surat Kesediaan Bimbingan Anda sedang divalidasi. Mohon cek berkala untuk mengunduh Surat Undangan Seminar jika sudah disetujui. Terima Kasih.";
                                } elseif ($record->canDownloadKesediaan()) {
                                    return "Selamat {$greeting} " . ($mahasiswa->nama ?? '') . ". {$brandText} Surat Kesediaan Bimbingan sudah dapat diunduh di sistem. Silakan diprint dan dimintakan tanda tangan dosen pembimbing, lalu unggah kembali scan surat tersebut ke portal. Terima Kasih.";
                                } else {
                                    return "Selamat {$greeting} " . ($mahasiswa->nama ?? '') . ". {$brandText} Pendaftaran seminar Anda sedang dalam proses verifikasi staff. Terima Kasih.";
                                }
                            })
                            ->required(),
                    ])
                    ->modalHeading('Kirim Notifikasi WhatsApp')
                    ->modalDescription('Tinjau dan ubah isi pesan sebelum mengirim.')
                    ->action(function (Seminar $record, array $data) {
                        \App\Jobs\SendWhatsAppNotification::dispatch($record, 'seminar', $data['message']);
                        
                        \Filament\Notifications\Notification::make()
                            ->title('Notifikasi WA sedang dikirim')
                            ->success()
                            ->send();
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
