import { ref, computed } from 'vue';
import { authService } from '@/services/authServices';
import { useRouter } from 'vue-router';
import type { RegisterData } from '@/types/Register';
// Estado global persistente (fuera de la función para que sea compartido)
const user = ref(JSON.parse(localStorage.getItem('USER_DATA') || 'null'));
const token = ref(localStorage.getItem('AUTH_TOKEN') || null);

export function useAuth() {
  const router = useRouter();
  const loading = ref(false);
  const error = ref<string | null>(null);

  // Propiedad computada para saber si hay sesión activa
  const isLoggedIn = computed(() => !!token.value);

  const login = async (credentials: { email: string; password: string }) => {
    loading.value = true;
    error.value = null;

    try {
      const data = await authService.login(credentials);

      // Guardar en el estado reactivo
      token.value = data.access_token;
      user.value = data.user;

      // Guardar en el almacenamiento local para que no se pierda al recargar
      localStorage.setItem('AUTH_TOKEN', data.access_token);
      localStorage.setItem('USER_DATA', JSON.stringify(data.user));

      // Si el usuario es admin, crear sesión web en Laravel y redirigir al welcome blade.
      if (data.user?.rol === 'admin') {
        await authService.loginWebSession(credentials);
        window.location.href = 'http://localhost:8000/';
        return;
      }

      // Redirigir al home del frontend tras éxito
      router.push('/');
    } catch (err: unknown) {
      if (err instanceof Error) {
      error.value = err.message;
    } else if (typeof err === 'string') {
      error.value = err;
    } else {
      error.value = 'Error desconocido al iniciar sesión';
    }
    } finally {
      loading.value = false;
    }
  };
const register = async (userData: RegisterData) => {
  loading.value = true;
  error.value = null;

  // Validación local rápida
  if (userData.email !== userData.email_confirmation) {
    error.value = 'Los correos electrónicos no coinciden';
    loading.value = false;
    return;
  }

  try {
    const data = await authService.register(userData);

    token.value = data.access_token;
    user.value = data.user;

    localStorage.setItem('AUTH_TOKEN', data.access_token);
    localStorage.setItem('USER_DATA', JSON.stringify(data.user));

    router.push('/');
  } catch (err: unknown) {
    const errorInstance = err as Error;
    error.value = errorInstance.message || 'Error en el registro';
  } finally {
    loading.value = false;
  }
};
  const logout = async () => {
    if (token.value) {
      try {
        await authService.logout(token.value);
      } catch (err) {
        console.warn('Error al invalidar token en servidor, limpiando local...');
      }
    }

    token.value = null;
    user.value = null;
    localStorage.removeItem('AUTH_TOKEN');
    localStorage.removeItem('USER_DATA');
    router.push('/');
  };

  return {
    user,
    token,
    isLoggedIn,
    loading,
    error,
    register,
    login,
    logout
  };
}
