<x-layouts::auth>
    <div class="mx-auto max-w-4xl bg-white p-8 border border-zinc-200 rounded-xl shadow-sm">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">

            <div>
                <h1 class="text-3xl font-bold text-zinc-700 leading-tight">
                    Bienvenido al panel de administración.
                </h1>
                <p class="mt-4 text-zinc-500 text-sm">
                    Aquí podrás gestionar actividades de ocio, deportes, cultura y acción social...
                </p>

                <form method="POST" action="{{ route('login.store') }}" class="mt-8 space-y-6">
                    @csrf

                    <flux:input name="email" :label="__('Email')" type="email" required />

                    <flux:input name="password" :label="__('Contraseña')" type="password" viewable required />

                    <div class="flex items-center justify-between">
                        <flux:checkbox name="remember" :label="__('Recordarme')" />
                        <flux:link href="{{ route('password.request') }}" variant="subtle" class="text-xs">
                            ¿Olvidaste la clave?
                        </flux:link>
                    </div>

                    <flux:button variant="primary" type="submit" class="w-full !bg-[#8b9678] !border-[#8b9678]">
                        Iniciar Sesión
                    </flux:button>
                </form>
            </div>
        </div>
    </div>
</x-layouts::auth>
