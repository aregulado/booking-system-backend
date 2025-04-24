# Backend Task (Laravel)
Requirements:

### Create a Laravel project with two models:
* Booking : Fields: id , guest_name (string), room_id (foreign key), check_in_date (date), check_out_date (date), status (enum: pending ,
  confirmed , cancelled ), promo_code (string, nullable), created_at , updated_at , deleted_at (soft deletes).
* Room : Fields: id , number (string, unique), type (string), is_available (boolean).

### Implement two endpoints:
POST /api/bookings : Create a booking, validating:
* guest_name : Required, max 255 characters.
* room_id : Required, must exist in rooms table and be available ( is_available = true ).
* check_in_date : Required, valid date, after today.
* check_out_date : Required, valid date, after check_in_date .
* promo_code : Optional, max 50 characters.
* Ensure no overlapping bookings for the same room (check check_in_date and check_out_date ).
* Use database transactions to ensure data integrity.
* Return appropriate HTTP codes (e.g., 201 for success, 422 for validation errors, 409 for conflicts).
  GET /api/bookings : Retrieve active bookings (not soft-deleted), including room details, paginated (10 per page).


Secure the endpoints with Laravel Sanctum (API token authentication).
Use MySQL for storage and enable soft deletes for bookings.

### Bonus:
* Generate API documentation (e.g., OpenAPI/Swagger) for the endpoints.
* Implement a custom validation rule to check promo code format (e.g., uppercase, 6–10 characters).
* Add a middleware to log request performance for debugging high-traffic issues.

Example Response (POST /api/bookings):
```
{
    "message": "Booking created",
    "booking": {
        "id": 1,
        "guest_name": "John Doe",
        "room_id": 1,
        "check_in_date": "2025-05-01",
        "check_out_date": "2025-05-03",
        "status": "pending",
        "promo_code": "SUMMER2025"
    }
}
```
