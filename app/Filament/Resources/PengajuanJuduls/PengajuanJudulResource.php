<?php

namespace App\Filament\Resources\PengajuanJuduls;

use App\Filament\Resources\PengajuanJuduls\Pages\CreatePengajuanJudul;
use App\Filament\Resources\PengajuanJuduls\Pages\EditPengajuanJudul;
use App\Filament\Resources\PengajuanJuduls\Pages\ListPengajuanJuduls;
use App\Filament\Resources\PengajuanJuduls\Schemas\PengajuanJudulForm;
use App\Filament\Resources\PengajuanJuduls\Tables\PengajuanJudulsTable;
use App\Models\PengajuanJudul;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PengajuanJudulResource extends Resource
{
    protected static ?string $model = PengajuanJudul::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?string $recordTitleAttribute = 'judul';

    protected static ?string $navigationLabel = 'Pengajuan Judul';

    public static function form(Schema $schema): Schema
    {
        return PengajuanJudulForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PengajuanJudulsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPengajuanJuduls::route('/'),
            'create' => CreatePengajuanJudul::route('/create'),
            'edit' => EditPengajuanJudul::route('/{record}/edit'),
        ];
    }
}
