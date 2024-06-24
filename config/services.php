<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'webhook' => [
            'secret' => env('STRIPE_WEBHOOK_SECRET'),
            'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
        ],
    ],

    'facebook' => [
        'client_id'     => env('FB_CLIENT_ID'),
        'client_secret' => env('FB_CLIENT_SECRET'),
        'redirect'      => env('FB_CLIENT_REDIRECT'),
    ],

    'firebase' => [
        'database_url' => env('FIREBASE_DATABASE_URL', ''),
        'project_id' => env('FIREBASE_PROJECT_ID', 'gtg-beauty'),
        'private_key_id' => env('FIREBASE_PRIVATE_KEY_ID', '93a302ab660ea9685bfa440b66e5240681d90092'),
        'private_key' => str_replace("\\n", "\n", env('FIREBASE_PRIVATE_KEY', 'MIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQCiCEA7IyzgK0Y5\nsYFt5/9jALH/Egw40+Qw36LHtN7dNTBOy1t2aiE/9VGwG6Win6tF2KnZBiC8MfpN\nO3N+XgltaokyAx3iwQoCCXSPuMAAssd2rw453Bedvjh0csDhZC9LKYb5lwd1nbBl\nhyVZPcFP/awQNclhP1VHwSWZcG4ByMAE4k2toFnkOQtcpi5PIermKv+G/YViL/Wy\nCofhQufz1IOjTP1GhKoBfVQ8HL9CEOpmVWbmiDef2fzF+jKDMg27A2fuw08FdMq2\nn6mudRGLwPbXDtTU6iuS2ITXhfiT9cfFxTxDEYWAR+4LmVJ1fdLgq6ANqEnRqoSF\nFAPx7QwfAgMBAAECggEAR3XbGhnD12POd3BdNEMuw5ORbPyhLkjpKVLgIDKZXbbx\nBLc0Mc/RtTr02XYAAW5o44eQNPo6YrWp/fjb0V4Yy0xCkK+GNTTMvKQ954rkBwrR\n5HqFDCiQs82qaVUY0u7T2tLIR/h/XjR7EPPfGXIeeTBX+9g05fJAIsLA2eCXa6pR\nXFcIja/DnKwjhcA1QtQwSxb4+kTpK0l6lBdtn4DToIjY4Uu1jpaOqK4xU9O8SoSx\n9q+/mBfIQdry8kmFJ2Y9eA3z489E3dzW8N5BzlQhZodRcJ7dA6fX0S4xg21CdD5O\nBAL+A/DpcwWdEcSsag5oVA9ReoePht1puh4Iw1aYHQKBgQDZNjNy8E4ErYt/3occ\nnXQzX+cofnE72fXru+2ByL03zXQWD8qaJk7+Yxt8b+AtkQqSauan0L5x35IrOGWI\nQFz1VIvr3Ap36AUjRI+RiQSQIr7GQOWkI5LyV/z732W7Qo/aWhdBbnSESiUpyjTh\nib4SgWVnN2WESHf0tADyNPo+hQKBgQC+94c+AMmWCflfdNLnGaJjO9rAGIycbrVN\nxTjr8QZM31NYzz/YbjVU5akjReap16sSZK7/WnQgQ7w03XsFHhOYqB7RL+i4UVz+\ndt22vW+fSJynGnlL8z4wdzR9O4n9S3CCYntCdmtLo06u/Ht2obSh53fO1ALC23nG\nsdwiasPbUwKBgHf3O4srtatXvkgtOypOvDLzsNPoodmQlAZSkOaxW/BKBOd6aUei\nCNbvHesoTwRbqx8a87GT1NtHw48jYtBR3AWTYIQvz4hSGSRVZYXXyzFgP0V36l0x\nWKOIfS0PQTyfkpviTh3RR4EZAlWGXJaEYPoPhVXwfp0E+VupXyxmnh+RAoGABFI/\nmjSUWzPQk8tl9lrLJOm20n/7tpJ+wcrDtfsXRGgNT8Yo0LH1vP0Rbb3oMVGzClCC\n8T5PwGcn/B5C6WO718l+IQevgXQ94Xg5Hih9PSJ8gP+FXSWc86XO50KQpc2uNxUZ\navCZDvYcErOd65pPJxbAzEpZ4aTrxYZCz/iQhAcCgYBQVEt+YTfH/6dh8C5SDNcb\nkILPVdVP04P/lRHMyV1ww8KvjKKMNV0fWGbsWhJ+unvqtXnXe+RMq/yD2VEh+/ZM\nl8NxGeNsLN9b/sBxS3mTS+3OxtiwRc7WRw1pxpQ7U6pqyYf0V+YkcJmP2jgGTiEp\nQ5hdyvgoscvpJdDqu1JVrQ==')),
        'client_email' => env('FIREBASE_CLIENT_EMAIL', 'firebase-adminsdk-6y1ij@gtg-beauty.iam.gserviceaccount.com'),
        'client_id' => env('FIREBASE_CLIENT_ID', '111438433666771231719'),
        'client_x509_cert_url' => env('FIREBASE_CLIENT_x509_CERT_URL', 'https://www.googleapis.com/robot/v1/metadata/x509/firebase-adminsdk-6y1ij%40gtg-beauty.iam.gserviceaccount.com'),
    ]

];
