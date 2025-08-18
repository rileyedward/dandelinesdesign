export interface LineItem {
    id: number;
    product_id: number | null;
    product_name: string;
    product_sku: string | null;
    product_description: string | null;
    product_image_url: string | null;
    quantity: number;
    unit_price: number;
    total_price: number;
    currency: string;
    stripe_price_id: string | null;
    stripe_product_id: string | null;
    product?: {
        id: number;
        name: string;
        sku: string;
        image_url: string;
    };
}

export interface Order {
    id: number;
    order_number: string;
    status: string;
    original_status: string | null;
    payment_status: string;
    subtotal: number;
    tax_amount: number | null;
    shipping_cost: number | null;
    total_amount: number;
    currency: string;
    customer_email: string;
    customer_first_name: string | null;
    customer_last_name: string | null;
    customer_phone: string | null;
    shipping_address_line_1: string | null;
    shipping_address_line_2: string | null;
    shipping_city: string | null;
    shipping_state: string | null;
    shipping_postal_code: string | null;
    shipping_country: string | null;
    shipping_method: string | null;
    tracking_number: string | null;
    shipped_at: string | null;
    delivered_at: string | null;
    payment_method: string | null;
    payment_transaction_id: string | null;
    payment_completed_at: string | null;
    stripe_checkout_session_id: string | null;
    stripe_payment_intent_id: string | null;
    stripe_customer_id: string | null;
    created_at: string;
    updated_at: string;
    line_items: LineItem[];
}
