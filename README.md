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

1.  git clone https://github.com/your-username/translation-api.gitcd translation-api

2.  composer install

3.  cp .env.example .env

4.  Generate a JWT secret:php artisan jwt:secret

    *   DB\_CONNECTION=mysqlDB\_DATABASE=translation\_apiDB\_USERNAME=rootDB\_PASSWORD=secretJWT\_SECRET=your\_generated\_secret

5.  php artisan migrate

6.  php artisan db:seed

7.  php artisan serveThe API is available at:http://localhost:8000/api


🔑 Authentication
-----------------

This project uses **JWT (JSON Web Tokens)** for authentication.Include a Bearer token in requests:

Plain textANTLR4BashCC#CSSCoffeeScriptCMakeDartDjangoDockerEJSErlangGitGoGraphQLGroovyHTMLJavaJavaScriptJSONJSXKotlinLaTeXLessLuaMakefileMarkdownMATLABMarkupObjective-CPerlPHPPowerShell.propertiesProtocol BuffersPythonRRubySass (Sass)Sass (Scss)SchemeSQLShellSwiftSVGTSXTypeScriptWebAssemblyYAMLXML`Authorization: Bearer`

🧪 Running Tests
----------------

Feature tests are included for repository and API endpoints.

Plain textANTLR4BashCC#CSSCoffeeScriptCMakeDartDjangoDockerEJSErlangGitGoGraphQLGroovyHTMLJavaJavaScriptJSONJSXKotlinLaTeXLessLuaMakefileMarkdownMATLABMarkupObjective-CPerlPHPPowerShell.propertiesProtocol BuffersPythonRRubySass (Sass)Sass (Scss)SchemeSQLShellSwiftSVGTSXTypeScriptWebAssemblyYAMLXML`   php artisan test   `

If you use MySQL in production, update .env.testing to use MySQL for more reliable JSON queries (SQLite lacks full JSON support).

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

*   GET /api/translations → List translations

*   POST /api/translations → Create a new translation

*   PUT /api/translations/{key} → Update an existing translation

*   DELETE /api/translations/{key} → Delete a translation
