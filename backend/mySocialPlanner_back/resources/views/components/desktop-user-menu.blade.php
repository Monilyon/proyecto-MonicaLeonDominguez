@props(['name'])

<div
    x-data="{ open: false }"
    @click.away="open = false"
    {{ $attributes->class(['relative overflow-visible z-50']) }}
>
    <button
        @click="open = !open"
        class="flex w-full items-center gap-2 rounded-lg border border-zinc-200 bg-white/90 px-2 py-2 shadow-sm shadow-zinc-900/5 transition hover:bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-950/80 dark:shadow-none dark:hover:bg-zinc-900"
    >
        <flux:avatar
            :name="$name"
            :initials="auth()->user()->initials()"
            size="sm"
        />
        <div class="min-w-0 flex-1 text-left">
            <p class="truncate text-xs font-medium text-zinc-900 dark:text-zinc-100">{{ $name }}</p>
            <p class="truncate text-xs text-zinc-500 dark:text-zinc-400">{{ auth()->user()->email }}</p>
        </div>
        <svg
            :class="{ 'rotate-180': open }"
            class="h-3 w-3 text-zinc-400 transition-transform"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
        >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>

    <!-- Este Div es el que controla el menú de admin/logout -->
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute bottom-full left-0 right-0 mb-1 rounded-lg border border-zinc-200 bg-white p-1 shadow-lg dark:border-zinc-700 dark:bg-zinc-900"
        style="display: none;"
    >
        <a
            href="{{ route('profile.edit') }}"
            wire:navigate
            @click="open = false; setTimeout(() => {
                const sidebar = document.querySelector('flux-sidebar');
                if (sidebar && !sidebar.hasAttribute('data-flux-sidebar-collapsed')) {
                    sidebar.setAttribute('data-flux-sidebar-collapsed', '');
                }
            }, 100)"
            class="flex items-center gap-2 rounded-md px-2 py-1.5 text-xs text-zinc-700 transition hover:bg-zinc-100 dark:text-zinc-200 dark:hover:bg-zinc-800"
        >
            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            {{ __('Settings') }}
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button
                type="submit"
                @click="open = false; setTimeout(() => {
                    const sidebar = document.querySelector('flux-sidebar');
                    if (sidebar && !sidebar.hasAttribute('data-flux-sidebar-collapsed')) {
                        sidebar.setAttribute('data-flux-sidebar-collapsed', '');
                    }
                }, 100)"
                class="flex w-full items-center gap-2 rounded-md px-2 py-1.5 text-left text-xs text-zinc-700 transition hover:bg-zinc-100 dark:text-zinc-200 dark:hover:bg-zinc-800"
            >
                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</div>
