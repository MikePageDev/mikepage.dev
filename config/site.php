<?php

return [

    // Default meta / Open Graph description for pages that don't set their own.
    'description' => 'Freelance Laravel developer building and maintaining custom web applications, APIs and Filament admin panels.',

    // Image used when a page is shared on social media (path relative to public/).
    'og_image' => 'img/mike.jpg',

    // Shown on the contact page when set.
    'contact_email' => env('CONTACT_EMAIL'),

    // Only these email addresses can use the admin panel (comma-separated ADMIN_EMAILS). Empty means nobody.
    'admin_emails' => (function (): array {
        $raw = env('ADMIN_EMAILS');

        if (! is_string($raw)) {
            return [];
        }

        return array_values(array_filter(array_map(
            fn (string $email): string => strtolower(trim($email)),
            explode(',', $raw),
        )));
    })(),

];
