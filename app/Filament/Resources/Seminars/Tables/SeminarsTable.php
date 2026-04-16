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

                Action::make('kirimWa')
                    ->label('Kirim WA')
                    ->icon('heroicon-o-chat-bubble-left-ellipsis')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Kirim Notifikasi WhatsApp')
                    ->modalDescription('Apakah Anda yakin ingin mengirim notifikasi WA ke mahasiswa ini?')
                    ->visible(fn (Seminar $record) => $record->canGenerateSurat())
                    ->action(function (Seminar $record) {
                        SendWhatsAppNotification::dispatch($record, 'seminar');
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
