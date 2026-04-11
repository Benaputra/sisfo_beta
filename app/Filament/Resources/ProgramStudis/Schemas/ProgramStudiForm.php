<?php

namespace App\Filament\Resources\ProgramStudis\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ProgramStudiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('nama')->required()->maxLength(255),
            Select::make('ketua_prodi')
                ->label('Ketua Program Studi')
                ->relationship('ketuaProdi', 'nama')
                ->searchable()
                ->preload(),
            FileUpload::make('ttd_ketua_prodi')
                ->label('TTD Digital Ketua')
                ->disk('public')
                ->directory('prodi/ttd'),
        ]);
    }
}
