<?php

namespace App\Filament\Resources\Surats\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SuratsTable
{
    public static function configure(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('no_surat')->searchable()->sortable(),
            TextColumn::make('jenis_surat')->searchable(),
            TextColumn::make('tujuan_surat')->searchable(),
            TextColumn::make('created_at')->dateTime()->label('Tanggal Buat'),
        ])
        ->recordActions([EditAction::make()])
        ->toolbarActions([
            BulkActionGroup::make([DeleteBulkAction::make()]),
        ]);
    }
}
