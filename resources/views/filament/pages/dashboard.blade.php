<x-filament-panels::page>
    <div class="space-y-6">
        {{ $this->headerWidgets }}
        
        <div class="grid grid-cols-1 gap-6">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Welcome to The Missing Sock Photography Admin</h2>
                <p class="text-gray-600 dark:text-gray-400">
                    Manage your school photography pre-orders, registrations, and orders from this dashboard.
                </p>
            </div>
        </div>

        {{ $this->footerWidgets }}
    </div>
</x-filament-panels::page>

