/// <reference types="vite/client" />

interface ImportMetaEnv {
    readonly VITE_APP_NAME: string;
    readonly VITE_TINYMCE_API_KEY: string;
}

interface ImportMeta {
    readonly env: ImportMetaEnv;
}
