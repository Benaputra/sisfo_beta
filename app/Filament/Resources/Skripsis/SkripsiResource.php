<?php

namespace App\Filament\Resources\Skripsis;

use App\Filament\Resources\Skripsis\Pages\CreateSkripsi;
use App\Filament\Resources\Skripsis\Pages\EditSkripsi;
use App\Filament\Resources\Skripsis\Pages\ListSkripsis;
use App\Filament\Resources\Skripsis\Schemas\SkripsiForm;
use App\Filament\Resources\Skripsis\Tables\SkripsisTable;
use App\Models\Skripsi;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Support\Icons\Heroicon;

class SkripsiResource extends Resource
{
    protected static ?string $model = Skripsi::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;
    protected static ?string $recordTitleAttribute = 'judul';
    protected static ?string $navigationLabel = 'Pendaftaran Skripsi';

    public static function form(Schema $schema): Schema { return SkripsiForm::configure($schema); }
    public static function table(Table $table): Table { return SkripsisTable::configure($table); }

    public static function getPages(): array
    {
        return [
            'index' => ListSkripsis::route('/'),
            'create' => CreateSkripsi::route('/create'),
            'edit' => EditSkripsi::route('/{record}/edit'),
        ];
    }
}
