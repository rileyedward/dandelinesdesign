export interface RegisterFormData {
  name: string;
  email: string;
  password: string;
  password_confirmation: string;
}

export interface RegisterFormProps {
  errors?: Record<string, string>;
}

export interface RegisterFormEmits {
  (event: 'submit', data: RegisterFormData): void;
}