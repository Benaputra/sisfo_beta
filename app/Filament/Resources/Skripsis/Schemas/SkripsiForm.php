<?php

namespace App\Filament\Resources\Skripsis\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SkripsiForm
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
            TextInput::make('judul')->required()->maxLength(65535),
            Select::make('pembimbing1_id')->label('Pembimbing 1')->relationship('pembimbing1', 'nama')->searchable()->required(),
            Select::make('pembimbing2_id')->label('Pembimbing 2')->relationship('pembimbing2', 'nama')->searchable(),
            Select::make('penguji1_id')->label('Penguji 1')->relationship('penguji1', 'nama')->searchable(),
            Select::make('penguji2_id')->label('Penguji 2')->relationship('penguji2', 'nama')->searchable(),
            DatePicker::make('tanggal')->required(),
            TextInput::make('tempat')->required(),
            FileUpload::make('bukti_bayar')->disk('public')->directory('skripsi/bukti'),
            FileUpload::make('transkrip_nilai')->disk('public')->directory('skripsi/transkrip'),
            FileUpload::make('toefl')->label('Sertifikat TOEFL')->disk('public')->directory('skripsi/toefl'),
        ]);
    }
}
