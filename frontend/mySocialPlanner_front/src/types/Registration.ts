import type { MyEvent } from '@/types/Event';

export interface RegistrationStatus {
  id: number;
  name: string;
  description?: string;
}

export interface MyRegistration {
  id: number;
  user_id: number;
  event_id: number;
  registration_status_id: number;
  registration_date?: string;
  event: MyEvent;
  status: RegistrationStatus;
}
