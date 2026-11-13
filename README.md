# mikepage.dev

[![Tests](https://github.com/MikePageDev/mikepage.dev/actions/workflows/tests.yml/badge.svg)](https://github.com/MikePageDev/mikepage.dev/actions/workflows/tests.yml)

The website of Mike Page, a PHP and Laravel developer available for freelance work alongside a full-time role. I build bespoke internal applications, APIs and Filament admin panels.

**[Visit the site](https://mikepage.dev)** · **[Get in touch](https://mikepage.dev/contact)**

The code is public so you can see how I work. If you're thinking of hiring me, this is a small but real example of what you'd get: tested, secure and easy to maintain.

## Built with

- [Laravel 13](https://laravel.com) and PHP 8.5
- [Filament 5](https://filamentphp.com) for the admin panel and the contact form
- [Livewire 4](https://livewire.laravel.com)
- [Tailwind CSS 4](https://tailwindcss.com), built with Vite

The portfolio is two packages I built and released separately, so any Laravel site can use them:

- [`filament-portfolio`](https://github.com/MikePageDev/filament-portfolio): manage projects and case studies in a Filament panel.
- [`portfolio-frontend`](https://github.com/MikePageDev/portfolio-frontend): the public portfolio and case-study pages, with or without Filament.

## Worth a look

- **Tests and checks.** A PHPUnit test suite covers the pages, contact form, admin panel and data cleanup. PHPStan (via Larastan) and Pint keep the code typed and consistent. See `tests/`.
- **A spam-resistant contact form.** A honeypot field, rate limiting and strict validation. Enquiries are saved before they're emailed, so a mail outage never loses one. See `app/Livewire/ContactForm.php`.
- **A locked-down admin panel.** Only allow-listed email addresses can log in, and an authenticator-app code is required every time. See `app/Providers/Filament/AdminPanelProvider.php` and `app/Models/User.php`.
- **Enquiries in the admin panel.** A badge shows any enquiry whose email failed, and you can resend it from there. See `app/Filament/Resources/Enquiries/`.
- **Data cleanup that matches the privacy notice.** A daily job deletes enquiries after 12 months and IP addresses after 30 days, exactly as the [privacy notice](https://mikepage.dev/privacy) says. See `routes/console.php`.
- **Safe image uploads.** Portfolio screenshots must be ordinary image files. SVGs are refused because they can carry JavaScript.

## Running it locally

You'll need [Lando](https://lando.dev) and Node.js 22 or newer.

```bash
git clone git@github.com:MikePageDev/mikepage.dev.git
cd mikepage.dev
cp .env.example .env
```

Edit `.env` to use Lando's database and mail catcher:

```dotenv
APP_URL=https://mikepage-dev.lndo.site

DB_CONNECTION=mysql
DB_HOST=database
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=laravel

MAIL_MAILER=smtp
MAIL_SCHEME=null
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null

CONTACT_EMAIL=you@example.test
ADMIN_EMAILS=you@example.test
```

Then start it up:

```bash
lando start
lando composer install
lando artisan key:generate
lando artisan migrate
npm install
npm run build
```

The site is at <https://mikepage-dev.lndo.site>, and emails sent by the contact form appear in Mailpit at <https://mail.mikepage-dev.lndo.site>.

To use the admin panel, create a user with the email address from `ADMIN_EMAILS`, then log in at `/admin` and set up an authenticator app:

```bash
lando artisan make:filament-user
```

To fill the portfolio with example projects:

```bash
lando artisan db:seed --class=PortfolioExampleSeeder
```

### Tests and checks

```bash
lando composer test    # PHPUnit
lando composer stan    # PHPStan
lando composer lint    # code style (Pint)
npm run format:check   # Blade formatting
```

## Project layout

| Path | What's there |
| --- | --- |
| `app/Livewire/` | The contact form. |
| `app/Filament/` | Admin panel screens that belong to this site, such as enquiries. |
| `app/Mail/` | The enquiry email. |
| `routes/web.php` | The public pages. |
| `routes/console.php` | The scheduled data cleanup. |
| `resources/views/` | Page templates and the shared layout. |
| `tests/` | The test suite. |
| `docs/` | How to deploy the site and release the packages, plus design notes. |

## Licence

The code is open source under the [MIT licence](LICENSE.md).

The site's written content, photos and portfolio material are © Mike Page, all rights reserved. They aren't covered by the MIT licence, so please don't reuse them.
