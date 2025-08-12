import type { Testimonial } from '@/types/testimonial';

export interface TestimonialListProps {
  testimonials: Testimonial[];
  loading?: boolean;
  noDataText?: string;
  loadingText?: string;
}
