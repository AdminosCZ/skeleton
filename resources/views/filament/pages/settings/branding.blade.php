<x-filament-panels::page>
    <form wire:submit="save" class="space-y-6">
        {{ $this->form }}

        <div class="flex items-center justify-between gap-3">
            <div>
                {{ $this->resetToDefaultsAction }}
            </div>

            <x-filament::button type="submit" size="lg">
                {{ __('common.actions.save') }}
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
