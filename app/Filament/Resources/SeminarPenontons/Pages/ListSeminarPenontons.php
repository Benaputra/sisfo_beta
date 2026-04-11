<?php

namespace App\Filament\Resources\SeminarPenontons\Pages;

use App\Filament\Resources\SeminarPenontons\SeminarPenontonResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSeminarPenontons extends ListRecords
{
    protected static string $resource = SeminarPenontonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
