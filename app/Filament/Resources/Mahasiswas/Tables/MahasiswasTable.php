<?php

namespace App\Filament\Resources\Mahasiswas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MahasiswasTable
{
    public static function configure(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('nim')->label('NIM')->searchable()->sortable(),
            TextColumn::make('nama')->searchable()->sortable(),
            TextColumn::make('programStudi.nama')->label('Prodi')->searchable(),
            TextColumn::make('angkatan')->sortable(),
            TextColumn::make('pembimbingAkademik.nama')->label('Pembimbing PA'),
        ])
        ->recordActions([EditAction::make()])
        ->toolbarActions([
            BulkActionGroup::make([DeleteBulkAction::make()]),
        ]);
    }
}
