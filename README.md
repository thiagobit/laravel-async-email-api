# Async Email API

An API done in Laravel 8.29.0 for sending asynchronous emails, using Redis and Laravel Horizon.

## Requirements
- [Redis Server](https://redis.io/download).

## Authentication

The API works with JWT authentication.
Token needs to be sent in `api_token` parameter.

## Endpoints

### api/list
- Description: List all sent emails with downloadable attachments.
- Method: `GET`
- Needs Authentication: `true`
- Parameters: -
- Example:
  - Input:
    ```
    ```
  - Output:
    ```
    [
      {
        "email": "me@me.com",
        "subject": "My Subject",
        "body": "<html><body><h1>My message.</h1></body></html>",
        "attachments": [
          {
            "url": "http://127.0.0.1:8000/storage/foo.jpg"
          }
        ]
      },
      {
        "email": "you@you.com",
        "subject": "Your Subject",
        "body": "<html><body><h1>Your message.</h1></body></html>",
        "attachments": [
          {
            "url": "http://127.0.0.1:8000/storage/foo.jpg"
          },
          {
            "url": "http://127.0.0.1:8000/storage/bar.jpeg"
          },
        ]
      },
      {
        "email": "we@we.com",
        "subject": "Our Subject",
        "body": "<html><body><h1>Our message.</h1></body></html>",
        "attachments": []
      }
    ]
    ```

### api/send
- Description: Send email to the queue.
- Method: `POST`
- Needs Authentication: `true`
- Parameters:
    - `emails`
        - Description: List of emails to be sent.
        - Type: `array`
    - `email`
        - Description: Email address of the receiver.
        - Type: `string`
    - `subject`
        - Description: Subject of the message.
        - Type: `string`
    - `body`
        - Description: Content of the message.
        - Type: `string`
    - `attachments`
        - Description: List of attachments.
        - Type: `array`
    - `name`
        - Description: Name of the attached file.
        - Type: `string`
    - `file`
        - Description: Content of the attached file.
        - Type `base64`
- Example:
    - Input:
      ```
      {
        "emails": [
          {
            "email": "me@me.com",
            "subject": "My Subject",
            "body": "<html><body><h1>My message.</h1></body></html>",
            "attachments": [
              {
                "name": [name of the file],
                "file": [base64 representation of the file]
              }
            ]
          },
          {
            "email": "you@you.com",
            "subject": "Your Subject",
            "body": "<html><body><h1>Your message.</h1></body></html>",
            "attachments": [
              {
                "name": [name of the file],
                "file": [base64 representation of the file]
              },
              {
                "name": [name of the file],
                "file": [base64 representation of the file]
              }
            ]
          },
          {
            "email": "we@we.com",
            "subject": "Our Subject",
            "body": "<html><body><h1>Our message.</h1></body></html>",
            "attachments": []
          }
        ]
      }
      ```
    - Output:
      ```
      ```
## Installation
1. Clone this repository:
```
git clone git@github.com:thiagobit/async-email-api.git
```

2. Create .env and change it accordingly to your environment:
```
cp .env.example .env
```

3. Install composer dependencies:
```
composer install
```

4. Run migrations:
```
php artisan migrate
```

5. Generate application key:
```
php artisan key:generate
```

6. Start application:
```
php artisan serve
```

7. Start Horizon (access: `[APP_URL]`/horizon):
```
php artisan horizon
```

## Extras
- You can create your user and get your `api_token` using `php artisan tinker` and the command:
  ```
  User::factory()->create();
  ```
- Do not forget to add `Accept: application/json` in the `Header` of the calls.
- For email provider, I recomment [Mailtrap](https://mailtrap.io/), it's really easy to use and configure.
- To run the tests, I recommend to use SQLit in memory, for this just uncomment `DB_CONNECTION` and `DB_DATABASE` directives in `phpunit.xml`.
