# Batik-Comp Portfolio Feature Expansion — Implementation Plan

> **AI-Agent Edition.** Filled from `PLAN-TEMPLATE.md` for the target: *add 5 portfolio-worthy
> features to Batik-Comp — contact form, product detail, testimonials, multi-language, dashboard
> charts*. Scope locked with the user. Anything not listed here goes to §13 (Backlog).

---

## 1. Target & Mission

**Target:** Add five features that make Batik-Comp a stronger portfolio piece for web-making
services: a working contact form, product detail page, testimonials section, Indonesian/English
multi-language, and admin dashboard charts.

**Goals:**
1. Make the homepage contact form functional — store messages in DB, show success feedback.
2. Add a dedicated product detail page (`/produk/{id}`) with full description, image, price, and related products.
3. Build a database-driven testimonials section on the homepage with admin CRUD.
4. Add Indonesian/English language switching using `mcamara/laravel-localization`.
5. Add Chart.js charts (monthly revenue, orders per category) to the admin dashboard.

---

## 2. Status at a Glance (TRACKER — update after every session)

| Phase | Title | Status | Started | Finished | Session notes |
|-------|-------|--------|---------|----------|---------------|
| 0 | Environment / Recon | `done` | 2026-08-28 | 2026-08-28 | Git clean (only plan file untracked); Sail healthy; 9 migrations all Ran; 31 routes match inventory |
| 1 | Contact form backend | `done` | 2026-08-28 | 2026-08-28 | Created contact_messages table, ContactMessage model, ContactController, POST /kontak route; homepage form wired with CSRF + flash messages; verified via curl + tinker |
| 2 | Product detail page | `done` | 2026-08-28 | 2026-08-28 | Added ProductController@show, GET /produk/{id} route, product/show.blade.php with related products, linked product cards from homepage + product index; Pint clean |
| 3 | Testimonials section | `done` | 2026-08-28 | 2026-08-28 | Created testimonials table, Testimonial model with scopeActive, TestimonialSeeder (5 batik testimonials), AdminController CRUD, admin/testimonial.blade.php with DataTables, homepage testimonials section with stars + quotes, 4 routes; Pint clean |
| 4 | Multi-language (ID/EN) | `done` | 2026-08-28 | 2026-08-28 | Installed mcamara/laravel-localization, created SetLocale middleware, lang/id + lang/en message files (~80 keys), locale prefix group for public routes, root / redirects to /id, language switcher in navbar, all views updated with __() calls and locale-aware route() params, Pint clean |
| 5 | Dashboard charts | `done` | 2026-08-28 | 2026-08-28 | Added Chart.js 4.4.7 CDN, monthly revenue line chart (last 6 months), orders-per-category doughnut chart, brown/cream batik palette, responsive layout; Pint clean |
| 6 | Tests + lint verification | `done` | 2026-08-28 | 2026-08-28 | Created Pest tests: ContactFormTest, ProductDetailTest, TestimonialTest, LanguageSwitchTest; fixed existing tests for locale-prefixed routes; moved admin routes before locale group to fix route collision; all 34 tests pass, Pint clean |

**Status legend:** `not started` · `in progress` · `blocked` · `done`

---

## 3. Locked Technical Decisions

| Concern | Decision |
|---|---|
| Framework / language | Laravel 13.x, PHP ^8.3. No new dependencies without approval. |
| Database | MySQL via Laravel Sail. |
| Front end / styling | Bootstrap 5.3.3 CDN + Font Awesome 6 + `public/css/style.css`. Standalone blade views (no `@extends`). Indonesian UI text (except translated strings). |
| Build tooling | CDN only for new features. Vite/Tailwind stays limited to `welcome.blade.php`. |
| Auth | Existing session login + `auth` middleware on admin routes. |
| Validation | Inline `$request->validate([...])` in controllers. No Form Requests. |
| Data / content model | Flat Eloquent models, attribute style (`#[Fillable]` / `#[Hidden]` + `casts()`). Images in `public/uploads`. |
| Controllers | Flat `App\Http\Controllers` namespace. Public pages get their own controllers. Admin actions in `AdminController`. |
| Multi-language | `mcamara/laravel-localization` package. Route prefix (`/en`, `/id`). Language switcher in navbar. |
| Charts | Chart.js via CDN on admin dashboard. |
| New CSS | Only where genuinely needed. Add to `public/css/style.css`. |

