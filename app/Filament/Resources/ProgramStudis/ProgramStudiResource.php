<?php

namespace App\Filament\Resources\ProgramStudis;

use App\Filament\Resources\ProgramStudis\Pages\CreateProgramStudi;
use App\Filament\Resources\ProgramStudis\Pages\EditProgramStudi;
use App\Filament\Resources\ProgramStudis\Pages\ListProgramStudis;
use App\Filament\Resources\ProgramStudis\Schemas\ProgramStudiForm;
use App\Filament\Resources\ProgramStudis\Tables\ProgramStudisTable;
use App\Models\ProgramStudi;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Support\Icons\Heroicon;

class ProgramStudiResource extends Resource
{
    protected static ?string $model = ProgramStudi::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingLibrary;
    protected static string|\UnitEnum|null $navigationGroup = 'Akademik';

    public static function form(Schema $schema): Schema { return ProgramStudiForm::configure($schema); }
    public static function table(Table $table): Table { return ProgramStudisTable::configure($table); }

    public static function getPages(): array
    {
        return [
            'index' => ListProgramStudis::route('/'),
            'create' => CreateProgramStudi::route('/create'),
            'edit' => EditProgramStudi::route('/{record}/edit'),
        ];
    }
}
