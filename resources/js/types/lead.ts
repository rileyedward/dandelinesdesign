export interface Lead {
  id: number;
  name: string;
  email: string;
  phone_number: string;
  company: string;
  status: string;
  source: string;
  notes: string;
  created_at: string;
  updated_at: string;
  deleted_at?: string;
}