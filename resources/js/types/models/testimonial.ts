export interface Testimonial {
    id: number;
    name: string;
    business_name?: string | null;
    message: string;
    created_at: string;
    updated_at: string;
}

export interface TestimonialData {
    name: string;
    business_name?: string | null;
    message: string;
    [key: string]: string | null | undefined;
}
