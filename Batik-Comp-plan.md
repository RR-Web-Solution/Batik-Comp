# Batik-Comp Feature Expansion — Implementation Plan

> **AI-Agent Edition.** Filled from `PLAN-TEMPLATE.md` for the target: *add features to
> Batik-Comp inspired by `digital-printing-website`* (orders + WhatsApp + tracking, site settings,
> product categories, admin dashboard stats, DataTables print/PDF/export — plus auth middleware on
> admin routes). Scope locked in prior session with the user. Anything not listed here goes to
> §13 (Backlog), not into the build.

---

## 1. Target & Mission

**Target:** Turn Batik-Comp (currently a static company profile + bare product catalog + minimal admin)
into a functioning batik storefront: browsable categories, WhatsApp ordering with order numbers and
customer tracking, admin-editable site settings, a stats dashboard, and print/exportable admin tables —
all wearing Batik-Comp's existing Bootstrap 5.3 + `style.css` batik theme.

**Goals:**
1. Let customers order a batik product via a modal → get an `ORD-…` number → continue to WhatsApp → track status on a `/lacak` page.
2. Group the existing 15 products into categories with a category page, and make site contact info (WhatsApp, email, address, hours) editable from admin.
3. Give the admin real tools: stat dashboard, order management with statuses, category CRUD, settings form, and copy/CSV/Excel/PDF/Print buttons on tables.
4. Protect all admin routes with Laravel's `auth` middleware.

---

## 2. Status at a Glance (TRACKER — update after every session)

| Phase | Title | Status | Started | Finished | Session notes |
|-------|-------|--------|---------|----------|---------------|
| 0 | Environment / Recon | `done` | 2026-08-19 | 2026-08-19 | Git clean; Sail healthy; no pending migrations; routes match inventory |
| 1 | Migrations (categories, orders, settings, products alter) | `done` | 2026-08-19 | 2026-08-19 | 4 migrations created + applied batch 2; existing data intact |
| 2 | Models + factories + seeders | `done` | 2026-08-19 | 2026-08-19 | Category/Order/Setting models (User attribute style); Product +category/is_featured/sort_order; OrderFactory + 3 seeders; ProductSeeder & admin-user seeding made idempotent |
| 3 | Settings wiring + public data plumbing | `done` | 2026-08-19 | 2026-08-19 | Home & product pass $setting; homepage contact data-driven + WhatsApp link; Kategori cards + Produk Pilihan grid added |
| 4 | Public categories + order flow (front) | `done` | 2026-08-19 | 2026-08-19 | Category page (hero+price table+grid), order modal on products+home, order store/success/track with stepper, WhatsApp CTA verified via curl |
| 5 | Admin: auth, dashboard, orders, categories, settings, DataTables | `done` | 2026-08-19 | 2026-08-19 | auth middleware on all admin routes (redirect to /admin verified); dashboard stats, order list/show/PATCH status, category CRUD (image upload), settings form — all verified via curl; DataTables stack + Indonesian locale + copy/CSV/Excel/PDF/Print on dashboard/order/product/user/category; product/user got expanded nav + DataTables |
| 6 | Tests + lint + migrate/seed verification | `done` | 2026-08-19 | 2026-08-19 | 4 Pest feature files (20 tests, 52 assertions) green; Product/Category gained HasFactory + factories; latent bugs fixed: CategoryController filtered products by non-existent is_active (now removed), $setting null-unsafe in views/Order::whatsappUrl (now `?? new Setting` / nullsafe); pint clean; migrate:fresh --seed + full public/admin smoke pass on fresh DB |

**Status legend:** `not started` · `in progress` · `blocked` · `done`

---

## 3. Locked Technical Decisions

