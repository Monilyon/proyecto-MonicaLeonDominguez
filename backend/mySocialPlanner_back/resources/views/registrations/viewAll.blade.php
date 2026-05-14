<x-layouts::app :title="__('Solicitudes de Inscripción')">
    <div class="flex flex-col gap-4 m-0 w-full h-[calc(100vh-2rem)]">
        <div class="w-full bg-white p-4 rounded-[2rem] border border-zinc-200 shadow-sm flex flex-col min-h-0">

            <!-- Header con tu color corporativo -->
            <div class="flex items-center justify-between p-4 shrink-0" style="background-color: #d1d9c1; border-radius: 1.5rem 1.5rem 0 0;">
                <h1 class="text-zinc-800 font-black text-2xl">Gestión de Inscripciones</h1>
                <span class="bg-white/50 px-4 py-1 rounded-full text-sm font-bold text-zinc-700">
                    Total: {{ $registrations->count() }}
                </span>
            </div>

            <!-- Formulario con el estilo de tabla de usuarios -->
            <form action="{{ route('registrations.index') }}" method="GET" class="flex flex-col flex-1 min-h-0">
                <section class="flex-1 overflow-y-auto mt-4 p-2 border-t border-zinc-100 bg-zinc-50" style="scrollbar-gutter: stable;">
                    <table class="w-full border-separate border-spacing-y-2 table-fixed">
                        <thead>
                            <tr class="text-zinc-400 text-xs uppercase tracking-widest">
                                <th class="px-6 py-2 text-start w-1/4">Usuario</th>
                                <th class="px-6 py-2 text-start w-1/4">Evento</th>
                                <th class="px-6 py-2 text-start w-1/5">Fecha</th>
                                <th class="px-6 py-2 text-start w-1/4">Estado</th>
                            </tr>
                            <!-- Fila de Filtros Adaptada -->
                            <tr>
                                <td class="px-4 pb-2">
                                    <input type="text" name="user_name" value="{{ request('user_name') }}" placeholder="Filtrar usuario..." class="w-full text-xs border-2 border-[#d1d9c1] rounded-lg px-2 py-1 outline-none">
                                </td>
                                <td class="px-4 pb-2">
                                    <input type="text" name="event_name" value="{{ request('event_name') }}" placeholder="Filtrar evento..." class="w-full text-xs border-2 border-[#d1d9c1] rounded-lg px-2 py-1 outline-none">
                                </td>
                                <td class="px-4 pb-2">
                                    <input type="date" name="reg_date" value="{{ request('reg_date') }}" class="w-full text-xs border-2 border-[#d1d9c1] rounded-lg px-2 py-1 outline-none text-zinc-400">
                                </td>
                                <td class="px-4 pb-2">
                                    <div class="flex items-center gap-2">
                                        <select name="registration_status_id" class="flex-1 text-xs border-2 border-[#d1d9c1] rounded-lg px-2 py-1 outline-none bg-white">
                                            <option value="">Todos</option>
                                            @foreach($statuses as $status)
                                                <option value="{{ $status->id }}" {{ request('registration_status_id') == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                                            @endforeach
                                        </select>

                                        <!-- Botón Lupa (Estilo Usuarios) -->
                                        <button type="submit" class="p-1.5 bg-[#d1d9c1] text-zinc-700 rounded-lg hover:bg-[#c2cca9] transition-all">
                                            <flux:icon.magnifying-glass variant="micro" class="w-4 h-4" />
                                        </button>

                                        @if(request()->anyFilled(['user_name', 'event_name', 'reg_date', 'registration_status_id']))
                                            <a href="{{ route('registrations.index') }}" class="text-red-500 hover:scale-110 transition-transform">
                                                <flux:icon.x-mark variant="micro" class="w-4 h-4" />
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($registrations as $reg)
                            <tr class="bg-white hover:bg-zinc-50 transition-colors shadow-sm text-sm">
                                <td class="px-6 py-4 rounded-l-xl border-y border-l border-zinc-100">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-zinc-800">{{ $reg->user->name }}</span>
                                        <span class="text-[10px] text-zinc-400">{{ $reg->user->email }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 border-y border-zinc-100 font-medium text-zinc-600">
                                    {{ $reg->event->name }}
                                </td>
                                <td class="px-6 py-4 border-y border-zinc-100 text-zinc-500">
                                    {{ \Carbon\Carbon::parse($reg->registration_date)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 rounded-r-xl border-y border-r border-zinc-100">
                                    @php
                                        $color = match($reg->status->name) {
                                            'Aprobada' => 'bg-green-100 text-green-700',
                                            'Cancelada' => 'bg-red-100 text-red-700',
                                            'Rechazada' => 'bg-orange-100 text-orange-700',
                                            default => 'bg-yellow-100 text-yellow-700',
                                        };
                                    @endphp
                                    <span class="px-2 py-1 rounded-md text-[10px] font-black uppercase {{ $color }}">
                                        {{ $reg->status->name }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-20 text-center text-zinc-400 italic">No hay solicitudes registradas.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </section>
            </form>

            <!-- Footer con tu botón original -->
            <div class="pt-4 shrink-0">
                <flux:button href="{{ route('dashboard') }}" variant="subtle" icon="arrow-left" size="sm">Volver al Dashboard</flux:button>
            </div>
        </div>
    </div>
</x-layouts::app>
