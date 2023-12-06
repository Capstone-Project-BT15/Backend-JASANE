# API Documentation

This API provides endpoints for user authentication and authorization using Laravel. Below are the available endpoints and their functionalities.

## Endpoints

### User Registration

#### URL

```shell
POST /api/register/user


#### Parameters

- `fullname` (required): Full name of the user.
- `telephone` (required): User's telephone number (maximum 15 characters).
- `email` (required): User's email address. Must be unique.
- `password` (required): User's password (min 6 characters).
- `password_confirmation` (required): Confirmation of the user's password.

#### Response

```json
{
    "data": {
        "fullname": "John Doe",
        "telephone": "123456789",
        "email": "john@example.com",
        "role": "user",
        "created_at": "timestamp",
        "updated_at": "timestamp"
    },
    "access_token": "token_value",
    "token_type": "Bearer"
}
