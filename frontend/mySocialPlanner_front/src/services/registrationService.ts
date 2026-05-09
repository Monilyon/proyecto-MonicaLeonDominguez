import type { MyRegistration } from '@/types/Registration';

const API_BASE_URL = 'http://localhost:8000/api';

const buildHeaders = (token?: string) => {
  const headers: Record<string, string> = {
    'Content-Type': 'application/json',
  };

  if (token) {
    headers.Authorization = `Bearer ${token}`;
  }

  return headers;
};

export const registrationService = {
  async createRegistration(eventId: number, token: string): Promise<MyRegistration> {
    const response = await fetch(`${API_BASE_URL}/registrations`, {
      method: 'POST',
      headers: buildHeaders(token),
      body: JSON.stringify({ event_id: eventId }),
    });

    const result = await response.json();

    if (!response.ok) {
      throw new Error(result.message || 'Error al registrar el evento');
    }

    return result.data;
  },

  async getMyRegistrations(token: string): Promise<MyRegistration[]> {
    const response = await fetch(`${API_BASE_URL}/my-events`, {
      method: 'GET',
      headers: buildHeaders(token),
    });

    const result = await response.json();
    if (!response.ok) {
      throw new Error(result.message || 'Error al cargar tus inscripciones');
    }

    return result.data || [];
  },

  async updateRegistrationStatus(
    registrationId: number,
    statusId: number,
    token: string
  ): Promise<MyRegistration> {
    const response = await fetch(`${API_BASE_URL}/registrations/${registrationId}`, {
      method: 'PUT',
      headers: buildHeaders(token),
      body: JSON.stringify({ status_id: statusId }),
    });

    const result = await response.json();
    if (!response.ok) {
      throw new Error(result.message || 'Error al actualizar el estado de la inscripción');
    }

    return result.registration;
  },
};
