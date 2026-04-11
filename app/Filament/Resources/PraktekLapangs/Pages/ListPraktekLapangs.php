<?php

namespace App\Filament\Resources\PraktekLapangs\Pages;

use App\Filament\Resources\PraktekLapangs\PraktekLapangResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPraktekLapangs extends ListRecords
{
    protected static string $resource = PraktekLapangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
