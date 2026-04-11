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
            TextColumn::make('status_dokumen')
                ->label('Berkas')
                ->state(function (Skripsi $record): string {
                    return ($record->bukti_bayar && $record->transkrip_nilai && $record->toefl) ? 'Lengkap' : 'Belum Lengkap';
                })
                ->badge()
                ->color(fn ($state) => $state === 'Lengkap' ? 'success' : 'warning'),
        ])
        ->recordActions([EditAction::make()])
        ->toolbarActions([
            BulkActionGroup::make([DeleteBulkAction::make()]),
        ]);
    }
}
