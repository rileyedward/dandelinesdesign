export interface ImageData {
  id: number;
  filename: string;
  original_filename: string;
  path: string;
  url: string;
  mime_type: string;
  size: number;
  alt_text?: string;
}

export interface UiImageUploadProps {
  modelValue?: ImageData | ImageData[];
  multiple?: boolean;
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
  uploadUrl?: string;
}

export interface UiImageUploadEmits {
  (event: 'update:modelValue', value: ImageData | ImageData[] | undefined): void;
  (event: 'change', value: ImageData | ImageData[] | undefined): void;
  (event: 'error', error: string): void;
  (event: 'upload-success', image: ImageData): void;
  (event: 'upload-error', error: string): void;
  (event: 'remove', image: ImageData): void;
}