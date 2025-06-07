export interface Testimonial {
    id: number;
    name: string;
    message: string;
    created_at: string;
    updated_at: string;
}

export interface TestimonialData {
    name: string;
    message: string;
    [key: string]: string | null | undefined;
}
