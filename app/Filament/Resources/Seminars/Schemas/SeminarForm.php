<?php

namespace App\Filament\Resources\Seminars\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

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
                    ->relationship('pembimbing1', 'nama')
                    ->searchable()
                    ->required()
                    ->disabled(fn ($record) => $record !== null && auth()->user()->hasRole('mahasiswa')),

                Select::make('pembimbing2_id')
                    ->label('Pembimbing 2')
                    ->relationship('pembimbing2', 'nama')
                    ->searchable()
                    ->disabled(fn ($record) => $record !== null && auth()->user()->hasRole('mahasiswa')),

                Select::make('penguji_seminar_id')
                    ->label('Penguji Seminar')
                    ->relationship('pengujiSeminar', 'nama')
                    ->searchable()
                    ->disabled(fn ($record) => $record !== null && auth()->user()->hasRole('mahasiswa')),

                Select::make('penguji2_id')
                    ->label('Penguji 2')
                    ->relationship('penguji2', 'nama')
                    ->searchable()
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

                Toggle::make('notifikasi_whatsapp')
                    ->label('Kirim Notifikasi WA')
                    ->visible(fn () => auth()->user()->hasAnyRole(['admin', 'staff', 'kaprodi']))
                    ->disabled(fn () => auth()->user()->hasRole('mahasiswa')),
            ]);
    }
}
