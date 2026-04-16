<?php

namespace App\Filament\Resources\Skripsis\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Get;
use App\Models\Dosen;

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
            Select::make('pembimbing1_id')
                ->label('Pembimbing 1')
                ->options(fn (Get $get) => Dosen::query()
                    ->where('id', '!=', $get('pembimbing2_id'))
                    ->where('id', '!=', $get('penguji1_id'))
                    ->where('id', '!=', $get('penguji2_id'))
                    ->orderBy('nama')
                    ->pluck('nama', 'id'))
                ->searchable()
                ->live()
                ->required(),
            Select::make('pembimbing2_id')
                ->label('Pembimbing 2')
                ->options(fn (Get $get) => Dosen::query()
                    ->where('id', '!=', $get('pembimbing1_id'))
                    ->where('id', '!=', $get('penguji1_id'))
                    ->where('id', '!=', $get('penguji2_id'))
                    ->orderBy('nama')
                    ->pluck('nama', 'id'))
                ->searchable()
                ->live(),
            Select::make('penguji1_id')
                ->label('Penguji 1')
                ->options(fn (Get $get) => Dosen::query()
                    ->where('id', '!=', $get('pembimbing1_id'))
                    ->where('id', '!=', $get('pembimbing2_id'))
                    ->where('id', '!=', $get('penguji2_id'))
                    ->orderBy('nama')
                    ->pluck('nama', 'id'))
                ->searchable()
                ->live(),
            Select::make('penguji2_id')
                ->label('Penguji 2')
                ->options(fn (Get $get) => Dosen::query()
                    ->where('id', '!=', $get('pembimbing1_id'))
                    ->where('id', '!=', $get('pembimbing2_id'))
                    ->where('id', '!=', $get('penguji1_id'))
                    ->orderBy('nama')
                    ->pluck('nama', 'id'))
                ->searchable()
                ->live(),
            DatePicker::make('tanggal')->required(),
            TextInput::make('tempat')->required(),
            FileUpload::make('bukti_bayar')->disk('public')->directory('skripsi/bukti'),
            FileUpload::make('transkrip_nilai')->disk('public')->directory('skripsi/transkrip'),
            FileUpload::make('toefl')->label('Sertifikat TOEFL')->disk('public')->directory('skripsi/toefl'),
        ]);
    }
}
