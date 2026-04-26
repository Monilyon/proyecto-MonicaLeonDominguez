<x-layouts::app>
    <div class="flex flex-col gap-4 m-0 w-full h-[calc(100vh-2rem)]">

        <div class="w-full bg-white p-4 rounded-[2rem] border border-zinc-200 shadow-sm flex flex-col min-h-0" >

            <h1 class="text-zinc-800 w-full p-4 shrink-0" style="background-color: #d1d9c1; font-size: 2rem; font-weight: bolder; border-radius: 1.5rem 1.5rem 0 0;">
                Todos los eventos
            </h1>

            <div class="flex-1 overflow-y-auto mt-2 p-2 border-t border-zinc-100 bg-zinc-50" style="scrollbar-gutter: stable;">
                @if($events->count() > 0)
                    @foreach($events as $event)
                    <div class="mb-3 py-3 border-b border-zinc-100 last:border-b-0 flex justify-between items-start bg-white p-4 rounded-xl shadow-sm">
                        <div>
                            <h3 class="font-bold text-zinc-800">{{ $event->name }}</h3>
                            <p class="text-sm text-zinc-600">{{ $event->location }} - {{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }}</p>
                            <p class="text-xs text-zinc-500">{{ $event->type->name }}</p>
                            <p class="text-xs text-zinc-500 italic">{{ $event->description }}</p>
                        </div>
                        <div class="flex flex-col gap-2 shrink-0">
                            <a href="{{ route('events.edit', $event->id) }}" class="custom-btn font-bold text-blue-600 text-center text-sm">Editar</a>
                            <form action="{{ route('events.destroy', $event->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="custom-btn font-bold text-red-600 w-full text-sm">Eliminar</button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="flex items-center justify-center h-32">
                        <p class="text-sm text-zinc-400 italic">No hay eventos.</p>
                    </div>
                @endif
            </div>

            <div class="pt-4 shrink-0">
                <flux:button href="{{ route('dashboard') }}" variant="subtle" icon="arrow-left" size="sm">
                    Volver al panel
                </flux:button>
            </div>
        </div>
    </div>
</x-layouts::app>

<style>
    /* El truco del min-h-0 en el padre es vital para que overflow-y-auto funcione en flexbox */
    .custom-btn {
        border: 2px solid #d1d9c1;
        padding: 4px 12px;
        border-radius: 8px;
        display: block;
        transition: all 0.2s;
    }
    .custom-btn:hover {
        background-color: #d1d9c1;
        color: white !important;
    }
</style>
