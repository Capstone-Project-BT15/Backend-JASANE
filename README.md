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
GET /api/register/recruiter
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

### Home User

#### URL

``` shell
POST /api/home/user
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
    "data": {
        "closest_work": [
            {
                "id": 1,
                "image": "https://storage.googleapis.com/capstone-project-406502.appspot.com/works/image_65794a11b9322.jpeg",
                "title": "Cuci Piring",
                "user_id": 2,
                "category_id": 3,
                "telephone": "08515536623",
                "min_budget": "10000",
                "max_budget": "20000",
                "type_of_work": "Kerja Lepas",
                "start_date": "2023-12-15",
                "description": "lorem ipsum",
                "latitude": "-6.2275",
                "longitude": "107.0014",
                "created_at": "2023-12-13T06:07:16.000000Z",
                "updated_at": "2023-12-13T06:07:16.000000Z",
                "category_title": "Cuci Piring",
                "distance": 6509.226780098054,
                "distance_to_user": "6.51 km"
            },
            {
                "id": 8,
                "image": "https://storage.googleapis.com/capstone-project-406502.appspot.com/works/image_657c73aa0dfc5.png",
                "title": "Cuci Piring",
                "user_id": 2,
                "category_id": 3,
                "telephone": "08515536623",
                "min_budget": "10000",
                "max_budget": "20000",
                "type_of_work": "Kerja Lepas",
                "start_date": "2023-12-15",
                "description": "lorem ipsum",
                "latitude": "-6.2275",
                "longitude": "107.0014",
                "created_at": "2023-12-15T15:41:30.000000Z",
                "updated_at": "2023-12-15T15:41:30.000000Z",
                "category_title": "Cuci Piring",
                "distance": 6509.226780098054,
                "distance_to_user": "6.51 km"
            },
            {
                "id": 9,
                "image": "https://storage.googleapis.com/capstone-project-406502.appspot.com/works/image_658189fd717fc.jpeg",
                "title": "Cuci Piring",
                "user_id": 2,
                "category_id": 3,
                "telephone": "08515536623",
                "min_budget": "10000",
                "max_budget": "20000",
                "type_of_work": "Kerja Lepas",
                "start_date": "2023-12-15",
                "description": "lorem ipsum",
                "latitude": "-6.2275",
                "longitude": "107.0014",
                "created_at": "2023-12-19T12:18:14.000000Z",
                "updated_at": "2023-12-19T12:18:14.000000Z",
                "category_title": "Cuci Piring",
                "distance": 6509.226780098054,
                "distance_to_user": "6.51 km"
            },
            {
                "id": 10,
                "image": "https://storage.googleapis.com/capstone-project-406502.appspot.com/works/image_65818cae21749.jpeg",
                "title": "Cuci Piring",
                "user_id": 2,
                "category_id": 3,
                "telephone": "08515536623",
                "min_budget": "10000",
                "max_budget": "20000",
                "type_of_work": "Kerja Lepas",
                "start_date": "2023-12-15",
                "description": "lorem ipsum",
                "latitude": "-6.2275",
                "longitude": "107.0014",
                "created_at": "2023-12-19T12:29:49.000000Z",
                "updated_at": "2023-12-19T12:29:49.000000Z",
                "category_title": "Cuci Piring",
                "distance": 6509.226780098054,
                "distance_to_user": "6.51 km"
            }
        ],
        "all_works_with_distance": [
            {
                "id": 19,
                "image": "https://storage.googleapis.com/capstone-project-406502.appspot.com/works/image_6582ca9dba79d.jpg",
                "title": "yyfycy",
                "user_id": 2,
                "category_id": 5,
                "telephone": "082174532772",
                "min_budget": "150.000",
                "max_budget": "200.000",
                "type_of_work": "Part Time",
                "start_date": "2023-12-20",
                "description": "lorem ipsum",
                "latitude": "-6.347676938679681",
                "longitude": "106.96324434131384",
                "created_at": "2023-12-20T11:06:05.000000Z",
                "updated_at": "2023-12-20T11:06:05.000000Z",
                "category_title": "Menyapu",
                "distance": 15565.067119122492
            },
            {
                "id": 18,
                "image": "https://storage.googleapis.com/capstone-project-406502.appspot.com/works/image_6582c99572d8a.jpg",
                "title": "tedt",
                "user_id": 2,
                "category_id": 1,
                "telephone": "082174532772",
                "min_budget": "150.000",
                "max_budget": "200.000",
                "type_of_work": "Part Time",
                "start_date": "2023-12-20",
                "description": "lorem ipsum",
                "latitude": "-6.347255081164942",
                "longitude": "106.95058297365904",
                "created_at": "2023-12-20T11:01:41.000000Z",
                "updated_at": "2023-12-20T11:01:41.000000Z",
                "category_title": "Pertukangan",
                "distance": 15405.350853897966
            },
            {
                "id": 17,
                "image": "https://storage.googleapis.com/capstone-project-406502.appspot.com/works/image_6582c7c9e85d7.jpg",
                "title": "lorem ipsum",
                "user_id": 2,
                "category_id": 3,
                "telephone": "082174532772",
                "min_budget": "15.000",
                "max_budget": "30.000",
                "type_of_work": "Part Time",
                "start_date": "2023-12-20",
                "description": "lorem ipsum",
                "latitude": "-6.336076730885492",
                "longitude": "106.97626043111086",
                "created_at": "2023-12-20T10:54:02.000000Z",
                "updated_at": "2023-12-20T10:54:02.000000Z",
                "category_title": "Cuci Piring",
                "distance": 14552.610877287161
            },
            {
                "id": 16,
                "image": "https://storage.googleapis.com/capstone-project-406502.appspot.com/works/image_6582c3e4e77b9.jpg",
                "title": "lorem ipsum",
                "user_id": 2,
                "category_id": 6,
                "telephone": "082174532772",
                "min_budget": "10.000",
                "max_budget": "15.000",
                "type_of_work": "Part Time",
                "start_date": "2023-12-20",
                "description": "lorem ipsum",
                "latitude": "-6.355612860497951",
                "longitude": "106.91205203533173",
                "created_at": "2023-12-20T10:37:25.000000Z",
                "updated_at": "2023-12-20T10:37:25.000000Z",
                "category_title": "Mengepel",
                "distance": 16740.655641053272
            },
            {
                "id": 15,
                "image": "https://storage.googleapis.com/capstone-project-406502.appspot.com/works/image_6581f67f5f552.jpg",
                "title": "lorem ipsum",
                "user_id": 27,
                "category_id": 3,
                "telephone": "082174532772",
                "min_budget": "50.000",
                "max_budget": "60.000",
                "type_of_work": "Part Time",
                "start_date": "2023-12-22",
                "description": "lorem ipsum",
                "latitude": "-6.409763187393193",
                "longitude": "106.89230259507895",
                "created_at": "2023-12-19T20:01:03.000000Z",
                "updated_at": "2023-12-19T20:01:03.000000Z",
                "category_title": "Cuci Piring",
                "distance": 23109.427093379472
            },
            {
                "id": 14,
                "image": "https://storage.googleapis.com/capstone-project-406502.appspot.com/works/image_6581f442b1305.jpg",
                "title": "lorem ipsum",
                "user_id": 25,
                "category_id": 7,
                "telephone": "082174532772",
                "min_budget": "50.000",
                "max_budget": "50.000",
                "type_of_work": "Part Time",
                "start_date": "2001-12-20",
                "description": "lorem ipsum",
                "latitude": "-6.366979382378356",
                "longitude": "106.9184759259224",
                "created_at": "2023-12-19T19:51:30.000000Z",
                "updated_at": "2023-12-19T19:51:30.000000Z",
                "category_title": "Service Elektronik",
                "distance": 17842.40549829025
            },
            {
                "id": 13,
                "image": "https://storage.googleapis.com/capstone-project-406502.appspot.com/works/image_6581eb13778e4.png",
                "title": "Cuci Piring",
                "user_id": 2,
                "category_id": 6,
                "telephone": "08515536623",
                "min_budget": "10000",
                "max_budget": "20000",
                "type_of_work": "Kerja Lepas",
                "start_date": "2023-12-15",
                "description": "lorem ipsum",
                "latitude": "-6.2275",
                "longitude": "107.0014",
                "created_at": "2023-12-19T19:12:20.000000Z",
                "updated_at": "2023-12-19T19:12:20.000000Z",
                "category_title": "Mengepel",
                "distance": 6509.226780098054
            },
            {
                "id": 12,
                "image": "https://storage.googleapis.com/capstone-project-406502.appspot.com/works/image_65818fcbb6802.jpeg",
                "title": "Cuci Piring",
                "user_id": 2,
                "category_id": 3,
                "telephone": "08515536623",
                "min_budget": "10000",
                "max_budget": "20000",
                "type_of_work": "Kerja Lepas",
                "start_date": "2023-12-15",
                "description": "lorem ipsum",
                "latitude": "-6.2275",
                "longitude": "107.0014",
                "created_at": "2023-12-19T12:42:51.000000Z",
                "updated_at": "2023-12-19T12:42:51.000000Z",
                "category_title": "Cuci Piring",
                "distance": 6509.226780098054
            },
            {
                "id": 11,
                "image": "https://storage.googleapis.com/capstone-project-406502.appspot.com/works/image_65818f97000f4.jpeg",
                "title": "Cuci Piring",
                "user_id": 2,
                "category_id": 3,
                "telephone": "08515536623",
                "min_budget": "10000",
                "max_budget": "20000",
                "type_of_work": "Kerja Lepas",
                "start_date": "2023-12-15",
                "description": "lorem ipsum",
                "latitude": "-6.2275",
                "longitude": "107.0014",
                "created_at": "2023-12-19T12:41:59.000000Z",
                "updated_at": "2023-12-19T12:41:59.000000Z",
                "category_title": "Cuci Piring",
                "distance": 6509.226780098054
            },
            {
                "id": 10,
                "image": "https://storage.googleapis.com/capstone-project-406502.appspot.com/works/image_65818cae21749.jpeg",
                "title": "Cuci Piring",
                "user_id": 2,
                "category_id": 3,
                "telephone": "08515536623",
                "min_budget": "10000",
                "max_budget": "20000",
                "type_of_work": "Kerja Lepas",
                "start_date": "2023-12-15",
                "description": "lorem ipsum",
                "latitude": "-6.2275",
                "longitude": "107.0014",
                "created_at": "2023-12-19T12:29:49.000000Z",
                "updated_at": "2023-12-19T12:29:49.000000Z",
                "category_title": "Cuci Piring",
                "distance": 6509.226780098054
            },
            {
                "id": 9,
                "image": "https://storage.googleapis.com/capstone-project-406502.appspot.com/works/image_658189fd717fc.jpeg",
                "title": "Cuci Piring",
                "user_id": 2,
                "category_id": 3,
                "telephone": "08515536623",
                "min_budget": "10000",
                "max_budget": "20000",
                "type_of_work": "Kerja Lepas",
                "start_date": "2023-12-15",
                "description": "lorem ipsum",
                "latitude": "-6.2275",
                "longitude": "107.0014",
                "created_at": "2023-12-19T12:18:14.000000Z",
                "updated_at": "2023-12-19T12:18:14.000000Z",
                "category_title": "Cuci Piring",
                "distance": 6509.226780098054
            },
            {
                "id": 8,
                "image": "https://storage.googleapis.com/capstone-project-406502.appspot.com/works/image_657c73aa0dfc5.png",
                "title": "Cuci Piring",
                "user_id": 2,
                "category_id": 3,
                "telephone": "08515536623",
                "min_budget": "10000",
                "max_budget": "20000",
                "type_of_work": "Kerja Lepas",
                "start_date": "2023-12-15",
                "description": "lorem ipsum",
                "latitude": "-6.2275",
                "longitude": "107.0014",
                "created_at": "2023-12-15T15:41:30.000000Z",
                "updated_at": "2023-12-15T15:41:30.000000Z",
                "category_title": "Cuci Piring",
                "distance": 6509.226780098054
            }
        ]
    }
}
```
