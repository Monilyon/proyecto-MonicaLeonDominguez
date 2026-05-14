<x-layouts::app :title="__('Gestión de Usuarios')">
    <div class="flex flex-col gap-4 m-0 w-full h-[calc(100vh-2rem)]">
        <div class="w-full bg-white p-4 rounded-[2rem] border border-zinc-200 shadow-sm flex flex-col min-h-0">

            <!-- Cabecera -->
            <header class="flex items-center justify-between p-4 shrink-0" style="background-color: #d1d9c1; border-radius: 1.5rem 1.5rem 0 0;">
                <h1 class="text-zinc-800 font-black text-2xl">Usuarios Registrados</h1>
                <span class="bg-white/50 px-4 py-1 rounded-full text-sm font-bold text-zinc-700">
                    Total: {{ $users->count() }}
                </span>
            </header>

            <!-- Formulario de Filtros -->
            <form action="{{ route('users.index') }}" method="GET" class="flex flex-col flex-1 min-h-0">

                <section class="flex-1 overflow-y-auto mt-4 p-2 border-t border-zinc-100 bg-zinc-50" style="scrollbar-gutter: stable;">
                    <table class="w-full border-separate border-spacing-y-2 table-fixed">
                        <thead>
                            <tr class="text-zinc-400 text-xs uppercase tracking-widest">
                                <th class="px-6 py-2 text-start w-1/3">Usuario</th>
                                <th class="px-6 py-2 text-start w-1/3">Email</th>
                                <th class="px-6 py-2 text-start w-1/4">Fecha de Registro</th>
                                <th class="px-6 py-2 text-center w-1/6">Acciones</th>
                            </tr>
                            <!-- Fila de Inputs de Filtro -->
                            <tr>
                                <td class="px-4 pb-2">
                                    <input type="text" name="name" value="{{ request('name') }}" placeholder="Nombre..." class="w-full text-xs border-2 border-[#d1d9c1] rounded-lg px-2 py-1 outline-none focus:border-zinc-400">
                                </td>
                                <td class="px-4 pb-2">
                                    <input type="text" name="email" value="{{ request('email') }}" placeholder="Email..." class="w-full text-xs border-2 border-[#d1d9c1] rounded-lg px-2 py-1 outline-none focus:border-zinc-400">
                                </td>
                                <td class="px-4 pb-2">
                                    <input type="date" name="created_at" value="{{ request('created_at') }}" class="w-full text-xs border-2 border-[#d1d9c1] rounded-lg px-2 py-1 outline-none focus:border-zinc-400">
                                </td>
                                <td class="px-4 pb-2 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button type="submit" class="text-[10px] font-black uppercase bg-[#d1d9c1] text-zinc-700 px-3 py-1.5 rounded-lg border border-[#c2cca9] hover:bg-[#c2cca9] transition-all">
                                            Filtrar
                                        </button>
                                        @if(request()->anyFilled(['name', 'email', 'created_at']))
                                            <a href="{{ route('users.index') }}" class="flex items-center justify-center w-7 h-7 rounded-full bg-red-50 text-red-500 border border-red-100 hover:bg-red-500 hover:text-white transition-all shadow-sm">
                                                <flux:icon.x-mark variant="micro" />
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                            <tr class="bg-white hover:bg-zinc-50 transition-colors shadow-sm text-sm">
                                <td class="px-6 py-4 rounded-l-xl border-y border-l border-zinc-100 align-middle">
                                    <span class="font-bold text-zinc-800">{{ $user->name }}</span>
                                </td>
                                <td class="px-6 py-4 border-y border-zinc-100 align-middle">
                                    <span class="text-zinc-600">{{ $user->email }}</span>
                                </td>
                                <td class="px-6 py-4 border-y border-zinc-100 align-middle">
                                    <div class="flex flex-col">
                                        <span class="text-xs font-bold text-zinc-400 uppercase tracking-tighter">Miembro desde</span>
                                        <span class="text-zinc-600">{{ $user->created_at->format('d/m/Y') }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 rounded-r-xl border-y border-r border-zinc-100 align-middle text-center">
                                    <div class="flex justify-center gap-3">
                                        {{-- Si quieres permitir borrar usuarios, descomenta esto: --}}
                                        {{--
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('¿Borrar usuario?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:scale-110 transition-transform">
                                                <flux:icon.trash variant="micro" />
                                            </button>
                                        </form>
                                        --}}
                                        <span class="text-zinc-300 italic text-[10px]">Sin acciones</span>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-20 text-center">
                                    <div class="flex flex-col items-center">
                                        <flux:icon.users class="w-12 h-12 text-zinc-200 mb-2" />
                                        <p class="text-zinc-400 italic">No se encontraron usuarios.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </section>
            </form>

            <div class="pt-4 shrink-0">
                <flux:button href="{{ route('dashboard') }}" variant="subtle" icon="arrow-left" size="sm">Volver al Dashboard</flux:button>
            </div>
        </div>
    </div>
</x-layouts::app>
