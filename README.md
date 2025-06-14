First, install the project using:
composer install

Then migrate the tables:
php artisan migrate

Then run the seeder for sample data:
php artisan db:seed --class=TranslationSeeder

--------------------------
Testing the API
--------------------------

1. **Register a User**

API Endpoint:
http://127.0.0.1:8000/api/register/

Request Type:
POST

Sample Body:
{
    "name": "Ibrahim",
    "email": "ibrahimmemon1709@gmail.com",
    "password": "123456789"
}

Response:
Returns an authentication token. Save this token for authorization in subsequent requests.

--------------------------

2. **Create a Translation Entry**

API Endpoint:
http://127.0.0.1:8000/api/translations

Request Type:
POST

Headers:
Authorization: Bearer <token>

Sample Body:
{
  "locale": "en",
  "key": "welcome_message",
  "value": "Welcome to the app!",
  "tags": ["mobile", "web"]
}

Response:
Saves the translation data.

--------------------------

3. **Get Translations**

API Endpoint:
http://127.0.0.1:8000/api/translations

Request Type:
GET

Headers:
Authorization: Bearer <token>

Response:
Returns the first 10 translation records.

--------------------------

4. **Update a Translation Entry**

API Endpoint:
http://127.0.0.1:8000/api/translations/[id]

Request Type:
PUT

Headers:
Authorization: Bearer <token>

Sample Body:
{
  "locale": "en",
  "key": "welcome_message",
  "value": "Welcome to the app!",
  "tags": ["mobile", "web"]
}

Response:
Updates the specified translation entry.

--------------------------

5. **Export All Translations**

API Endpoint:
http://127.0.0.1:8000/api/translations/export

Request Type:
GET

Headers:
Authorization: Bearer <token>

Response:
Exports all translations in JSON format.
