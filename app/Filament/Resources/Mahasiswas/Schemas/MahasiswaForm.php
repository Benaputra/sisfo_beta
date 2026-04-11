<?php

namespace App\Filament\Resources\Mahasiswas\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MahasiswaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('nim')
                ->label('NIM')
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(255),
            TextInput::make('nama')->required()->maxLength(255),
            Select::make('program_studi_id')
                ->relationship('programStudi', 'nama')
                ->required()
                ->searchable(),
            TextInput::make('no_hp')->label('No HP')->tel()->maxLength(255),
            TextInput::make('tempat_lahir')->maxLength(255),
            DatePicker::make('tanggal_lahir'),
            TextInput::make('angkatan')
                ->numeric()
                ->required(),
            Select::make('pembimbing_akademik')
                ->relationship('pembimbingAkademik', 'nama')
                ->searchable(),
        ]);
    }
}
