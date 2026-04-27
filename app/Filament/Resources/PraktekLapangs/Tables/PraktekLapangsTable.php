<?php

namespace App\Filament\Resources\PraktekLapangs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PraktekLapangsTable
{
    public static function configure(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('nim')->label('NIM')->searchable()->sortable(),
            TextColumn::make('mahasiswa.nama')->label('Nama Mahasiswa')->searchable(),
            TextColumn::make('lokasi')->searchable(),
            TextColumn::make('dosenPembimbing.nama')->label('Pembimbing PL'),
            TextColumn::make('notifikasi_whatsapp')
                ->label('WA')
                ->formatStateUsing(fn ($state) => $state ? 'Terkirim' : 'Belum')
                ->badge()
                ->color(fn ($state) => $state === 'Terkirim' ? 'success' : 'gray'),
            TextColumn::make('status_dokumen')
                ->label('Berkas')
                ->state(function (\App\Models\PraktekLapang $record): string {
                    return ($record->bukti_bayar && $record->lokasi && $record->dosen_pembimbing_id) ? 'Lengkap' : 'Belum Lengkap';
                })
                ->badge()
                ->color(fn ($state) => $state === 'Lengkap' ? 'success' : 'warning'),
        ])
        ->actions([
            \Filament\Tables\Actions\EditAction::make(),
            \Filament\Tables\Actions\Action::make('generateKesediaan')
                ->label('Surat Kesediaan')
                ->icon('heroicon-o-document-text')
                ->color('info')
                ->visible(fn (\App\Models\PraktekLapang $record) => $record->canGenerateSurat())
                ->action(function (\App\Models\PraktekLapang $record) {
                    $mahasiswa = $record->mahasiswa;
                    $prodi = $mahasiswa->programStudi;

                    $filename = 'surat_kesediaan_pl_' . $record->nim . '_' . time() . '.pdf';
                    $path = 'pdf/surat/' . $filename;

                    $surat = \App\Models\Surat::create([
                        'jenis_surat' => 'Surat Kesediaan PL',
                        'no_surat' => 'UN1/FP/KES-PL-' . rand(100, 999) . '/2026',
                        'tujuan_surat' => $mahasiswa->nama,
                        'file_path' => $path,
                    ]);

                    $data = [
                        'praktekLapang' => $record,
                        'mahasiswa' => $mahasiswa,
                        'prodi' => $prodi,
                        'surat' => $surat,
                        'with_signature' => true,
                        'ttd_path' => $prodi->ttd_ketua_prodi ?? null,
                        'ketua_nama' => $prodi->ketuaProdi?->nama ?? null,
                        'ketua_nip' => $prodi->ketuaProdi?->nidn ?? null,
                    ];

                    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.surat-kesediaan-pl', $data);

                    \Illuminate\Support\Facades\Storage::disk('public')->put($path, $pdf->output());

                    $record->update(['surat_id' => $surat->id]);

                    return response()->streamDownload(fn () => print($pdf->output()), $filename);
                }),

            \Filament\Tables\Actions\Action::make('generateSuratJalan')
                ->label('Surat Jalan')
                ->icon('heroicon-o-truck')
                ->color('success')
                ->visible(fn (\App\Models\PraktekLapang $record) => $record->canGenerateSurat())
                ->action(function (\App\Models\PraktekLapang $record) {
                    $mahasiswa = $record->mahasiswa;
                    $prodi = $mahasiswa->programStudi;

                    $filename = 'surat_jalan_pl_' . $record->nim . '_' . time() . '.pdf';
                    $path = 'pdf/surat/' . $filename;

                    $surat = \App\Models\Surat::create([
                        'jenis_surat' => 'Surat Jalan PL',
                        'no_surat' => 'UN1/FP/SJ-PL-' . rand(100, 999) . '/2026',
                        'tujuan_surat' => $mahasiswa->nama,
                        'file_path' => $path,
                    ]);

                    $data = [
                        'praktekLapang' => $record,
                        'mahasiswa' => $mahasiswa,
                        'prodi' => $prodi,
                        'surat' => $surat,
                        'with_signature' => true,
                        'ttd_path' => $prodi->ttd_ketua_prodi ?? null,
                        'ketua_nama' => $prodi->ketuaProdi?->nama ?? null,
                        'ketua_nip' => $prodi->ketuaProdi?->nidn ?? null,
                    ];

                    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.surat-jalan-pl', $data);

                    \Illuminate\Support\Facades\Storage::disk('public')->put($path, $pdf->output());

                    $record->update(['surat_jalan_id' => $surat->id]);

                    return response()->streamDownload(fn () => print($pdf->output()), $filename);
                }),

            \Filament\Tables\Actions\Action::make('kirimWa')
                ->label('Kirim WA')
                ->icon('heroicon-o-chat-bubble-left-ellipsis')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Kirim Notifikasi WhatsApp')
                ->modalDescription('Apakah Anda yakin ingin mengirim notifikasi WA ke mahasiswa ini?')
                ->visible(function (\App\Models\PraktekLapang $record) {
                    return ($record->bukti_bayar && $record->lokasi && $record->dosen_pembimbing_id);
                })
                ->action(function (\App\Models\PraktekLapang $record) {
                    \App\Jobs\SendWhatsAppNotification::dispatch($record, 'praktek_lapang');
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
