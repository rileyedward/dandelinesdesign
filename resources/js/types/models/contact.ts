export interface ContactData {
    name: string;
    business_name: string | null;
    email: string;
    phone: string | null;
    subject: string;
    message: string;
    [key: string]: string | null | undefined;
}
