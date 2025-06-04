export interface User {
    id: number;
    username: string;
    password: string;
    remember_token: string | null;
    created_at: string;
    updated_at: string;
}

export interface UserData {
    username: string;
    password: string;
    password_confirmation: string;
    [key: string]: string | null | undefined;
}
