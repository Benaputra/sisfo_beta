<?php

namespace App\Filament\Resources\Skripsis\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
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
        ->recordActions([
            \Filament\Tables\Actions\EditAction::make(),
            \Filament\Tables\Actions\Action::make('kirimWa')
                ->label('Kirim WA')
                ->icon('heroicon-o-chat-bubble-left-ellipsis')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Kirim Notifikasi WhatsApp')
                ->modalDescription('Apakah Anda yakin ingin mengirim notifikasi WA ke mahasiswa ini?')
                ->visible(function (Skripsi $record) {
                    return ($record->bukti_bayar && $record->transkrip_nilai && $record->toefl);
                })
                ->action(function (Skripsi $record) {
                    \App\Jobs\SendWhatsAppNotification::dispatch($record, 'skripsi');
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
