export interface UiRichTextEditorProps {
    modelValue: string;
    label?: string;
    placeholder?: string;
    error?: string;
    help?: string;
    disabled?: boolean;
    required?: boolean;
    height?: number;
}

export interface UiRichTextEditorEmits {
    'update:modelValue': [value: string];
}