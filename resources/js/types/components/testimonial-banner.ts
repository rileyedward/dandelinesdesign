import { Testimonial } from '@/types/models/testimonial';

export interface TestimonialBannerProps {
    testimonial: Testimonial;
}

export interface TestimonialBannerEmits {
    (e: 'update', testimonial: Testimonial): void;
    (e: 'delete', id: number): void;
}
