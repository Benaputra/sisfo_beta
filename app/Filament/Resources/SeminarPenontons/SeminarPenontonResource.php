<?php

namespace App\Filament\Resources\SeminarPenontons;

use App\Filament\Resources\SeminarPenontons\Pages\CreateSeminarPenonton;
use App\Filament\Resources\SeminarPenontons\Pages\EditSeminarPenonton;
use App\Filament\Resources\SeminarPenontons\Pages\ListSeminarPenontons;
use App\Filament\Resources\SeminarPenontons\Schemas\SeminarPenontonForm;
use App\Filament\Resources\SeminarPenontons\Tables\SeminarPenontonsTable;
use App\Models\SeminarPenonton;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Support\Icons\Heroicon;

class SeminarPenontonResource extends Resource
{
    protected static ?string $model = SeminarPenonton::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTicket;
    protected static string|\UnitEnum|null $navigationGroup = 'Administrasi';
    protected static ?string $navigationLabel = 'Presensi Seminar';

    public static function form(Schema $schema): Schema { return SeminarPenontonForm::configure($schema); }
    public static function table(Table $table): Table { return SeminarPenontonsTable::configure($table); }

    public static function getPages(): array
    {
        return [
            'index' => ListSeminarPenontons::route('/'),
            'create' => CreateSeminarPenonton::route('/create'),
            'edit' => EditSeminarPenonton::route('/{record}/edit'),
        ];
    }
}
