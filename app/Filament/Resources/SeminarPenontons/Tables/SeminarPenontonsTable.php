<?php

namespace App\Filament\Resources\SeminarPenontons\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SeminarPenontonsTable
{
    public static function configure(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('nim')->label('NIM')->searchable()->sortable(),
            TextColumn::make('mahasiswa.nama')->label('Nama Mahasiswa')->searchable(),
            TextColumn::make('tanggal_nonton')->date()->sortable(),
        ])
        ->recordActions([EditAction::make()])
        ->toolbarActions([
            BulkActionGroup::make([DeleteBulkAction::make()]),
        ]);
    }
}
