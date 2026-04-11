<?php

namespace App\Filament\Resources\Dosens\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DosensTable
{
    public static function configure(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('nama')->searchable()->sortable(),
            TextColumn::make('nidn')->label('NIDN')->searchable()->sortable(),
            TextColumn::make('programStudi.nama')->label('Prodi')->searchable(),
            TextColumn::make('jabatan_fungsional')->label('Jabatan'),
            TextColumn::make('no_hp')->label('No HP'),
        ])
        ->recordActions([EditAction::make()])
        ->toolbarActions([
            BulkActionGroup::make([DeleteBulkAction::make()]),
        ]);
    }
}
