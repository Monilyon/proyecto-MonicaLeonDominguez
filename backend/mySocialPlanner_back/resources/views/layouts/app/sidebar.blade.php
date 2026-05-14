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
            border-radius: 8px;
            width: auto;
            margin-bottom: 0.75rem;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }

        .btn-rounded-green {
            background-color: white !important;
            border-radius: 8px;
            width: auto;
            margin-bottom: 0.75rem;
            box-shadow: 0 1px 2px 0 rgba(54, 91, 41, 0.05);
        }

        .nav-item {
            background-color: white !important;
            border-radius: 8px;
            margin-left: 1rem;
            margin-right: 1rem;
            margin-bottom: 0.75rem;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            border: 1px solid #e5e7eb !important;
        }
    </style>
</head>

<body class="min-h-screen bg-main-custom m-0">
    <!-- <div class="flex w-full"> -->
    <div class="flex">
        @php
        $hideSidebar = request()->routeIs('events.create')
        || request()->routeIs('events.index')
        || request()->routeIs('events.edit')
        || request()->routeIs('users.index')
        || request()->routeIs('registrations.index')
        || request()->is('events/create');
        @endphp
        @if(!$hideSidebar)
        <flux:sidebar collapsible="mobile" class="flex flex-col sidebar-custom border-e border-zinc-200">
            <flux:sidebar.header class="flex flex-col items-center pt-10">
                <div class="w-24 h-24 mb-6 overflow-hidden flex items-center justify-center shadow-sm">
                    <x-app-logo class="w-50 h-50" href="{{ route('dashboard') }}" />
                </div>
            </flux:sidebar.header>

            <flux:sidebar.nav class="px-4 mt-2">
                <flux:sidebar.item icon="home" href="http://localhost:5173" class="btn-rounded-white">
                    Ir a la página principal de usuarios
                </flux:sidebar.item>

                <flux:sidebar.item icon="arrow-left-start-on-rectangle" href="/" class="btn-rounded-white">
                    Ir al Inicio del panel administrador
                </flux:sidebar.item>

            </flux:sidebar.nav>

            <div class="p-4 mb-4 mx-4 bg-white border border-zinc-200 btn-rounded-white flex justify-center shadow-sm mt-auto">
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

                <flux:sidebar.item icon="calendar" :href="route('events.index', ['scope' => 'upcoming'])" :current="request()->routeIs('events.index')" class="btn-rounded-green">
                    Ver los eventos activos
                </flux:sidebar.item>
            </div>
            <div class="w-full bg-white p-4 rounded-[2rem] border border-zinc-200 min-h-[250px] shadow-sm">
                <h2 class="font-bold text-zinc-800 mb-4">Solicitudes pendientes</h2>
                <div class="border-t border-zinc-100 pt-4">
                    @if(Auth::user()->rol === 'admin')
                    @php
                    $pendingRequests = App\Models\Registration::with(['user', 'event', 'status'])
                    ->whereHas('status', function ($query) {
                    $query->where('name', 'Pendiente');
                    })
                    ->orderByDesc('created_at')
                    ->limit(5)
                    ->get();
                    @endphp

                    @if($pendingRequests->count() > 0)
                    @foreach($pendingRequests as $request)
                    <div class="mb-3 pb-3 border-b border-zinc-100 last:border-b-0">
                        <h3 class="font-semibold text-zinc-800">{{ $request->user->name }}</h3>
                        <p class="text-sm text-zinc-600">Evento: {{ $request->event->name }}</p>
                        <p class="text-xs text-zinc-500 mb-2">
                            {{ $request->status->name }} • {{ \Carbon\Carbon::parse($request->created_at)->format('d/m/Y') }}
                        </p>

                        <div class="flex gap-3 items-center mt-2">
                            <!-- Formulario Aprobar -->
                            <form method="POST" action="{{ route('admin.registration.update', $request->id) }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status_id" value="2" />
                                <button type="submit"
                                    onclick="return confirm('¿Estás seguro de que deseas Aprobar esta solicitud?')"
                                    class="px-4 py-1.5 bg-white border border-green-200 text-green-600 hover:bg-green-50 text-sm font-medium rounded-md transition-colors">
                                    Aprobar
                                </button>
                            </form>

                            <!-- Formulario Rechazar -->
                            <form method="POST" action="{{ route('admin.registration.update', $request->id) }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status_id" value="3" />
                                <button type="submit"
                                    onclick="return confirm('¿Estás seguro de que deseas rechazar esta solicitud?')"
                                    class="px-4 py-1.5 bg-white border border-red-200 text-red-600 hover:bg-red-50 text-sm font-medium rounded-md transition-colors">
                                    Rechazar
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <p class="text-zinc-500 text-sm">No hay solicitudes pendientes.</p>
                    @endif
                    @else
                    <p class="text-sm text-zinc-400 italic">No tienes permisos para ver las solicitudes pendientes.</p>
                    @endif
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

    <script>

    </script>

    @fluxScripts
</body>

</html>
