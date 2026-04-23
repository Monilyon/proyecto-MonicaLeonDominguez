<x-layouts::app :title="__('Dashboard')">
    <div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="bg-white p-6 rounded-[2rem] border border-zinc-200 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-lg font-bold text-zinc-400 uppercase tracking-widest">Eventos activos</p>
                    <p class="text-5xl font-black text-zinc-900 mt-1">{{ $eventosCount ?? 5 }}</p>
                </div>
                <div class="bg-[#f2f4e8] p-4 rounded-2xl">
                    <flux:icon.calendar class="w-10 h-10 text-zinc-600" />
                </div>
            </div>

            <div class="bg-white p-6 rounded-[2rem] border border-zinc-200 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-lg font-bold text-zinc-400 uppercase tracking-widest">Usuarios</p>
                    <p class="text-5xl font-black text-zinc-900 mt-1">{{ $usuariosCount ?? 8 }}</p>
                </div>
                <div class="bg-[#f2f4e8] p-4 rounded-2xl">
                    <flux:icon.users class="w-10 h-10 text-zinc-600" />
                </div>
            </div>

            <div class="bg-white p-6 rounded-[2rem] border border-zinc-200 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-lg font-bold text-zinc-400 uppercase tracking-widest">Solicitudes</p>
                    <p class="text-5xl font-black text-zinc-900 mt-1">{{ $solicitudesCount ?? 2 }}</p>
                </div>
                <div class="bg-[#f2f4e8] p-4 rounded-2xl">
                    <flux:icon.document-text class="w-10 h-10 text-zinc-600" />
                </div>
            </div>

        </div>

    </div>
</x-layouts::app>
