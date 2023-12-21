# API Documentation

# User Authentication API using Laravel

This API provides endpoints for user registration, login, and logout functionalities using Laravel.

## Endpoints

### User Registration

#### URL

```shell
POST /api/register/user
```

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
```

#### User Login

``` shell
POST /api/login/user
```

- `email` (required): User's email address.
- `password` (required): User's password.

``` json
{
    "message": "Login Success",
    "access_token": "token_value",
    "token_type": "Bearer"
}
```

### Recruiter Registration

#### URL

```shell
POST /api/register/recruiter
```

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
        "role": "recruiter",
        "created_at": "timestamp",
        "updated_at": "timestamp"
    },
    "access_token": "token_value",
    "token_type": "Bearer"
}
```

#### Recruiter Login

``` shell
POST /api/login/recruiter
```

- `email` (required): User's email address.
- `password` (required): User's password.

#### Response
``` json
{
    "message": "Login Success",
    "access_token": "token_value",
    "token_type": "Bearer"
}
```

### Logout

``` shell
POST /api/logout
```
Headers
- Authorization: Bearer {token_value}

#### Response
``` json
{
    "message": "logout success"
}
```

# Management API using Laravel

This API provides endpoints to manage usage-related information.

## Endpoints

### Store User Biodata

#### URL

``` shell
POST /api/biodata/store
```

#### Headers

- `Authorization: Bearer {token_value}`
- `Content-Type: application/json`

#### Parameters

- `nik` (required): National Identity Number (16 characters).
- `fullname` (required): Full name of the user.
- `birthday` (required): User's date of birth.
- `telephone` (required): User's telephone number (maximum 15 characters).
- `province` (required): Province of the address.
- `city` (required): City of the address.
- `subdistrict` (required): Subdistrict of the address.
- `village` (required): Village of the address.
- `address` (required): Detailed address information.
- `latitude` (required): Latitude coordinates of the address.
- `longitude` (required): Longitude coordinates of the address.

#### Response

```json
{
    "meta": {
        "code": 200,
        "status": "success",
        "message": "Data has been successfully saved"
    },
    "data": {
        "user": {
            "id": 123,
            "nik": "1234567890123456",
            "fullname": "John Doe",
            "birthday": "1990-01-01",
            "created_at": "timestamp",
            "updated_at": "timestamp"
        },
        "address": {
            "id": 1,
            "user_id": 123,
            "fullname": "John Doe",
            "telephone": "123456789",
            "province": "Province",
            "city": "City",
            "subdistrict": "Subdistrict",
            "village": "Village",
            "address": "Detailed address info",
            "latitude": "latitude_value",
            "longitude": "longitude_value",
            "created_at": "timestamp",
            "updated_at": "timestamp"
        }
    }
}
```

### Get Categories

#### URL

``` shell
POST /api/categories
```

#### Headers

- `Authorization: Bearer {token_value}`
- `Content-Type: application/json`

#### Response

```json
{
    "meta": {
        "code": 200,
        "status": "success",
        "message": "Data displayed successfully!"
    },
    "data": [
        {
            "id": 1,
            "title": "Pertukangan",
            "slug": "pertukangan",
            "created_at": "timestamp",
            "updated_at": "timestamp"
        },
        {
            "id": 2,
            "title": "Cuci Baju",
            "slug": "cuci-baju",
            "created_at": "timestamp",
            "updated_at": "timestamp"
        },
        {
            "id": 3,
            "title": "Cuci Piring",
            "slug": "cuci-piring",
            "created_at": "timestamp",
            "updated_at": "timestamp"
        },
        {
            "id": 4,
            "title": "Setrika",
            "slug": "setrika",
            "created_at": "timestamp",
            "updated_at": "timestamp"
        },
        {
            "id": 5,
            "title": "Menyapu",
            "slug": "menyapu",
            "created_at": "timestamp",
            "updated_at": "timestamp"
        },
        {
            "id": 6,
            "title": "Mengepel",
            "slug": "mengepel",
            "created_at": "timestamp",
            "updated_at": "timestamp"
        },
        {
            "id": 7,
            "title": "Service Elektronik",
            "slug": "service-elektronik",
            "created_at": "timestamp",
            "updated_at": "timestamp"
        },
        {
            "id": 8,
            "title": "Tani Harian",
            "slug": "tani-harian",
            "created_at": "timestamp",
            "updated_at": "timestamp"
        },
        {
            "id": 9,
            "title": "Memasak",
            "slug": "memasak",
            "created_at": "timestamp",
            "updated_at": "timestamp"
        },
        {
            "id": 10,
            "title": "Baby Sitter",
            "slug": "baby-sitter",
            "created_at": "timestamp",
            "updated_at": "timestamp"
        }
    ]
}
```
