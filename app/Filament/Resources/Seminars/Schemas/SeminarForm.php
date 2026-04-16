<?php

namespace App\Filament\Resources\Seminars\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Get;
use App\Models\Dosen;

class SeminarForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('nim')
                    ->label('Mahasiswa')
                    ->relationship('mahasiswa', 'nama')
                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->nim} - {$record->nama}")
                    ->searchable()
                    ->preload()
                    ->required()
                    ->disabled(fn ($record) => $record !== null && auth()->user()->hasRole('mahasiswa'))
                    ->rules([
                        fn (): \Closure => function (string $attribute, $value, \Closure $fail) {
                            // Validasi 12 kali nonton hanya saat create
                            if (request()->routeIs('*.create')) {
                                $count = \App\Models\SeminarPenonton::where('nim', $value)->count();
                                if ($count < 12) {
                                    $fail("Mahasiswa belum memenuhi syarat (Baru $count/12 kali nonton seminar).");
                                }
                            }
                        },
                    ]),

                TextInput::make('judul')
                    ->required()
                    ->maxLength(255)
                    ->disabled(fn ($record) => $record !== null && auth()->user()->hasRole('mahasiswa')),

                Select::make('pembimbing1_id')
                    ->label('Pembimbing 1')
                    ->options(fn (Get $get) => Dosen::query()
                        ->where('id', '!=', $get('pembimbing2_id'))
                        ->where('id', '!=', $get('penguji_seminar_id'))
                        ->orderBy('nama')
                        ->pluck('nama', 'id'))
                    ->searchable()
                    ->live()
                    ->required()
                    ->disabled(fn ($record) => $record !== null && auth()->user()->hasRole('mahasiswa')),

                Select::make('pembimbing2_id')
                    ->label('Pembimbing 2')
                    ->options(fn (Get $get) => Dosen::query()
                        ->where('id', '!=', $get('pembimbing1_id'))
                        ->where('id', '!=', $get('penguji_seminar_id'))
                        ->orderBy('nama')
                        ->pluck('nama', 'id'))
                    ->searchable()
                    ->live()
                    ->disabled(fn ($record) => $record !== null && auth()->user()->hasRole('mahasiswa')),

                Select::make('penguji_seminar_id')
                    ->label('Penguji Seminar')
                    ->options(fn (Get $get) => Dosen::query()
                        ->where('id', '!=', $get('pembimbing1_id'))
                        ->where('id', '!=', $get('pembimbing2_id'))
                        ->orderBy('nama')
                        ->pluck('nama', 'id'))
                    ->searchable()
                    ->live()
                    ->disabled(fn ($record) => $record !== null && auth()->user()->hasRole('mahasiswa')),

                DatePicker::make('tanggal')
                    ->required()
                    ->disabled(fn ($record) => $record !== null && auth()->user()->hasRole('mahasiswa')),

                TextInput::make('tempat')
                    ->required()
                    ->disabled(fn ($record) => $record !== null && auth()->user()->hasRole('mahasiswa')),

                FileUpload::make('bukti_bayar')
                    ->label('Bukti Bayar')
                    ->disk('public')
                    ->directory('seminar/bukti')
                    ->maxSize(3072)
                    ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png']),

                FileUpload::make('acc_seminar')
                    ->label('File ACC')
                    ->disk('public')
                    ->directory('seminar/acc')
                    ->maxSize(3072)
                    ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png']),

                FileUpload::make('file_kesediaan')
                    ->label('File Kesediaan (Scan TTD)')
                    ->disk('public')
                    ->directory('seminar/kesediaan')
                    ->maxSize(5120)
                    ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                    ->helperText('Diunggah oleh mahasiswa melalui portal'),

                Toggle::make('is_kesediaan_valid')
                    ->label('Validasi Surat Kesediaan')
                    ->helperText('Aktifkan jika tanda tangan dosen sudah valid. Syarat untuk generate Surat Undangan.')
                    ->visible(fn () => auth()->user()->hasAnyRole(['admin', 'staff', 'kaprodi'])),
            ]);
    }
}
