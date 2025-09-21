Translation Management Service API
==================================

A Laravel-based API for managing translation keys and their values across multiple languages. This project uses a **repository pattern**, form requests for validation, Laravel queues for processing of large dataset and is powered by JWT-based authentication.

⚙️ Requirements
---------------

*   PHP >= 8.1

*   Composer

*   MySQL (recommended)


🚀 Setup Instructions
---------------------

1. git clone https://github.com/your-username/translation-api.gitcd translation-api

2. composer install

3. cp .env.example .env

4. Generate a JWT secret:php artisan jwt:secret

5. php artisan migrate

6. php artisan db:seed --class=TranslationTestDataSeeder

    * DB seeder will create 180K records for testing
    * You can change the number of records by changing the seeder class.
   
7. translations:rebuild <langCode e.g. en>
   
    * This command will rebuild the translation cache for the given language. If you want to rebuild all the languages, you can use the command: translations:rebuild without any argument. 

8. php artisan queue:work --tries=3
    
    * This will start the queue worker to process the translation cache building in the background whenever a translation key is created, updated or deleted. 
    * To reduce the response time while fetching the translations in JSON format,  

9. php artisan serve 
   * The API is available at:http://127.0.0.1:8000/api


🔑 Authentication
-----------------

This project uses **JWT (JSON Web Tokens)** for authentication. Include a Bearer token in requests:

`Authorization: Bearer <token>`

🧪 Running Tests
----------------

Feature tests are included for repository and API endpoints.

`php artisan test   `

🏗️ Design Choices
------------------

*   **Repository Pattern**Business logic is abstracted into repositories (TranslationRepository) for clean separation of concerns and easier testing.

*   **Form Requests for Validation**Ensures consistent validation and automatic error responses.

*   **JWT Authentication**Stateless, secure, and API-friendly authentication layer.

*   **Resourceful Routing**REST-style resource routes (translations.index, translations.store, etc.) for predictable API structure.

*   **Database Transactions**Ensures atomic operations when creating, updating, or deleting translations with multiple values.

*   **Queue/Events Ready**The architecture is designed so that cache updates, notifications, or external sync jobs can easily be queued when translations change.


📦 API Endpoints (Sample)
-------------------------

*   POST /api/login → To log in and receive a JWT token

*   POST /api/logout → To log out and invalidate the JWT token

*   GET /api/user → To get the current user

*   GET /api/register → To register a new user

*   GET /api/translations → List translations with pagination

*   POST /api/translations → To store a new translation

*   PUT/PATCH /api/translations/{translationKey} → To update an existing translation

*   DELETE / api/translations/{translationKey} → To delete a translation

*   /api/translations-json/{lang} → To get all translations in JSON format for a given language code e.g en, fr, etc.

