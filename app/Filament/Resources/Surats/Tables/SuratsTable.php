<?php

namespace App\Filament\Resources\Surats\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
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
        ->actions([
            Action::make('viewPdf')
                ->label('Lihat PDF')
                ->icon('heroicon-o-eye')
                ->color('info')
                ->url(fn ($record) => $record->file_path ? asset('storage/' . $record->file_path) : null)
                ->openUrlInNewTab()
                ->visible(fn ($record) => !empty($record->file_path)),
            EditAction::make(),
        ])
        ->toolbarActions([
            BulkActionGroup::make([DeleteBulkAction::make()]),
        ]);
    }
}
