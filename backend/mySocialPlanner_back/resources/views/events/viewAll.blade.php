<x-layouts::app :title="__('Todos los eventos')">
    <div class="flex flex-col gap-4 m-0 w-full h-[calc(100vh-2rem)]">
        <div class="w-full bg-white p-4 rounded-[2rem] border border-zinc-200 shadow-sm flex flex-col min-h-0">

            <div class="flex items-center justify-between p-4 shrink-0" style="background-color: #d1d9c1; border-radius: 1.5rem 1.5rem 0 0;">
                <h1 class="text-zinc-800 font-black text-2xl">
                    {{ request('scope') === 'upcoming' ? 'Eventos Activos' : 'Todos los eventos' }}
                </h1>
                <span class="bg-white/50 px-4 py-1 rounded-full text-sm font-bold text-zinc-700">
                    Total: {{ $events->count() }}
                </span>
            </div>

            <!-- Formulario de Filtros Global -->
            <form action="{{ route('events.index') }}" method="GET" class="flex flex-col flex-1 min-h-0">

                <!-- IMPORTANTE: Mantener el filtro de "Activos" si viene del Dashboard -->
                @if(request('scope'))
                    <input type="hidden" name="scope" value="{{ request('scope') }}">
                @endif

                <!-- Contenedor con Tabla -->
                <section class="flex-1 overflow-y-auto p-2 border-t border-zinc-100 bg-zinc-50" style="scrollbar-gutter: stable;">
                    <table class="w-full border-separate border-spacing-y-2 table-fixed">
                        <thead>
                            <tr class="text-zinc-400 text-xs uppercase tracking-widest">
                                <th class="px-6 py-2 text-start w-1/3">Evento</th>
                                <th class="px-6 py-2 text-start w-1/4">Ubicación</th>
                                <th class="px-6 py-2 text-start w-1/4">Fecha</th>
                                <th class="px-6 py-2 text-start w-1/4">Tipo</th>
                                <th class="px-6 py-2 text-center w-1/6">Acciones</th>
                            </tr>
                            <!-- Fila de Inputs de Filtro por Columna -->
                            <tr>
                                <td class="px-4 pb-2">
                                    <input type="text" name="name" value="{{ request('name') }}" placeholder="Buscar nombre..." class="w-full text-xs border-2 border-[#d1d9c1] rounded-lg px-2 py-1 outline-none focus:border-zinc-400">
                                </td>
                                <td class="px-4 pb-2">
                                    <input type="text" name="location" value="{{ request('location') }}" placeholder="Buscar sitio..." class="w-full text-xs border-2 border-[#d1d9c1] rounded-lg px-2 py-1 outline-none focus:border-zinc-400">
                                </td>
                                <td class="px-4 pb-2">
                                    <input type="date" name="date" value="{{ request('date') }}" class="w-full text-xs border-2 border-[#d1d9c1] rounded-lg px-2 py-1 outline-none focus:border-zinc-400">
                                </td>
                                <td class="px-4 pb-2">
                                    <select name="id_type" onchange="this.form.submit()" class="w-full bg-white border-2 border-[#d1d9c1] rounded-lg text-xs py-1 px-2 outline-none">
                                        <option value="">Todos los tipos</option>
                                        @foreach($types as $type)
                                        <option value="{{ $type->id }}" {{ request('id_type') == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="px-4 pb-2 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        {{-- Botón Lupa (Aplicar) --}}
                                        <button type="submit" class="p-1.5 bg-[#d1d9c1] text-zinc-700 rounded-lg hover:bg-[#c2cca9] transition-all shadow-sm shrink-0">
                                            <flux:icon.magnifying-glass variant="micro" class="w-4 h-4" />
                                        </button>

                                        {{-- Botón Limpiar --}}
                                        @if(request()->anyFilled(['name', 'location', 'date', 'id_type', 'scope']))
                                            <a href="{{ route('events.index') }}" class="text-red-500 hover:scale-110 transition-transform" title="Limpiar filtros">
                                                <flux:icon.x-mark variant="micro" class="w-4 h-4" />
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($events as $event)
                            <tr class="bg-white hover:bg-zinc-50 transition-colors shadow-sm text-sm">
                                <td class="px-6 py-5 rounded-l-xl border-y border-l border-zinc-100 align-middle">
                                    <span class="font-bold text-zinc-800 ">{{ $event->name }}</span>
                                </td>
                                <td class="px-6 py-5 border-y border-zinc-100 align-middle">
                                    <div class="flex items-center gap-2 text-zinc-600">
                                        <flux:icon.map-pin variant="micro" class="shrink-0 text-zinc-400" />
                                        <span class="truncate">{{ $event->location }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5 border-y border-zinc-100 align-middle">
                                    <span class="text-zinc-800 font-medium">{{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }}</span>
                                </td>
                                <td class="px-6 py-5 border-y border-zinc-100 align-middle">
                                    <span class="px-2 py-0.5 text-[10px] font-bold bg-zinc-100 text-zinc-600 rounded border border-zinc-200 uppercase tracking-tighter">
                                        {{ $event->type->name }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 rounded-r-xl border-y border-r border-zinc-100 align-middle text-center">
                                    <div class="flex justify-center gap-3">
                                        <a href="{{ route('events.edit', $event->id) }}" class="text-blue-600 hover:scale-110 transition-transform"><flux:icon.pencil-square variant="micro" /></a>
                                        <form action="{{ route('events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este evento?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:scale-110 transition-transform">
                                                <flux:icon.trash variant="micro" />
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-20 text-center text-zinc-400 italic">No se encontraron eventos.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </section>
            </form>

            <div class="pt-4 shrink-0">
                <flux:button href="{{ route('dashboard') }}" variant="subtle" icon="arrow-left" size="sm">Volver al panel</flux:button>
            </div>
        </div>
    </div>
</x-layouts::app>