> These are binding. Changes require an explicit user decision.

---

## 4. Current State (Inventory)

- **Controllers:** `AdminController`, `HomeController`, `ProductController`, `CategoryController`, `OrderController`.
- **Models:** `Product`, `Category`, `Order`, `Setting`, `User`.
- **Views (standalone, Indonesian):** `home/index`, `product/index`, `category/show`, `order/{success,track}`, `admin/{index,dashboard,product,user,order,order-show,category,setting}`.
- **Routes:** 6 public, 14 admin (auth-protected).
- **DB:** 5 tables (`users`, `products`, `categories`, `orders`, `settings`).
- **Missing for this plan:** `contact_messages` table, `testimonials` table, product detail route/view, `laravel-localization` package, Chart.js integration.

---

## 5. Target Map

### Public surfaces (new/modified)
| Route / URL | Handler / view | Purpose |
|---|---|---|
| `/produk/{id}` | `ProductController@show` → `product/show` | **NEW** Product detail page |
| `/kontak` (POST) | `ContactController@store` | **NEW** Store contact message |
| `/` (modified) | `HomeController@index` | + testimonials section + language switcher |
| `/id/{uri}` / `/en/{uri}` | localized routes | **NEW** Language-prefixed routes |

### Protected / admin surfaces (new/modified)
| Route / URL | Handler / view | Purpose |
|---|---|---|
| `/testimonial` + CRUD | `AdminController@testimonials/...` | **NEW** Testimonial management |
| `/dashboard` (modified) | `AdminController@dashboard` | + Chart.js charts |

### Error states
- Product not found → `findOrFail` (404).
- Contact form validation failure → `back()->withErrors()`.
- Testimonial not found → `findOrFail` (404).

---

## 6. Target File & Route Structure

```
Batik-Comp/
├── app/
│   ├── Http/Controllers/
│   │   ├── ContactController.php       # NEW: store contact messages
│   │   ├── ProductController.php       # + show($id) method
│   │   └── AdminController.php         # + testimonials CRUD, dashboard chart data
│   ├── Models/
│   │   ├── ContactMessage.php          # NEW
│   │   └── Testimonial.php             # NEW
├── database/
│   ├── migrations/
│   │   ├── create_contact_messages_table.php   # NEW
│   │   └── create_testimonials_table.php       # NEW
│   └── seeders/
│       └── TestimonialSeeder.php        # NEW
├── resources/views/
│   ├── product/show.blade.php          # NEW
│   └── admin/testimonial.blade.php     # NEW
├── routes/web.php                       # + new routes
└── public/css/style.css                 # minor additions
```

---

## 7. Data Model / Schema

### `contact_messages` (new)
| Column | Type | Notes |
|---|---|---|
| `id` | bigint unsigned PK | |
| `name` | string | customer name |
| `email` | string nullable | |
| `phone` | string nullable | |
| `subject` | string nullable | |
| `message` | text | required |
| `is_read` | boolean default false | admin can mark as read |
| `timestamps` | | |

### `testimonials` (new)
| Column | Type | Notes |
|---|---|---|
| `id` | bigint unsigned PK | |
| `customer_name` | string | |
| `customer_title` | string nullable | e.g. "B pengusaha batik" |
| `content` | text | testimonial text |
| `rating` | integer default 5 | 1–5 |
| `is_active` | boolean default true | show/hide on public |
| `sort_order` | integer default 0 | |
| `timestamps` | | |

### 7.1 Structured content
- No JSON/blob columns. Charts will query `orders` grouped by month/category.
- Language files: `lang/id/*.php` and `lang/en/*.php` for translatable strings.

---

## 8. Design Conventions & Reuse

- **No master layout.** Keep standalone blade views. Duplicate `<head>`, navbar, footer.
- **Reuse:** `btn-primary-custom`, `product-card`, `icon-box`, `bg-surface-low/lowest`, `border-outline-variant`, `ambient-shadow`, `font-headline`, `headline-md/sm`.
- **Admin CRUD pattern:** replicate `admin/product.blade.php` (header + table + modals).
- **Flash:** `redirect()->route(...)->with('success', '…')` + dismissible alerts.
- **Images:** `public/uploads` with prefix naming (`product_`, `category_`, `testimonial_`).
- **Language switcher:** simple link toggle in navbar, styled with existing `nav-link-custom`.
- **Charts:** Chart.js CDN, rendered in a `<canvas>` on dashboard. Data from controller as JSON.

