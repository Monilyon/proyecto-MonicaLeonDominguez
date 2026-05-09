import { ref } from 'vue';
import { useAuth } from '@/composables/useAuth';
import { registrationService } from '@/services/registrationService';
import type { MyRegistration } from '@/types/Registration';

const registrations = ref<MyRegistration[]>([]);
const loading = ref(false);
const error = ref<string | null>(null);

export function useRegistration() {
  const { token } = useAuth();

  const fetchRegistrations = async () => {
    if (!token.value) {
      registrations.value = [];
      return;
    }

    loading.value = true;
    error.value = null;

    try {
      registrations.value = await registrationService.getMyRegistrations(token.value);
    } catch (err: unknown) {
      error.value = err instanceof Error ? err.message : 'Error al cargar las inscripciones';
    } finally {
      loading.value = false;
    }
  };

  const registerEvent = async (eventId: number) => {
    if (!token.value) {
      throw new Error('Debes iniciar sesión para inscribirte en un evento');
    }

    loading.value = true;
    error.value = null;

    try {
      const registration = await registrationService.createRegistration(eventId, token.value);
      return registration;
    } catch (err: unknown) {
      const message = err instanceof Error ? err.message : 'Error al inscribirse';
      error.value = message;
      throw new Error(message);
    } finally {
      loading.value = false;
    }
  };

  return {
    registrations,
    loading,
    error,
    fetchRegistrations,
    registerEvent,
  };
}
