<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;

class PreOrderPanelProvider extends PanelProvider
{
    // Note: Filament panels require authentication by default
    // For a public pre-order form, we'll use a standalone Livewire component
    // This provider is kept for potential future use but won't be registered
    public function panel(Panel $panel): Panel
    {
        // This won't be used - public forms need to be standalone
        return $panel;
    }
}

