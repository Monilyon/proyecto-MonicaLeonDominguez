<div>
    <x-layouts::app :title="__('Crear Evento')">
        <div class="flex w-full min-h-screen">
            <div class="flex-1 ">

                {{-- Encabezado --}}
                <div class="flex justify-center w-full" style="background-color: #d1d9c1;">

                    <div class="flex flex-col">
                        <h1 class="text-3xl font-bold text-zinc-800 tracking-tight">Crear nuevo evento</h1>
                        <p class="text-zinc-500">Completa la información para publicar un nuevo evento en la plataforma.</p>
                    </div>

                </div>

                {{-- Card del Formulario --}}
                <div class="bg-white p-4 rounded-[2.5rem] border border-zinc-200 shadow-sm w-full">
                    <form action="{{ route('events.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Título del evento --}}
                            <flux:input label="Título del evento" placeholder="Ej: Via Ferrata Nocturna" name="name" required />

                            {{-- Tipo de evento --}}
                            <flux:select label="Tipo de evento" name="id_type" placeholder="Selecciona un tipo">
                                @foreach($types as $type)
                                <flux:select.option value="{{ $type->id }}">{{ $type->name }}</flux:select.option>
                                @endforeach
                            </flux:select>

                            {{-- Fecha --}}
                            <flux:input type="date" label="Fecha del evento" name="date" required />

                            {{-- Ubicación --}}
                            <flux:input label="Ubicación" placeholder="Ej: Castellón" name="location" icon="map-pin" required />

                            {{-- Capacidad --}}
                            <flux:input type="number" label="Capacidad" name="capacity" placeholder="Ej: 20" required min="1" />

                        </div>

                        {{-- Descripción --}}
                        <flux:textarea label="Descripción del evento" placeholder="Detalla las actividades, requisitos..." name="description" rows="5" />

                        {{-- Botones de acción --}}
                        <div class="flex justify-between gap-4 border-t border-zinc-100 pt-6">
                            <flux:button href="{{ route('dashboard') }}" variant="subtle" icon="arrow-left" size="sm">
                                Volver al panel
                            </flux:button>
                            <div>
                                <flux:button href="{{ route('dashboard') }}" variant="ghost">Cancelar</flux:button>
                                <flux:button type="submit" variant="filled" class="bg-[#f2f4e8] text-zinc-700 hover:bg-zinc-200 border-none shadow-none font-bold">
                                    Publicar Evento
                                </flux:button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-layouts::app>
</div>