| Concern | Decision |
|---|---|
| Framework / language | Laravel 13.x (installed 13.24.0), PHP ^8.3 (CLI 8.4). Do not change dependencies without approval. |
| Database | MySQL via Laravel Sail (`compose.yaml`), `DB_HOST=mysql`, DB `laravel`. Migrations via `./vendor/bin/sail artisan`. |
| Front end / styling | Bootstrap 5.3.3 CDN + Font Awesome 6 CDN + Google Fonts (Source Serif 4 + Work Sans) + single custom `public/css/style.css`. **Standalone blade views** (no `@extends` layouts). Indonesian UI text. |
| Build tooling | None for new features — all CDN. Vite/Tailwind stays limited to `welcome.blade.php`. DataTables stack loaded from CDN (jQuery, Buttons html5/print, JSZip, pdfmake). |
| Auth | Existing session login via `Auth::attempt` in `AdminController@action`. Add Laravel `auth` middleware to all admin routes; unauthenticated redirect to `/admin` login. |
| Validation | Inline `$request->validate([...])` inside controllers (existing style). No Form Requests. |
| Data / content model | Flat Eloquent models in `app/Models`; images stored in `public/uploads`; single-row `settings` table; order statuses `menunggu|baru|diproses|selesai|ditolak`. New models use the **attribute style like `User.php`**: `#[Fillable([...])]` / `#[Hidden([...])]` + `casts()` method (user-confirmed "use the proper one"). |
| Settings sharing | `$setting` passed from controllers (`Setting::first()`) into each view — no `View::composer`. | |
| Controllers | Flat `App\Http\Controllers` namespace. Public pages get their own controllers (`CategoryController`, `OrderController`). All admin actions stay in the existing single `AdminController`. |
| Design source | Behavior from `digital-printing-website`; look & feel strictly from Batik-Comp `style.css` tokens + Bootstrap classes. |

> These are binding. Changes require an explicit user decision.

---

## 4. Current State (Inventory)

- **App:** `app/Http/Controllers/{AdminController,HomeController,ProductController,Controller}.php`; models `Product`, `User`.
- **Views (standalone HTML, Indonesian):** `home/index` (static profile: hero, about, visi/misi, founder, static contact form), `product/index` (card grid, dead "Buy Now" button), `admin/{index (login), dashboard (empty welcome), product (CRUD + modals), user (CRUD + modals)}`.
- **Routes:** `routes/web.php` — public home/products; `/admin` login GET + `login.action` POST; `/dashboard` `/logout` `/user` `/product` + CRUD. **No auth middleware yet.**
- **DB:** `users`, `products` (name, description, price decimal(10,2), image via later migration). Seeded: admin user + 15 batik products.
- **Design system:** `public/css/style.css` with `:root` tokens (brown `#32170d` / cream `#fbf9f7`) + utility classes documented in `STYLE.md`. Bootstrap classes used inline.
- **Missing / to build:** categories, orders, settings tables/models; category + order + settings + stats features; order modal + success + track views; DataTables export; auth middleware.
- **Canonical reference:** `digital-printing-website` (orders, track stepper, settings, categories, dashboard, DataTables) — behavior only, restyled for batik.

---

## 5. Target Map

### Public surfaces
| Route / URL | Handler / view | Purpose |
|---|---|---|
| `/` | `HomeController@index` → `home/index` | Profile page; now shows categories, featured products, and settings-driven contact info |
| `/products` | `ProductController@index` → `product/index` | Catalog grid; category badge per card; "Pesan" button opens order modal |
| `/kategori/{slug}` | `CategoryController@show` → `category/show` | Category hero + price table + filtered product grid |
| `/lacak` | `OrderController@track` → `order/track` | Search by order number → status stepper |
| `/pesanan` (POST) | `OrderController@store` | Validate + save order, PRG to success |
| `/pesanan/sukses/{orderNumber}` | `OrderController@success` → `order/success` | Order number ticket + WhatsApp + track links |

### Protected / admin surfaces (all inside `auth` middleware)
| Route / URL | Handler / view | Purpose |
|---|---|---|
| `/dashboard` | `AdminController@dashboard` → `admin/dashboard` | Stat cards + recent orders table |
| `/user` + CRUD | `AdminController@user/createUser/editUser/deleteUser` → `admin/user` | Existing, + DataTables |
| `/product` + CRUD | `AdminController@product/createProduct/editProduct/deleteProduct` → `admin/product` | Existing, + category select, + DataTables |
| `/order` | `AdminController@orders` → `admin/order` | Order list with status filter + DataTables |
| `/order/{id}` | `AdminController@orderShow` → `admin/order-show` | Detail + status update + WhatsApp chat link |
| `/order/{id}` (PATCH) | `AdminController@updateOrderStatus` | Change order status |
| `/category` + CRUD | `AdminController@categories/createCategory/editCategory/deleteCategory` → `admin/category` | Category table + modals (mirror `admin/product`) |
| `/setting` + update | `AdminController@settings/updateSettings` → `admin/setting` | Single settings form |
| `/admin`, `/admin/action` | `AdminController@index/action` | Login page + login POST (public) |

