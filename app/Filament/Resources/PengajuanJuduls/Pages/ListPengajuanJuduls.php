<?php

namespace App\Filament\Resources\PengajuanJuduls\Pages;

use App\Filament\Resources\PengajuanJuduls\PengajuanJudulResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPengajuanJuduls extends ListRecords
{
    protected static string $resource = PengajuanJudulResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
