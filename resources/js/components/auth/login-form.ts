export interface LoginFormData {
  email: string;
  password: string;
  remember: boolean;
}

export interface LoginFormProps {
  errors?: Record<string, string>;
}

export interface LoginFormEmits {
  (event: 'submit', data: LoginFormData): void;
}