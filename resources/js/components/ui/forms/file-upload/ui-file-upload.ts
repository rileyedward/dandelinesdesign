export interface UiFileUploadProps {
  modelValue?: File | File[];
  multiple?: boolean;
  accept?: string;
  maxSize?: number;
  maxFiles?: number;
  disabled?: boolean;
  label?: string;
  placeholder?: string;
  helperText?: string;
  error?: string;
  dropzoneText?: string;
  buttonText?: string;
  showPreview?: boolean;
}

export interface UiFileUploadEmits {
  (event: 'update:modelValue', value: File | File[]): void;
  (event: 'change', value: File | File[]): void;
  (event: 'error', error: string): void;
  (event: 'file-added', file: File): void;
  (event: 'file-removed', file: File): void;
}
