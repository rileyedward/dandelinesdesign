export interface ImageData {
  id: number;
  filename: string;
  original_filename: string;
  path: string;
  url: string;
  mime_type: string;
  size: number;
  alt_text?: string;
  created_at?: string;
  updated_at?: string;
}

export interface UiMultiImageUploadProps {
  modelValue?: ImageData[];
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
  allowReorder?: boolean;
}

export interface UiMultiImageUploadEmits {
  (event: 'update:modelValue', value: ImageData[]): void;
  (event: 'change', value: ImageData[]): void;
  (event: 'error', error: string): void;
  (event: 'upload-success', image: ImageData): void;
  (event: 'upload-error', error: string): void;
  (event: 'remove', image: ImageData): void;
  (event: 'reorder', images: ImageData[]): void;
}