{{--
    Deliberately self-contained: no layout, routes, database, Vite or Livewire,
    so this page still renders when whatever caused the error is broken.
--}}
@php
    $maintenance = $exception->getStatusCode() === 503;
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <title>{{ $maintenance ? 'Back soon' : 'Something went wrong' }} | Mike Page</title>
    <style>
        :root {
            color-scheme: light dark;
            --bg: #fff;
            --fg: #171717;
            --muted: #737373;
        }

        @media (prefers-color-scheme: dark) {
            :root {
                --bg: #171717;
                --fg: #f5f5f5;
                --muted: #a3a3a3;
            }
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--bg);
            color: var(--fg);
            font-family: system-ui, sans-serif;
            text-align: center;
            padding: 1.25rem;
            box-sizing: border-box;
        }

        main {
            max-width: 36rem;
        }

        h1 {
            font-size: 2.5rem;
            margin: 0 0 1.5rem;
        }

        p {
            font-size: 1.125rem;
            line-height: 1.6;
            margin: 0 0 1rem;
        }

        .muted {
            color: var(--muted);
        }

        a {
            color: inherit;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <main>
        @if ($maintenance)
            <h1>Back soon</h1>
            <p>The site is being updated and will be back in a few minutes.</p>
        @else
            <p class="muted">Error {{ $exception->getStatusCode() }}</p>
            <h1>Something went wrong</h1>
            <p>Sorry, something broke on my end. Please try again in a moment.</p>
            <p>If it keeps happening, email <a href="mailto:mike@mikepage.dev">mike@mikepage.dev</a>.</p>
        @endif
        <p><a href="/">Go to the home page</a></p>
    </main>
</body>

</html>
