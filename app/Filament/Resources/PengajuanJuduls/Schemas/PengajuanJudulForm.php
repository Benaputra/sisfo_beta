<?php

namespace App\Filament\Resources\PengajuanJuduls\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PengajuanJudulForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('nim')
                    ->label('Mahasiswa')
                    ->relationship('mahasiswa', 'nama')
                    ->searchable()
                    ->required(),
                Textarea::make('judul')
                    ->required()
                    ->columnSpanFull(),
                \Filament\Forms\Components\FileUpload::make('bukti_bayar')
                    ->disk('public')
                    ->directory('bukti_bayar_judul')
                    ->columnSpanFull(),
                TextInput::make('no_surat'),
                TextInput::make('surat_kesediaan'),
                Select::make('status')
                    ->options(['pending' => 'Pending', 'disetujui' => 'Disetujui', 'ditolak' => 'Ditolak'])
                    ->default('pending')
                    ->required(),
                Textarea::make('keterangan')
                    ->columnSpanFull(),
                Select::make('pembimbing1_id')
                    ->label('Pembimbing 1')
                    ->relationship('pembimbing1', 'nama')
                    ->searchable(),
                Select::make('pembimbing2_id')
                    ->label('Pembimbing 2')
                    ->relationship('pembimbing2', 'nama')
                    ->searchable(),
            ]);
    }
}
