export interface Testimonial {
  id: number;
  name: string;
  title?: string;
  quote: string;
  rating?: number;
  is_featured: boolean;
  is_active: boolean;
  created_at: string;
  updated_at: string;
  deleted_at?: string;
}
