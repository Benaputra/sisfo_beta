<?php

namespace App\Filament\Resources\Mahasiswas;

use App\Filament\Resources\Mahasiswas\Pages\CreateMahasiswa;
use App\Filament\Resources\Mahasiswas\Pages\EditMahasiswa;
use App\Filament\Resources\Mahasiswas\Pages\ListMahasiswas;
use App\Filament\Resources\Mahasiswas\Schemas\MahasiswaForm;
use App\Filament\Resources\Mahasiswas\Tables\MahasiswasTable;
use App\Models\Mahasiswa;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Support\Icons\Heroicon;

class MahasiswaResource extends Resource
{
    protected static ?string $model = Mahasiswa::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;
    protected static ?string $recordTitleAttribute = 'nama';

    public static function form(Schema $schema): Schema { return MahasiswaForm::configure($schema); }
    public static function table(Table $table): Table { return MahasiswasTable::configure($table); }

    public static function getPages(): array
    {
        return [
            'index' => ListMahasiswas::route('/'),
            'create' => CreateMahasiswa::route('/create'),
            'edit' => EditMahasiswa::route('/{record}/edit'),
        ];
    }
}
