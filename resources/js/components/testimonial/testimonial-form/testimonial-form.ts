import type { Testimonial } from '@/types/testimonial';

export interface TestimonialFormProps {
  testimonial?: Testimonial;
  processing?: boolean;
  errors?: Record<string, string>;
}

export interface TestimonialFormEmits {
  (event: 'submit', testimonial: Partial<Testimonial>): void;
  (event: 'cancel'): void;
}