### Error states
- Unauthenticated access to any admin route → Laravel `auth` redirect to `/admin` (login page).
- Order not found on `success`/`track` → `firstOrFail` (404) / friendly "not found" alert on track page.
- Validation failures → `back()->withErrors()`; displayed via existing `$errors->first()` alert pattern.

---

## 6. Target File & Route Structure

```
Batik-Comp/
├── app/
│   ├── Http/Controllers/
│   │   ├── AdminController.php      # + dashboard(stats), orders, orderShow, updateOrderStatus,
│   │   │                            #   categories/create/edit/delete, settings, updateSettings
│   │   ├── CategoryController.php   # NEW public: show(slug)
│   │   ├── OrderController.php      # NEW public: store, success, track
│   │   └── HomeController.php       # pass categories, featured, setting
│   ├── Models/
│   │   ├── Category.php             # NEW (hasMany products, auto-slug)
│   │   ├── Order.php                # NEW (belongsTo product, order_number, total, WhatsApp helpers)
│   │   ├── Setting.php              # NEW (single-row config)
│   │   └── Product.php              # + category() relation, new fillable
├── database/
│   ├── migrations/
│   │   ├── 2026_..._create_categories_table.php
│   │   ├── 2026_..._create_orders_table.php
│   │   ├── 2026_..._create_settings_table.php
│   │   └── 2026_..._add_category_flags_to_products_table.php
│   ├── factories/OrderFactory.php   # NEW
│   └── seeders/{CategorySeeder,OrderSeeder,SettingSeeder}.php
├── resources/views/
│   ├── home/index.blade.php         # + categories section, featured section, settings contact
│   ├── product/index.blade.php      # + category badge, Pesan button, #orderModal, total JS
│   ├── category/show.blade.php      # NEW
│   ├── order/{success,track}.blade.php  # NEW
│   └── admin/{dashboard,order,order-show,category,setting}.blade.php  # NEW + edit product/user
├── public/css/style.css             # add minimal tokens/classes only if needed (e.g. stepper)
└── routes/web.php                   # new routes + auth group
```

---

## 7. Data Model / Schema

### `categories`
| Column | Type | Notes |
|---|---|---|
| `id` | bigint unsigned PK | auto |
| `name` | string | |
| `slug` | string unique | auto from name on `saving` (port from digital-printing `Category`) |
| `description` | text nullable | |
| `image` | string nullable | file in `public/uploads` |
| `is_active` | boolean default true | |
| `sort_order` | integer default 0 | |
| `timestamps` | | |

### `orders`
| Column | Type | Notes |
|---|---|---|
| `id` | bigint unsigned PK | |
| `order_number` | string unique | `ORD-ymd-XXXX`, set in model `creating` hook |
| `product_id` | FK products cascade | |
| `quantity` | integer default 1 | min 1 |
| `notes` | text nullable | |
| `customer_name` | string | |
| `customer_phone` | string | |
| `total` | decimal(12,2) default 0 | `product->price × quantity` |
| `status` | string default `menunggu` | `menunggu|baru|diproses|selesai|ditolak` |
| `timestamps` | | |

### `settings` (single row)
| Column | Type | Notes |
|---|---|---|
| `id` | bigint unsigned PK | |
| `site_name` | string | |
| `tagline` | string nullable | |
| `whatsapp_number` | string | |
| `email` | string nullable | |
| `address` | string nullable | |
| `opening_hours` | string nullable | |
| `about_text` | text nullable | |
| `instagram_usn` | string nullable | |
| `facebook_usn` | string nullable | |
| `timestamps` | | |

### `products` (alter — add, keep existing rows working)
| Column | Type | Notes |
|---|---|---|
| `category_id` | FK categories, nullable | null-safe so existing 15 products still load |
| `is_featured` | boolean default false | drives homepage "Produk Pilihan" |
| `sort_order` | integer default 0 | |

### 7.1 Structured content / nested payloads
- No JSON/blob columns. Order total is computed in `Order::calculateTotal()` and stored as a decimal.
- WhatsApp message is generated by `Order::whatsappMessage()` (batik-flavored template) and URL-encoded into `wa.me/<setting.whatsapp_number>?text=…`.
- Order statuses are a single source constant `Order::STATUSES` reused by filters, badges, and the track stepper.

