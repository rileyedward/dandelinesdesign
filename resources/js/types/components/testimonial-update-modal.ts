import { Testimonial, TestimonialData } from '@/types/models/testimonial';

export interface TestimonialUpdateModalProps {
    testimonial: Testimonial | null;
    isOpen: boolean;
}

export interface TestimonialUpdateModalEmits {
    (e: 'close'): void;
    (e: 'update', id: number, data: TestimonialData): void;
    (e: 'create', data: TestimonialData): void;
    (e: 'delete', id: number): void;
}