---

## 9. Phases

> One phase per session. Do not start a phase whose Entry check is unmet.

### Phase 0 — Environment / Recon

**Goal:** Confirm environment is healthy and baseline matches tracker.

**Entry check:** None.

Steps:
- [ ] `git status` clean-ish; note working tree state.
- [ ] `./vendor/bin/sail up -d` and confirm services running.
- [ ] `./vendor/bin/sail artisan migrate:status` — all previous migrations applied.
- [ ] `./vendor/bin/sail artisan route:list` — matches §4 inventory.

**Verify:**
- [ ] No pending migrations.
- [ ] Routes match current state.

**Exit criteria:** Environment green. Phase 0 `done`.

---

### Phase 1 — Contact form backend

**Goal:** Make the homepage contact form functional — store messages, show confirmation.

**Entry check:** Phase 0 done.

Steps:
- [ ] `php artisan make:migration create_contact_messages_table` — per §7 schema.
- [ ] `php artisan make:model ContactMessage` — `#[Fillable]` attribute style.
- [ ] Create `ContactController.php` with `store(Request $request)` — validate name, email, phone, subject, message; save to DB; redirect back with success flash.
- [ ] Add `POST /kontak` route in `web.php`.
- [ ] Update `home/index.blade.php` contact form: set `action="{{ route('contact.store') }}"`, add `@csrf`, wire inputs to field names, show `$errors->first()` and success alert.

**Verify:**
- [ ] `./vendor/bin/sail artisan migrate` succeeds.
- [ ] Submit contact form → redirected back with success message.
- [ ] `ContactMessage::count()` increments after submit.

**Exit criteria:** Contact form stores messages in DB and shows feedback. Phase 1 `done`.

---

### Phase 2 — Product detail page

**Goal:** Add `/produk/{id}` with full product info and related products.

**Entry check:** Phase 0 done.

Steps:
- [ ] Add `show($id)` method to `ProductController` — find product with category, get 4 related products (same category, exclude self).
- [ ] Add `GET /produk/{id}` route named `product.show`.
- [ ] Create `resources/views/product/show.blade.php` — hero/header, product image, name, price, description, category badge, "Pesan" button (reuse existing order modal), related products grid.
- [ ] Update product grid cards (`product/index` and `home/index`) — link product name/image to detail page.

**Verify:**
- [ ] `/produk/1` renders with correct product data.
- [ ] Related products show same-category items.
- [ ] "Pesan" button on detail page opens order modal correctly.

**Exit criteria:** Product detail page works with related products. Phase 2 `done`.

---

### Phase 3 — Testimonials section

**Goal:** Database-driven testimonials on homepage + admin CRUD.

**Entry check:** Phase 0 done.

Steps:
- [ ] `php artisan make:migration create_testimonials_table` — per §7 schema.
- [ ] `php artisan make:model Testimonial` — attribute style, `scopeActive()`.
- [ ] `php artisan make:seeder TestimonialSeeder` — 5 demo testimonials (Batik-themed).
- [ ] Add testimonials CRUD routes + methods to `AdminController` (mirrors category CRUD pattern).
- [ ] Create `admin/testimonial.blade.php` — DataTable with add/edit modals (name, title, content, rating, active, sort_order).
- [ ] Add testimonials section to `home/index.blade.php` — grid of active testimonials with star rating, customer name, and quote. Place between "Produk Pilihan" and "Visi & Misi".
- [ ] Add testimonial image upload (optional photo field) — reuse `storeUploadedImage()` pattern.

**Verify:**
- [ ] `./vendor/bin/sail artisan migrate --seed` succeeds.
- [ ] Homepage shows seeded testimonials with stars.
- [ ] Admin can add/edit/delete testimonials.

**Exit criteria:** Testimonials display on homepage and are admin-manageable. Phase 3 `done`.

---

### Phase 4 — Multi-language (ID/EN)

**Goal:** Add Indonesian/English language switching via route prefix.

**Entry check:** Phases 1–3 done (all public views exist).

