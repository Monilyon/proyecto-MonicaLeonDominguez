@props([
'sidebar' => false,
])

<!-- Movil true -->
@if($sidebar)
<flux:sidebar.brand name="Panel de administración" {{ $attributes }} style="font-weight: bolder;">
    <x-slot name="logo" class="flex aspect-square size-10 items-center justify-center ">
        <img src="{{ asset('logo panel admin.png') }}" class="size-10 fill-current text-white " />
    </x-slot>
</flux:sidebar.brand>
<!-- Desktop -->
@else
<flux:brand name="Panel de administración" {{ $attributes }} style="font-weight: bolder;">
    <x-slot name="logo" class="flex aspect-square size-10 items-center justify-center ">
        <img src="{{ asset('logo panel admin.png') }}" class="size-10 fill-current text-white " />
    </x-slot>
</flux:brand>
@endif
