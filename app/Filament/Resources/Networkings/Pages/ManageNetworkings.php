<?php

namespace App\Filament\Resources\Networkings\Pages;

use App\Filament\Resources\Networkings\NetworkingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageNetworkings extends ManageRecords
{
    protected static string $resource = NetworkingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
