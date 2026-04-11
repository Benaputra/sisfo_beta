<?php

namespace App\Filament\Resources\PraktekLapangs;

use App\Filament\Resources\PraktekLapangs\Pages\CreatePraktekLapang;
use App\Filament\Resources\PraktekLapangs\Pages\EditPraktekLapang;
use App\Filament\Resources\PraktekLapangs\Pages\ListPraktekLapangs;
use App\Filament\Resources\PraktekLapangs\Schemas\PraktekLapangForm;
use App\Filament\Resources\PraktekLapangs\Tables\PraktekLapangsTable;
use App\Models\PraktekLapang;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Support\Icons\Heroicon;

class PraktekLapangResource extends Resource
{
    protected static ?string $model = PraktekLapang::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTruck;
    protected static ?string $navigationLabel = 'Praktek Lapang';

    public static function form(Schema $schema): Schema { return PraktekLapangForm::configure($schema); }
    public static function table(Table $table): Table { return PraktekLapangsTable::configure($table); }

    public static function getPages(): array
    {
        return [
            'index' => ListPraktekLapangs::route('/'),
            'create' => CreatePraktekLapang::route('/create'),
            'edit' => EditPraktekLapang::route('/{record}/edit'),
        ];
    }
}
