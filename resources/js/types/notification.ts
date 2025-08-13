export interface Notification {
    id: number;
    user_id: number;
    type: 'primary' | 'success' | 'danger' | 'warning' | 'info';
    title: string;
    message: string;
    action_url: string | null;
    action_text: string | null;
    is_read: boolean;
    created_at: string;
    updated_at: string;
}
