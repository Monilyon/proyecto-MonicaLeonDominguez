<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
    <style>
        .sidebar-custom {
            background-color: #d1d9c1;
            width: max-content;
        }

        .bg-main-custom {
            background-color: #f3ebeb;
        }

        .btn-rounded-white {
            background-color: white !important;
            border-radius: 9999px !important;
            width: 200px;
            margin-bottom: 0.75rem;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }

        .nav-item {
            background-color: white !important;
            border-radius: 9999px !important;
            margin-left: 1rem;
            margin-right: 1rem;
            margin-bottom: 0.75rem;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            border: 1px solid #e5e7eb !important;
        }
    </style>
</head>

<body class="min-h-screen bg-main-custom">
    <!-- <div class="flex w-full"> -->
        <div class="flex">
            @php $hideSidebar = request()->routeIs('events.create') || request()->is('events/create'); @endphp
            @if(!$hideSidebar)
                <flux:sidebar collapsible="mobile" class="flex flex-col sidebar-custom border-e border-zinc-200">
                    <flux:sidebar.header class="flex flex-col items-center pt-10">
                        <div class="w-24 h-24 mb-6 overflow-hidden flex items-center justify-center shadow-sm">
                            <x-app-logo class="w-16 h-16" href="{{ route('dashboard') }}" />
                            <!-- <flux:sidebar.collapse class=" cursor-pointer hover:bg-zinc-200/50 rounded-lg p-1"/> -->
                        </div>
                    </flux:sidebar.header>

                    <flux:sidebar.nav class="px-4 mt-2">
                        <flux:sidebar.item icon="arrow-left-start-on-rectangle" href="/" class="btn-rounded-white">
                            Ir a página Usuario
                        </flux:sidebar.item>

                        <flux:sidebar.item icon="calendar" :href="route('dashboard')" :current="request()->routeIs('dashboard')" class="btn-rounded-white">
                            Ver todos los eventos
                        </flux:sidebar.item>

                        <flux:sidebar.item icon="magnifying-glass" href="#" class="btn-rounded-white">
                            Buscar por categoría
                        </flux:sidebar.item>
                    </flux:sidebar.nav>

                    <div class="p-4 mb-4 mx-4 bg-white/50 rounded-2xl border border-zinc-200">
                        <x-desktop-user-menu :name="auth()->user()->name" />
                    </div>
                </flux:sidebar>
            @endif

            @if(!$hideSidebar)
                <div class="flex gap-4 w-full px-6 mt-4">
                    <div class="w-full bg-white p-4 rounded-[2rem] border border-zinc-200 min-h-[250px] shadow-sm">
                        <h2 class="font-bold text-zinc-800 mb-4">Próximos eventos</h2>
                        <div class="border-t border-zinc-100 pt-4">
                            @php
                                $upcomingEvents = App\Models\Event::with('type')->where('date', '>', now())->orderBy('date')->limit(5)->get();
                            @endphp
                            @if($upcomingEvents->count() > 0)
                                @foreach($upcomingEvents as $event)
                                    <div class="mb-3 pb-3 border-b border-zinc-100 last:border-b-0">
                                        <h3 class="font-semibold text-zinc-800">{{ $event->name }}</h3>
                                        <p class="text-sm text-zinc-600">{{ $event->location }} - {{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }}</p>
                                        <p class="text-xs text-zinc-500">{{ $event->type->name }}</p>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-sm text-zinc-400 italic">No hay eventos próximos.</p>
                            @endif
                        </div>
                    </div>
                    <div class="w-full bg-white p-4 rounded-[2rem] border border-zinc-200 min-h-[250px] shadow-sm">
                        <h2 class="font-bold text-zinc-800 mb-4">Solicitudes recientes</h2>
                        <div class="border-t border-zinc-100 pt-4">
                            <p class="text-sm text-zinc-400 italic">Cargando solicitudes...</p>
                        </div>
                    </div>
                </div>
            @endif
        <!-- </div> -->
    </div>

    <flux:header class="lg:hidden bg-sidebar-custom border-b border-zinc-200">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
        <flux:spacer />
        <x-desktop-user-menu :name="auth()->user()->name" />
    </flux:header>



    <main class="w-full">
        {{ $slot }}
    </main>

    @fluxScripts
</body>

</html>
