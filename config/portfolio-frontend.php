<?php

return [

    // Turn the public portfolio routes off without uninstalling the package.
    'enabled' => true,

    // URL prefix: /portfolio and /portfolio/{slug}.
    'prefix' => 'portfolio',

    'middleware' => ['web'],

    // Blade component the pages render inside. It receives `title` and `description` (nullable) props.
    'layout' => 'layout',

    // Index page title and heading.
    'title' => 'Portfolio',

    // Index page meta description. Null leaves it out.
    'description' => 'Selected projects and case studies: Laravel applications, admin panels and backend work.',

    // Paragraph under the index heading. Null leaves it out.
    'intro' => "A selection of things I've built, with the problem each one solved and the part I played.",

    // Shown on the index page when there are no published projects.
    'empty_message' => 'Project write-ups are on their way.',

    // Heading above a project's role on the case-study page.
    'role_heading' => 'My role',

    // Route the contact prompts link to. Null turns the prompts off; so does a route that doesn't exist.
    'contact_route' => 'contact',

    // Prompt after the empty message on the index page. [text] marks the link. Null leaves it out.
    'index_contact_prompt' => 'In the meantime, [get in touch] to ask about my work.',

    // Prompt at the end of a case study. [text] marks the link. Null leaves it out.
    'case_study_contact_prompt' => 'Need something similar? [Get in touch].',

];