Steps:
- [ ] `composer require mcamara/laravel-localization` and publish config.
- [ ] Create `lang/id/*.php` and `lang/en/*.php` with translatable strings (hero text, about, section headings, buttons, form labels, footer text).
- [ ] Add localization middleware + route prefix group in `web.php` (`/{locale}/...`).
- [ ] Add language switcher to navbar — two links (`ID` | `EN`) that toggle the locale prefix.
- [ ] Update all public blade views to use `__()` helper for translatable strings.
- [ ] Set default locale to `id` in config.
- [ ] Keep admin routes outside the locale prefix (admin stays Indonesian).

**Verify:**
- [ ] `/id/` shows Indonesian text, `/en/` shows English text.
- [ ] Language switcher toggles correctly.
- [ ] Admin panel unaffected (still Indonesian).
- [ ] All public pages render in both languages without errors.

**Exit criteria:** Public site supports ID/EN switching. Phase 4 `done`.

---

### Phase 5 — Dashboard charts

**Goal:** Add Chart.js charts to admin dashboard (monthly revenue + orders per category).

**Entry check:** Phase 0 done.

Steps:
- [ ] Add Chart.js CDN to `admin/dashboard.blade.php`.
- [ ] Update `AdminController@dashboard` to pass chart data: monthly revenue (last 6 months), orders per category.
- [ ] Add `<canvas>` elements and Chart.js initialization scripts in dashboard view.
- [ ] Style charts to match batik theme (brown/cream color palette).

**Verify:**
- [ ] Dashboard renders with two visible charts.
- [ ] Charts display correct data from DB.
- [ ] Charts are responsive and styled.

**Exit criteria:** Admin dashboard shows revenue and category charts. Phase 5 `done`.

---

### Phase 6 — Tests + lint verification

**Goal:** Lock behavior with Pest tests and verify code style.

**Entry check:** Phases 1–5 done.

Steps:
- [ ] Pest tests: contact form store (validation, success), product detail (found, 404), testimonials CRUD, language switching.
- [ ] `vendor/bin/pint --dirty --format agent` after all PHP edits.
- [ ] Full `migrate:fresh --seed` and smoke test all new pages.

**Verify:**
- [ ] `php artisan test --compact` all green.
- [ ] `vendor/bin/pint --dirty --format agent` clean.
- [ ] Fresh install works end-to-end.

**Exit criteria:** All tests pass, code style clean. Phase 6 `done`.

---

## 10. Session Playbook (Resumability)

Every session, follow this loop:

1. Read §2 tracker → find `in progress` (or next `not started`) phase.
2. `git status` → confirm working tree matches last session's notes.
3. Set phase status `in progress` + `Started` date.
4. Work the unchecked `- [ ]` steps in order. Never start a phase whose Entry check is unmet.
5. Run the phase's `Verify` commands. Fix failures before moving on.
6. Update tracker (`done` / `blocked` + notes), tick completed boxes, then summarize to the user.

> If a phase cannot finish in one session, leave it `in progress`, check off completed steps,
> and note precisely which step to continue from.

---

## 11. Definition of Done (Global)

- Every checklist item in the phase is ticked and every `Verify` command passes.
- Locked technical decisions (§3) respected.
- Code follows Batik-Comp conventions (standalone views, `style.css` tokens, single `AdminController`, inline validation, Indonesian UI, `public/uploads` images).
- Test/lint commands all pass.
- Tracker in §2 is current and honest.

---

## 12. Risks & Open Questions

| Risk / Question | Mitigation / Decision needed |
|---|---|
| `mcamara/laravel-localization` may have version conflict | Check compatibility before installing; fallback to manual middleware if needed |
| Adding locale prefix changes all public URLs | Use redirect from `/` to `/id/` as default; SEO impact minimal for portfolio |
| Chart.js adds CDN dependency | Accepted — consistent with existing CDN approach (Bootstrap, DataTables) |
| Standalone views duplication increases with language files | Accepted — `__()` calls keep views DRY; only strings are translated |

---

## 13. Beyond Scope (Backlog — do NOT build unless asked)

- [ ] Email notifications on order status change.
- [ ] Product reviews/ratings by customers.
- [ ] Wishlist / save for later.
- [ ] Search functionality across products.
- [ ] Roles & permissions (admin vs staff).
- [ ] REST API endpoints.
- [ ] Blog/articles section.
- [ ] Gallery with lightbox.

---

## 14. Handoff Checklist (final phase)

- [ ] Final `migrate:fresh --seed` on clean DB.
- [ ] Confirm all new features work on fresh install.
- [ ] Update README with run instructions.
- [ ] Final `git` state: clean, single handoff commit if approved.
