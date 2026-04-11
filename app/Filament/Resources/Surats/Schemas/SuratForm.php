<?php

namespace App\Filament\Resources\Surats\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SuratForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('jenis_surat')->required()->maxLength(255),
            TextInput::make('no_surat')->required()->maxLength(255),
            TextInput::make('tujuan_surat')->required()->maxLength(255),
        ]);
    }
}
