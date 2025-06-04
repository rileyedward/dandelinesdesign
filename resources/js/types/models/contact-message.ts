export interface ContactMessage {
    id: number;
    name: string;
    business_name: string | null;
    email: string;
    phone: string | null;
    subject: string;
    message: string;
    created_at: string;
    updated_at: string;
}

export interface ContactMessageData {
    name: string;
    business_name: string | null;
    email: string;
    phone: string | null;
    subject: string;
    message: string;
    [key: string]: string | null | undefined;
}