---

## 8. Design Conventions & Reuse

- **No master layout.** Every view is a standalone HTML document duplicating `<head>` (Bootstrap 5.3.3 CDN, Font Awesome 6, Google Fonts, `<link rel="stylesheet" href="{{ asset('css/style.css') }}">`) plus its own navbar/footer. Keep this convention; do not introduce `@extends` layouts.
- **Canonical markup/classes to reuse:** `btn-primary-custom`, `product-card`, `icon-box`, `bg-surface-low` / `bg-surface-lowest`, `border-outline-variant`, `ambient-shadow`, `text-primary-custom`, `text-muted-custom`, `font-headline` / `font-heading`, `headline-md` / `headline-sm` / `display-lg` / `label-caps`, `nav-link-custom`, `header-custom` / `navbar-custom`, `footer-link`.
- **Admin CRUD pattern:** replicate `admin/product.blade.php` structure (header bar + table + Bootstrap modals for add/edit, `@method('PUT')`/`DELETE`, inline `style="background-color: var(--primary-color);"` buttons, `border-color: var(--border-color);"` inputs, `font-heading` table heads).
- **Flash/notification:** `redirect()->route(...)->with('success', '…')` / `with('error', '…')`, rendered as dismissible Bootstrap alerts (existing pattern in `admin/product.blade.php`); validation errors via `$errors->first()` alert.
- **Nav/active state:** minimal; admin header uses `nav-link-custom` links with FA icons. No active-class logic needed beyond the current behavior.
- **Naming:** all routes named (`product.index`, `user.create`, `category.show`, `order.track`, …); controllers flat in `App\Http\Controllers`; `AdminController` owns every admin action; Indonesian route/UI labels.
- **Images:** saved to `public/uploads` with `product_{time}_{rand}.ext` naming; reuse the existing private `storeUploadedImage()` / `deleteProductImage()` helpers in `AdminController` (extend for category/settings images).
- **New CSS:** only if a feature genuinely needs it (e.g. track stepper). Add tokens/classes in `public/css/style.css` under the same file structure, updating `STYLE.md` if rules change.

---

## 9. Phases

> One phase per session. Do not start a phase whose Entry check is unmet. Run every `Verify` before marking done.

### Phase 0 — Environment / Recon

**Goal:** Confirm the app boots, the Sail DB is reachable, and the tracker/worktree baseline matches reality.

**Entry check:** None.

Steps:
- [ ] `git status` clean-ish; note working tree state in §2 session notes.
- [ ] `./vendor/bin/sail up -d` and `./vendor/bin/sail ps` (mysql, laravel.test, phpmyadmin).
- [ ] `./vendor/bin/sail artisan migrate:status` lists `users`, `cache`, `jobs`, `products` (2 migrations), `add_image_to_products_table`.

**Verify:**
- [ ] `./vendor/bin/sail artisan migrate:status` shows no pending migrations.
- [ ] `./vendor/bin/sail artisan route:list` matches §4 inventory.

**Exit criteria:** Environment green, baseline routes/migrations confirmed. Phase 0 `done`.

---

### Phase 1 — Migrations

**Goal:** Add `categories`, `orders`, `settings` tables and the `products` alter columns.

**Entry check:** Phase 0 done.

Steps:
- [x] `php artisan make:migration create_categories_table` → per §7 schema.
- [x] `php artisan make:migration create_orders_table` → per §7 schema (FK product, unique order_number).
- [x] `php artisan make:migration create_settings_table` → per §7 schema.
- [x] `php artisan make:migration add_category_flags_to_products_table` → `category_id` FK nullable, `is_featured`, `sort_order`.

**Verify:**
- [x] `./vendor/bin/sail artisan migrate` runs clean (existing products table untouched).
- [x] `./vendor/bin/sail artisan migrate:status` shows the 4 new migrations as Ran.

**Exit criteria:** All 4 migrations applied, existing data intact. Phase 1 `done`.

---

### Phase 2 — Models + factories + seeders

**Goal:** Add `Category`, `Order`, `Setting` models (simple, Batik-Comp style), update `Product`, and provide factories/seeders.

**Entry check:** Phase 1 done.

