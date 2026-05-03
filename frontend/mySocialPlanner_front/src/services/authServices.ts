const API_BASE_URL = 'http://localhost:8000/api';
const WEB_BASE_URL = 'http://localhost:8000';
import type { RegisterData } from "@/types/Register";

function getCookie(name: string): string | null {
  const matches = document.cookie.match(new RegExp('(?:^|; )' + name.replace(/([.$?*|{}()\[\]\\\/\+^])/g, '\\$1') + '=([^;]*)'));

  if (!matches || !matches[1]) {
    return null;
  }

  return decodeURIComponent(matches[1]);
}

export const authService = {
  /**
   * Método para login API
   */
  async login(credentials: { email: string; password: string }) {
    const response = await fetch(`${API_BASE_URL}/login`, {
      method: 'POST',
      credentials: 'include',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
      },
      body: JSON.stringify(credentials),
    });

    const data = await response.json();

    if (!response.ok) {
      throw new Error(data.message || 'Error en el servidor');
    }

    return data;
  },

  /**
   * Método para iniciar sesión en la sesión web de Laravel
   */
  async loginWebSession(credentials: { email: string; password: string }) {
    const csrfResponse = await fetch(`${WEB_BASE_URL}/sanctum/csrf-cookie`, {
      credentials: 'include',
      headers: {
        'Accept': 'application/json',
      },
    });

    if (!csrfResponse.ok) {
      throw new Error('No se pudo obtener la cookie CSRF.');
    }

    const xsrfToken = getCookie('XSRF-TOKEN');
    if (!xsrfToken) {
      throw new Error('No se encontró el token CSRF.');
    }

    const xsrfTokenValue: string = xsrfToken;

    const response = await fetch(`${WEB_BASE_URL}/login`, {
      method: 'POST',
      credentials: 'include',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-XSRF-TOKEN': xsrfTokenValue,
      },
      body: JSON.stringify(credentials),
    });

    if (!response.ok) {
      const data = await response.json().catch(() => ({}));
      throw new Error(data.message || 'Error al iniciar sesión en el backend.');
    }

    return true;
  },

  /**
   * Método para el registro
   */
  async register(userData: RegisterData) {
    const response = await fetch(`${API_BASE_URL}/register`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
      },
      body: JSON.stringify(userData),
    });

    const data = await response.json();

    if (!response.ok) {
      // Si Laravel devuelve error, lo lanzamos para que el composable lo capture
      throw new Error(data.message || 'Error al crear la cuenta');
    }

    return data;
  },

  /**
   * Método para logout
   */

  async logout(token: string) {
    const response = await fetch(`${API_BASE_URL}/logout`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'Authorization': `Bearer ${token}`
      },
    });

    if (!response.ok) {
      throw new Error('No se pudo cerrar la sesión en el servidor');
    }

    return await response.json();
  }
};
