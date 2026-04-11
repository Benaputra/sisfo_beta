<?php

namespace App\Filament\Resources\Dosens\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DosenForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('nama')->required()->maxLength(255),
            TextInput::make('nidn')->label('NIDN')->required()->unique(ignoreRecord: true)->maxLength(255),
            TextInput::make('nuptk')->label('NUPTK')->maxLength(255),
            Select::make('program_studi_id')
                ->relationship('programStudi', 'nama')
                ->required()
                ->searchable(),
            TextInput::make('no_hp')->label('No HP')->tel()->maxLength(255),
            TextInput::make('tempat_lahir')->maxLength(255),
            DatePicker::make('tanggal_lahir'),
            Select::make('jabatan_fungsional')
                ->options([
                    'Asisten Ahli' => 'Asisten Ahli',
                    'Lektor' => 'Lektor',
                    'Lektor Kepala' => 'Lektor Kepala',
                    'Guru Besar' => 'Guru Besar',
                ]),
        ]);
    }
}
