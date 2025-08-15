# Checkout Testing Instructions

## Overview
This document provides instructions on how to test the checkout functionality in the Dandelines Design application.

## Checkout URL
The checkout endpoint is available at:
```
GET /checkout
```

This endpoint is protected by authentication, so you'll need to be logged in to access it.

## Required Payload
The checkout endpoint expects a JSON payload with the following structure:

```json
{
  "items": [
    {
      "price_id": "price_1234567890abcdef",
      "quantity": 1
    },
    {
      "price_id": "price_0987654321fedcba",
      "quantity": 2
    }
  ]
}
```

### Payload Fields
- `items` (required): An array of items to be purchased
  - `price_id` (required): The Stripe price ID for the item
  - `quantity` (required): The quantity of the item (1-99)

## Testing Flow
1. From the store page, add items to your cart
2. Each item in the cart should have a Stripe price ID and a quantity
3. When ready to checkout, send a request to the checkout endpoint with the cart items
4. The endpoint will return a Stripe Checkout session
5. Redirect the user to the Stripe Checkout URL
6. After payment, Stripe will handle the success or cancel flow (in the future, this will redirect to dedicated routes for order creation)

## Example Testing with cURL
```bash
curl -X GET \
  'http://localhost:8000/checkout' \
  -H 'Content-Type: application/json' \
  -H 'Accept: application/json' \
  -H 'Cookie: laravel_session=your_session_cookie' \
  -d '{
    "items": [
      {
        "price_id": "price_1234567890abcdef",
        "quantity": 1
      }
    ]
  }'
```

## Example Testing with JavaScript
```javascript
// On your store page, you might have code like this:
const cartItems = [
  { price_id: "price_1234567890abcdef", quantity: 1 },
  { price_id: "price_0987654321fedcba", quantity: 2 }
];

// When the user clicks the checkout button:
fetch('/checkout', {
  method: 'GET',
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
  },
  body: JSON.stringify({
    items: cartItems
  })
})
.then(response => response.json())
.then(data => {
  // Redirect to Stripe Checkout
  window.location.href = data.url;
})
.catch(error => console.error('Error:', error));
```

## Notes
- Success and cancel URLs are not sent in the request as per requirements
- In the future, dedicated success and cancel routes will be implemented to handle order creation after successful checkout and to handle cancellations
- The checkout endpoint is currently protected by authentication, so users need to be logged in
