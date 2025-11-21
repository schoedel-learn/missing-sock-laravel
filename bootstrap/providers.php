<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\Filament\AdminPanelProvider::class,
    App\Providers\Filament\UserPanelProvider::class,
    App\Providers\Filament\OrganizationCoordinatorPanelProvider::class,
    App\Providers\Filament\PhotoManagerPanelProvider::class,
    // PreOrderPanelProvider not needed - using standalone Livewire component
];