Steps:
- [x] `Category` model: `#[Fillable]` + `#[Hidden]` + `casts()` (User style), `products()` hasMany, auto-slug on `saving` (port from digital-printing `Category`).
- [x] `Order` model: same attribute style, `product()` belongsTo, `Order::STATUSES`, `creating` hook for `order_number`, `calculateTotal()`, `statusBadgeClass()`, `whatsappMessage()`, `whatsappUrl()` (reads `Setting`), `customerWhatsAppUrl()`, `scopeStatus()`/`scopeSearch()` if needed.
- [x] `Setting` model: same attribute style.
- [x] `Product` model: add `category()` relation + new fillable fields.
- [x] `OrderFactory` + `OrderSeeder` (demo orders across statuses), `CategorySeeder` (Batik Tulis / Batik Cap / Batik Printing / Kain & Pakaian, assigns existing products, marks a few featured), `SettingSeeder` (default contact row). Wire into `DatabaseSeeder`.

**Verify:**
- [x] `./vendor/bin/sail artisan db:seed --no-interaction` succeeds.
- [x] `php artisan tinker --execute 'dump(Category::count(), Order::count(), Setting::first()?->site_name);'` (via Sail) shows seeded data.

**Exit criteria:** Models + seed data work end-to-end. Phase 2 `done`.

---

### Phase 3 — Settings wiring + public data plumbing

**Goal:** Make `$setting` (single row) and category/featured data available to public views.

**Entry check:** Phase 2 done.

Steps:
- [x] `HomeController@index` and `ProductController@index` pass `$setting` (via `Setting::first()`) into their views — **no `View::composer`**.
- [x] Homepage contact section reads `$setting->address/email/whatsapp_number/opening_hours` instead of hardcoded strings; WhatsApp link from `$setting->whatsapp_number`.
- [x] `home/index` gains "Kategori" cards section + "Produk Pilihan" (is_featured) grid using existing card classes.

**Verify:**
- [x] `/` renders with settings-driven contact + categories + featured products (no Vite error; run `npm run build` if needed).
- [x] `php artisan route:list` unchanged for public routes.

**Exit criteria:** Homepage is data-driven, still batik-styled. Phase 3 `done`.

---

### Phase 4 — Public categories + order flow

**Goal:** Category page, order modal, order store/success/track.

**Entry check:** Phase 3 done.

Steps:
- [x] `CategoryController@show(slug)` → `category/show` (hero + price table + filtered grid, chip filter JS ported from digital-printing, batik-styled).
- [x] Add "Pesan" buttons + shared `#orderModal` (data-attributes, qty/total preview JS) to `product/index`; keep it functional in `home/index` if featured cards have buy buttons.
- [x] `OrderController@store` (inline validation, duplicate-guard within 5 min, PRG to success), `success(orderNumber)`, `track(request)`.
- [x] `order/success` (order number ticket, WhatsApp CTA, track link) and `order/track` (search form + Bootstrap stepper for baru→diproses→selesai, rejection/menunggu states).
- [x] Routes in §5 public block.

**Verify:**
- [x] Manual flow: order via modal → redirected to success → WhatsApp message contains order details → `/lacak` finds the order.
- [x] `php artisan route:list` shows the new public routes.

**Exit criteria:** A customer can order, get a number, and track it. Phase 4 `done`.

---

### Phase 5 — Admin: auth, dashboard, orders, categories, settings, DataTables

**Goal:** Secure admin; give admin real management surfaces + exportable tables.

**Entry check:** Phase 4 done.

Steps:
- [x] Wrap admin routes (`/dashboard`, `/user`, `/product`, `/order*`, `/category*`, `/setting`, logout) in `middleware('auth')`; confirm unauthenticated redirect to `/admin`.
- [x] `admin/dashboard`: stat cards (Produk, Kategori, Pesanan, Pesanan Hari Ini, Estimasi Pendapatan) + recent orders table (`js-datatable`).
- [x] `admin/order` (status filter chips + table) + `admin/order-show` (detail, status update form, customer WhatsApp link) + `AdminController@orders/orderShow/updateOrderStatus`.
- [x] `admin/category` CRUD (mirror `admin/product`) + `AdminController@categories/createCategory/editCategory/deleteCategory`.
- [x] `admin/setting` form + `AdminController@settings/updateSettings`.
- [x] `admin/product` / `admin/user`: add category select + `is_featured`/`is_active` fields (product only); add `js-datatable` class.
- [x] DataTables CDN stack + Indonesian locale + copy/CSV/Excel/PDF/Print buttons (port from digital-printing admin layout) on product, user, order tables.

