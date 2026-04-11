<?php

namespace App\Filament\Resources\SeminarPenontons\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class SeminarPenontonForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('nim')
                ->label('Mahasiswa')
                ->relationship('mahasiswa', 'nama')
                ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->nim} - {$record->nama}")
                ->searchable()
                ->required(),
            DatePicker::make('tanggal_nonton')->required(),
        ]);
    }
}
