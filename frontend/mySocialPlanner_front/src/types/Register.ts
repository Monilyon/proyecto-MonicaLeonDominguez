export interface RegisterData {
  name: string;
  last_name?: string;
  phone?: string;
  email: string;
  email_confirmation: string;
  password: string;
  photo?: File | null;
}

