<?php

namespace App\Filament\Resources\PengajuanJuduls\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Get;
use App\Models\Dosen;

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
                    ->options(fn (Get $get) => Dosen::query()
                        ->where('id', '!=', $get('pembimbing2_id'))
                        ->pluck('nama', 'id'))
                    ->searchable()
                    ->live(),
                Select::make('pembimbing2_id')
                    ->label('Pembimbing 2')
                    ->options(fn (Get $get) => Dosen::query()
                        ->where('id', '!=', $get('pembimbing1_id'))
                        ->pluck('nama', 'id'))
                    ->searchable()
                    ->live(),
            ]);
    }
}
