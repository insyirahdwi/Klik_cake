<?php

namespace App\Filament\Resources\CustomPages\Pages;

use App\Filament\Resources\CustomPages\PageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManagePages extends ManageRecords
{
    protected static string $resource = PageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
