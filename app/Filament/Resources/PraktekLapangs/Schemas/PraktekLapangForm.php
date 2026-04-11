<?php

namespace App\Filament\Resources\PraktekLapangs\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PraktekLapangForm
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
            TextInput::make('lokasi')->required()->maxLength(255),
            FileUpload::make('laporan')->disk('public')->directory('pl/laporan'),
            FileUpload::make('bukti_bayar')->disk('public')->directory('pl/bukti'),
            Select::make('dosen_pembimbing_id')
                ->label('Dosen Pembimbing')
                ->relationship('dosenPembimbing', 'nama')
                ->searchable()
                ->required(),
        ]);
    }
}
