<?php

namespace App\Filament\Resources\ProgramStudis\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProgramStudisTable
{
    public static function configure(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('nama')->searchable()->sortable(),
            TextColumn::make('ketuaProdi.nama')->label('Ketua Prodi'),
        ])
        ->recordActions([EditAction::make()])
        ->toolbarActions([
            BulkActionGroup::make([DeleteBulkAction::make()]),
        ]);
    }
}
