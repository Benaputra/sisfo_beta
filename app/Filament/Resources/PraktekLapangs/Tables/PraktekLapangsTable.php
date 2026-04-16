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
        ->recordActions([
            \Filament\Tables\Actions\EditAction::make(),
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
