# Goducate Web

![PHP](https://img.shields.io/badge/PHP-7.4%2B-777BB4?logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-8-FF2D20?logo=laravel&logoColor=white)
![Vue](https://img.shields.io/badge/Vue-2-42b883?logo=vue.js&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-5.7%2B-4479A1?logo=mysql&logoColor=white)
![License](https://img.shields.io/badge/license-MIT-green)

> A full-featured venue booking and education management system developed as a thesis project.

Goducate Web provides end-to-end management for an educational venue — from public-facing bookings and payments to a staff admin panel covering accommodations, volunteers, surveys, QR code check-in, announcements, reports, and a point-of-sale module.

---

## Table of Contents

- [Technology Stack](#technology-stack)
- [Features](#features)
- [Project Structure](#project-structure)
- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Environment Variables](#environment-variables)
- [Running Tests](#running-tests)
- [API Endpoints](#api-endpoints)
- [Key Routes](#key-routes)
- [Security Notes](#security-notes)
- [License](#license)

---

## Technology Stack

### Backend
| Layer | Technology |
|---|---|
| Framework | Laravel 8 (PHP) |
| Database | MySQL 5.7+ |
| Authentication | Laravel Auth + Google OAuth (Socialite) |
| Role-based access control | Spatie Laravel Permission |
| Online payments | Stripe |
| Push notifications | Web Push / VAPID (minishlink/web-push) |
| QR code generation | SimpleSoftwareIO/QrCode |
| Image processing | Intervention Image |
| Data export | Maatwebsite Excel |
| ID obfuscation | Vinkla/Hashids |
| PWA support | ladumor/laravel-pwa |

### Frontend
| Layer | Technology |
|---|---|
| Templating | Blade + Bootstrap 4 |
| UI framework | Vue 2 + Vuetify 2 |
| Icons | Font Awesome 6 + Material Design Icons |
| Rich text editor | TinyMCE 7 |
| Calendar | FullCalendar 6 |
| QR code scanner | html5-qrcode |
| Date handling | Moment.js |
| Alerts & dialogs | SweetAlert2 |
| Select inputs | Select2 |
| Image gallery | blueimp-gallery |
| Multi-step forms | SmartWizard |
| Autocomplete | EasyAutocomplete |
| Build tool | Laravel Mix (Webpack) |

---

## Features

### Public-facing
- **Booking** — overnight stays, day tours, and place reservations with date validation and accommodation selection
- **Online payment** — Stripe checkout and manual payment upload (JPEG/PNG/PDF, max 5 MB)
- **Volunteer registration** — public sign-up form with admin approval workflow
- **Survey & feedback** — separate survey and feedback submission forms
- **Activities & about us** — CMS-managed content pages
- **QR code self-service** — guests can generate and download their booking QR codes

### Admin panel
- **Dashboard** — booking summary, pending items, and push subscriber count
- **Booking management** — view, approve, and delete bookings across all booking types
- **Customer management** — customer records, payment history, QR code generation
- **Accommodation management** — room types, capacity, pricing, and images
- **Employee management** — staff records
- **User & role management** — RBAC with Spatie Permission (roles, permissions)
- **Volunteer management** — list, verify, bulk approve/disapprove
- **Announcements** — time-limited announcements with auto-expiration
- **QR code verification** — scan and verify guest QR codes at check-in
- **Reports & charts** — activity, demographic, booking, and feedback charts
- **Point-of-sale** — item management and sale processing
- **Price monitoring** — track and manage pricing
- **Web push notifications** — send alerts to individual subscribers or broadcast to all

### Security & infrastructure
- Rate limiting on all public mutation endpoints (registration, booking, payment, survey, QR verify)
- FormRequest validation on all mutating routes
- All secrets stored in `.env` — never in source code
- File upload validation — MIME type and size enforced server-side
- Soft deletes on all primary entities for data recovery
- CSRF protection on all web routes

---

## Project Structure

```
app/
├── Http/
│   ├── Controllers/              # 22 controllers
│   ├── Middleware/               # Auth, CSRF, permissions
│   └── Requests/                 # 10 FormRequest validation classes
├── Models/                       # 25 Eloquent models with SoftDeletes
├── Services/
│   ├── BookingService.php        # Booking creation, approval, deletion
│   ├── PaymentService.php        # Payment recording and file handling
│   └── PushNotificationService.php  # Web push dispatch
├── Mail/                         # SendMail, SendApprovedMail
└── Helpers/                      # GlobalHelper (regions, currencies)

routes/
├── web.php                       # Entry point — loads the files below
├── public.php                    # Unauthenticated routes + Auth::routes()
├── booking.php                   # Public booking submission endpoints
└── admin.php                     # Auth-gated admin routes

database/
├── migrations/                   # 40+ migrations
├── factories/
└── seeders/

tests/
├── Feature/
│   ├── BookingTest.php           # Booking creation, validation, status, deletion
│   └── PaymentTest.php          # Payment validation, file type/size, auth guard
└── Unit/
```

---

## Prerequisites

- PHP >= 7.4 (8.x recommended)
- Composer 2
- Node.js 16 + npm 8
- MySQL 5.7+

---

## Installation

```bash
# 1. Clone the repository
git clone https://github.com/tyser1995/goducate_web.git
cd goducate_web

# 2. Install PHP dependencies
composer install

# 3. Create environment file
cp .env.example .env
php artisan key:generate

# 4. Configure .env (see Environment Variables below)

# 5. Run database migrations
php artisan migrate

# 6. (Optional) Seed sample data
php artisan db:seed

# 7. Generate VAPID keys for web push
php artisan webpush:vapid
# Paste the output into VAPID_PUBLIC_KEY and VAPID_PRIVATE_KEY in .env

# 8. Install and build frontend assets
npm install
npm run production

# 9. Start the development server
php artisan serve
```

Visit `http://localhost:8000`.

---

## Environment Variables

Copy `.env.example` to `.env` and fill in the following:

### Application
| Variable | Description |
|---|---|
| `APP_NAME` | Application display name |
| `APP_ENV` | `local` / `production` |
| `APP_DEBUG` | `true` in development only |
| `APP_URL` | Full URL of the app (e.g. `https://goducate.example.com`) |

### Database
| Variable | Description |
|---|---|
| `DB_DATABASE` | MySQL database name |
| `DB_USERNAME` | MySQL username |
| `DB_PASSWORD` | MySQL password |

### Mail
| Variable | Description |
|---|---|
| `MAIL_MAILER` | `smtp` / `mailgun` / `ses` |
| `MAIL_HOST` | SMTP host |
| `MAIL_PORT` | SMTP port |
| `MAIL_USERNAME` | SMTP username |
| `MAIL_PASSWORD` | SMTP password |
| `MAIL_FROM_ADDRESS` | Sender address |

### Google OAuth
| Variable | Description |
|---|---|
| `GOOGLE_CLIENT_ID` | From Google Cloud Console |
| `GOOGLE_CLIENT_SECRET` | From Google Cloud Console |
| `GOOGLE_REDIRECT_URL` | `{APP_URL}/google/callback` |

### Stripe
| Variable | Description |
|---|---|
| `STRIPE_KEY` | Stripe publishable key |
| `STRIPE_SECRET` | Stripe secret key |

### Web Push (VAPID)
| Variable | Description |
|---|---|
| `VAPID_PUBLIC_KEY` | Generated via `php artisan webpush:vapid` |
| `VAPID_PRIVATE_KEY` | Generated via `php artisan webpush:vapid` |
| `VAPID_SUBJECT` | `mailto:contact@example.com` or your site URL |

---

## Running Tests

```bash
# Run all tests
php artisan test

# Run with coverage report
php artisan test --coverage

# Run a specific test file
php artisan test tests/Feature/BookingTest.php
php artisan test tests/Feature/PaymentTest.php
```

Tests use an in-memory SQLite database (`phpunit.xml`) — no MySQL setup required.

---

## API Endpoints

| Method | Endpoint | Description | Auth |
|---|---|---|---|
| `POST` | `/api/push-subscribe` | Subscribe browser to push notifications | No |
| `POST` | `/api/push-subscribe-residents` | Subscribe a registered resident | No |
| `GET` | `/api/user` | Get authenticated user | Bearer token |

---

## Key Routes

| Method | Endpoint | Description | Auth |
|---|---|---|---|
| `GET` | `/` | Public home page | No |
| `GET` | `/_booking` | Booking page | No |
| `POST` | `/bookings.store` | Submit a booking | No |
| `POST` | `/bookings.overnight_stay` | Submit overnight stay details | No |
| `POST` | `/bookings.day_tour` | Submit day tour details | No |
| `POST` | `/bookings.place_reservation` | Submit place reservation details | No |
| `GET` | `/checkout/{id}` | Stripe checkout page | No |
| `POST` | `/checkout.process` | Process Stripe payment | No |
| `GET` | `/qr.code` | Generate guest QR code | No |
| `POST` | `/verify-code` | Verify a scanned QR code | No |
| `GET` | `/dashboard` | Admin dashboard | Yes |
| `GET` | `/bookings` | Admin booking list | Yes |
| `GET` | `/customers` | Admin customer list | Yes |
| `POST` | `/admin/sendNotif/{sub}` | Send push to one subscriber | Yes |
| `POST` | `/admin/broadcast` | Broadcast push to all subscribers | Yes |

---

## Security Notes

- **Never commit `.env`** — all secrets (VAPID, Stripe, OAuth) must stay out of source control.
- **Rotate VAPID keys** on each fresh deployment: `php artisan webpush:vapid`
- Rate limiting is enforced on all public mutation endpoints (5–20 req/min depending on sensitivity).
- Payment proof uploads are restricted server-side to JPEG, PNG, and PDF, max 5 MB.
- All passwords are hashed with bcrypt via Laravel's `Hash` facade.
- CSRF protection is active on all web routes via Laravel's default middleware.

---

## License

MIT