**Verify:**
- [x] `/dashboard` unauth → redirected to `/admin`.
- [x] Order status update persists; category CRUD works; settings save and reflect on `/`.
- [x] DataTable buttons export/print without errors (columns `:not(.no-export)` respected).

**Exit criteria:** Admin surfaces complete and secured; tables exportable. Phase 5 `done`.

---

### Phase 6 — Tests + lint + migrate/seed verification

**Goal:** Lock behavior with Pest tests and full style/tooling check.

**Entry check:** Phase 5 done.

Steps:
- [x] Pest feature tests (create via `php artisan make:test --pest`): order store (validation, duplicate guard, total), track found/not-found, admin routes require auth, category page shows its products, settings update.
- [x] `vendor/bin/pint --dirty --format agent` after any PHP edits.
- [x] Full migrate fresh + seed on a clean DB and smoke-test all pages (public + admin).

**Verify:**
- [x] `php artisan test --compact` all green.
- [x] `vendor/bin/pint --dirty --format agent` clean.
- [x] `./vendor/bin/sail artisan migrate:fresh --seed` + manual smoke pass.

**Exit criteria:** All tests + lint pass; fresh install works. Phase 6 `done`.

---

## 10. Session Playbook (Resumability)

Every session, follow this loop:

1. Read §2 tracker → find `in progress` (or next `not started`) phase.
2. `git status` → confirm working tree matches last session's notes.
3. Set phase status `in progress` + `Started` date.
4. Work the unchecked `- [ ]` steps in order. Never start a phase whose Entry check is unmet.
5. Run the phase's `Verify` commands. Fix failures before moving on.
6. Update tracker (`done` / `blocked` + notes), tick completed boxes, then summarize to the user: what changed, what's next, any decisions needing their input.

> If a phase cannot finish in one session, leave it `in progress`, check off the steps that ARE complete, and note precisely which step to continue from. Do NOT start a later phase.

---

## 11. Definition of Done (Global)

- Every checklist item in the phase is ticked and every `Verify` command passes.
- Locked technical decisions (§3) respected; no unapproved tooling introduced.
- Code follows Batik-Comp conventions (standalone views, `style.css` tokens, single `AdminController`, inline validation, Indonesian UI, `public/uploads` images).
- Test/lint commands defined in the plan all pass.
- Tracker in §2 is current and honest.

---

## 12. Risks & Open Questions

| Risk / Question | Mitigation / Decision needed |
|---|---|
| Adding `category_id` nullable keeps existing 15 products working, but they show "uncategorized" until `CategorySeeder` runs | Run seeder in Phase 2; UI shows category badge only when present |
| Duplicating DataTables CDN stack into several standalone admin views is verbose | Accepted to respect the "no layout" convention; init via `table.js-datatable` class shared across views |
| Route names differ from digital-printing (`order.track` vs `orders.track`) | Keep Batik-Comp's existing snake naming (`product.index`, `user.create`); consistency wins over parity |
| Track stepper needs a bit of custom CSS | Add minimal classes to `style.css` under the existing file structure; update `STYLE.md` if rules change |

---

## 13. Beyond Scope (Backlog — do NOT build unless asked)

- [ ] Testimonials (public form + admin approval) from digital-printing — defer unless requested.
- [ ] Gallery / Facilities / Partners admin-managed sections — defer.
- [ ] Product detail page (`/produk/{id}`) — defer.
- [ ] Image uploads via `storage/` + `storage:link` — current convention is `public/uploads`; switch only if asked.
- [ ] Order print/PDF of a single order ticket (browser print only for now).

---

## 14. Handoff Checklist (final phase)

- [ ] Write a `DEPLOYMENT.md` or equivalent: env vars, build/migrate/seed commands, cache clears, web server notes.
- [ ] Confirm static/legacy assets are superseded or kept as reference — **ask the user first**.
- [ ] Final `git` state: clean, single handoff commit if the user approves.
- [ ] Update the README with run instructions.
- [ ] Verify a production-like run (debug off) shows styled error pages, not stack traces.
