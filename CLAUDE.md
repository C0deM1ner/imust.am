<laravel-boost-guidelines>
# Laravel Application

This repository contains a Laravel application. Complete the following setup before working on the user's request.

## Prerequisites

Verify that PHP and Composer are available:

```sh
php -v
composer -V
```

If either command is unavailable, detect the user's operating system and install the prerequisites with the appropriate command:

macOS:

```sh
/bin/bash -c "$(curl -fsSL https://php.new/install/mac/8.5)"
```

Windows PowerShell:

```powershell
Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://php.new/install/windows/8.5'))
```

Linux:

```sh
/bin/bash -c "$(curl -fsSL https://php.new/install/linux/8.5)"
```

After installation, ask the user to restart their terminal. If the agent needs the restarted shell to continue, ask the user to reopen their terminal and rerun their original prompt.

## Agent Setup

Install Laravel Boost from the application root before making application changes:

```sh
composer require laravel/boost --dev
php artisan boost:install
```

Boost replaces these bootstrap instructions with guidelines tailored to the application. After installation, read `AGENTS.md` again and continue with the user's original request using the generated guidelines.
</laravel-boost-guidelines>

# Frontend conventions (I MUST site)

These rules follow the structure of the Sep project (`~/PhpstormProjects/Sep`). Use them for every new or changed view, style or script.

## SCSS and Tailwind together

Blade holds structure and semantic class names. SCSS holds the styling, written with Tailwind `@apply` and the tokens in `tailwind.config.js`. Templates do not carry long utility strings.

```blade
{{-- ─── Hero ─── --}}
<section class="home-hero">
    <div class="container">
        <h1 class="home-hero-title">{{ __('home.title') }}</h1>
        <p class="home-hero-lead">{{ __('home.lead') }}</p>
    </div>
</section>
```

```scss
// ─── Hero ─────────────────────────────────────────────────────────────────────

.home-hero {
    @apply relative isolate flex min-h-[100dvh] flex-col justify-end overflow-hidden;

    &-title {
        @apply text-[40px] font-bold leading-[1.02] tracking-tight;

        @screen md {
            @apply text-[64px];
        }
    }

    &-lead {
        @apply mt-16 max-w-[52ch] text-p text-paper/80;
    }
}
```

- **In Blade, keep at most about 3 utility classes on an element**, and only for one-off layout or helpers: `container`, `sr-only`, `hidden lg:flex`, a single spacing tweak such as `mt-24`. Anything with typography, colors, borders, backgrounds, hover/focus states, transitions, arbitrary values (`text-[34px]`) or more than one breakpoint goes into SCSS under a named class.
- **In SCSS, prefer `@apply` with config tokens**: the px spacing scale, the colors (`ink`, `surface`, `surfaceRaised`, `line`, `paper`, `muted`, `primary`), the font sizes (`h1`…`h6`, `p`, `pm`, `ps`, `pl` and their `-mobile` variants) and the radii (`card`, `btn`, `input`…). Use plain CSS for what Tailwind does poorly: `clamp()`, `vw` sizes, gradients, keyframes, custom easing, `background-clip: text`.
- **Breakpoints in SCSS** go in `@screen xs|sm|md|lg|xl|2xl { ... }` blocks inside the selector, mobile first. Don't use raw `@media (min-width)` for breakpoints the config already defines.
- **No raw hex colors** when a token exists. When a new color, size or radius is needed more than once, add it to `tailwind.config.js` first.
- Tailwind 3 runs after Sass, so `@apply`, `@screen` and `theme()` work in every partial. Shared Sass mixins and variables live in `abstracts/` and are pulled in with `@use 'abstracts/mixins' as *;` at the top of each partial that needs them.

## SCSS file structure

`resources/scss/app.scss` only imports, in this order:

```
resources/scss/
├── app.scss               // @use list only
├── tailwind.css           // @tailwind base; components; utilities;
├── abstracts/_mixins.scss // glass() and other shared mixins (no output)
├── base/                  // _globals, _typo, _keyframes, _no_scroll, _reveal
├── components/            // _buttons, _glass, _header, _mobile-menu, _language-switcher, _footer,
│                          // _cta-band, _forms, _cinema-media, _page-hero, _page-intro, _section, _photo-card,
│                          // _package-card, _wordmarks, _gallery
└── pages/                 // _home, _about, _services, _portfolio, _expansion, _contact, _blog
```

- One block per partial. A shared partial (`partials/header.blade.php`, `partials/package-cards.blade.php`) gets a matching `components/_*.scss`. Page-only sections go in `pages/_<page>.scss`.
- Separate sections inside a file with `// ─── Name ───…` comment dividers, and mark the matching Blade sections with `{{-- ─── Name ─── --}}`.

## Class naming

- **Blocks** are prefixed with the page or component name: `.home-hero`, `.about-founders`, `.site-header`, `.mobile-menu`, `.package-card`.
- **Elements** extend the block with a hyphen and are nested with `&-` in SCSS: `.home-hero-title`, `.package-card-price`. Don't go deeper than block-element. Start a new block instead of `.a-b-c-d`.
- **Variants** are a second class: `.btn.btn-primary`, `.page-hero.page-hero-split`, `.section-heading.section-heading-xl`.
- **States** use `is-*`, toggled by JS: `is-open`, `is-visible`, `is-active`, `is-scrolled`, `is-disabled`.
- **JS hooks** are `data-*` attributes (`data-menu-open`, `data-gallery`). Scripts don't select by styling classes, and styles don't target `data-*` (except the existing `[data-reveal]` / `[data-fade]` animation system).

## Typography and shared pieces

- Reuse the shared classes before writing new ones: `.eyebrow`, `.hero-title`, `.hero-lead` (`.hero-lead-narrow`), `.section-heading` (`.section-heading-xl`), `.section-head`, `.page-hero` (`.page-hero-split`, `.page-hero-top`), `@include('partials.page-intro')` for a title without a hero photo, `.photo-card` (`-img`, `-shade`) with `.arrow-badge`, `.btn` (`.btn-primary`, `.btn-glass`, `.btn-light`, `.btn-dark`, `.btn-lg`), `.icon-link`, `.glass-pill`, `.form-group`, `.field`, `.choice`. Page variations override them from the page partial (`.home-team-card .photo-card-shade { ... }`).
- Repeated UI is a Blade partial or anonymous component (`resources/views/components/*.blade.php` with `@props`) plus one SCSS block, for example `<x-cinema-media :src="..." variant="page" />` for every full-bleed hero photo. Don't copy-paste markup between pages.
- Page content (headings, text, lists, images, SEO) lives in the Nova pages (see below) and is read with `page('home-page')`. UI labels (buttons, form labels, aria labels) live in `lang/{hy,ru,en}/*.php`. Blog posts, portfolio projects and their services are Nova resources (below). Never hardcode copy in Blade. Every text change goes into all three languages. Never use em-dashes in copy.

## Gotchas

- **Wrap component and page styles in `@layer components { }`.** Tailwind then outputs them before the utilities, so the few utilities left in Blade (`hidden`, `mt-24`, `w-fit`) still win. Animation and `@media (prefers-*)` blocks can stay outside.
- **Class names must appear literally** in a Blade or JS file, or Tailwind drops the rule from `@layer components`. Don't build names like `"cinema-media-{{ $variant }}"`; map to full names in a PHP array instead.
- **The spacing scale is px only, 1 to 200** (`p-24` is 24px). There is no `gap-px`, `-bottom-240` or other value outside that range; use an arbitrary value (`-bottom-[240px]`) or plain CSS. `@apply` fails the build on an unknown class, which is how this shows up.
- **Plain CSS after `@apply` wins over the `md:`/`lg:` variants in the same rule.** For a responsive value, keep every size inside the `@apply` (`text-[clamp(24px,8vw,32px)] md:text-[44px]`).
- **No double quotes inside a component attribute** (`src="...{{ config("x") }}..."` breaks the tag). Compute the value in `@php` and pass it with `:src="$coverUrl"`.

## JavaScript

- `resources/js/app.js` only imports and calls init functions. Each feature is a module in `resources/js/components/<name>.js` (`mobileMenu.js`, `header.js`, `reveal.js`, `gallery.js`, `copyLink.js`, `languageMenu.js`, `contactForm.js`, `portfolioFilter.js`, plus the `disableScroll.js` helper) or `resources/js/pages/<page>.js`, exporting a default function that returns early when its `data-*` hook is missing from the page. Keep `mobileMenu()` first in `app.js`.
- Plain JS, no jQuery. Respect `prefers-reduced-motion`.

## Design rules that stay

- Dark theme only: `ink` page background, `paper` text, `primary` accent.
- Shapes: nav controls are pills; cards 24 to 28px corners; buttons, inputs and boxes inside cards 14px.
- Decorative wordmarks get `pointer-events: none`.

## Comments

- Don't write comments that repeat what the code already says: no docblocks like "Get the fields displayed by the resource." or "Run the migrations.", no `// Hero` above `<section class="home-hero">`, no `@param`/`@return` that only restate the signature.
- Write a comment only for what the code can't say: a non-obvious reason, a constraint, a workaround, a gotcha. One line where possible.
- The `// ─── Section ───` dividers in SCSS and `{{-- ─── Section ─── --}}` markers in Blade stay; they structure long files.
- When editing a file, remove useless comments in the code you touch. TODOs for real missing content stay.

## Localization and Nova (same setup as Sep)

- **URLs** come from `niels-numbers/laravel-localizer` (`config/localizer.php`). Pages are registered inside `Route::localize()` in `routes/web.php`: Armenian (the default, `app.fallback_locale`) has no prefix (`/about`), the others do (`/ru/about`, `/en/about`), and `/hy/...` redirects. Use `route('about')` as usual (never pass a locale), `Route::localizedSwitcherUrl($code)` for the language switcher, `Route::localizedUrl($code)` for hreflang, and `Route::currentBaseName()` (not `routeIs()`) for active links: the real route names are `with_locale.*` / `without_locale.*`.
- **Admin** is Laravel Nova at `/nova` (`app/Providers/NovaServiceProvider.php`), for users with `is_admin`. Tools: Settings (`app/Nova/Settings/Settings.php`, read on the site with `setting('key', $fallback)`), Translations (edits the `lang/` strings; overrides are saved in `lang-custom/`), File Manager (image uploads become WebP), and Nova Page (register page templates in `NovaServiceProvider::register()`).
- **Controllers load the data, views only render it.** Routes point to `PageController` (static pages), `BlogController` and `PortfolioController`; they call `page()`, `setting()` and the models and pass the results to the view (`$content` for the page's Nova content, which the layout also reads for SEO). Views don't query models or call `page()`. Data a shared partial needs on every page comes from a view composer (`App\View\Composers\FooterComposer`, registered in `AppServiceProvider`).
- **Pages** are Nova Page templates in `app/Nova/Templates`, registered in `NovaServiceProvider::PAGES` (name => menu label, template) and stored in `static_pages`. The controller loads it with `page('about-page')` (cached `PageLoader`, translated to the current locale) and the view reads `$content->hero_title`; Flexible lists are arrays of `['attributes' => [...]]`, images go through `img()`, "one per line" textareas through `lines()`. Add a field to the template, then to `PageSeeder` and the view.
- **Blog posts, projects and services (tags)** are models (`App\Models\Post`, `Project`, `Tag`) with Nova resources of the same name. Text fields are translatable (`spatie/laravel-translatable`), the URL slug is one per record, generated from the English title by `spatie/laravel-sluggable` and kept on rename; routes bind by it (`/blog/{post:slug}`). `is_active` hides a record on the site (`IsActiveTrait`), projects and tags are ordered by drag and drop in Nova (`order`, `SortByOrderTrait`), posts by `published_at` (`Post::newestFirst()`).
- Seeders: `PageSeeder`, `PortfolioSeeder`, `BlogSeeder` (all called from `DatabaseSeeder`) hold the launch content and copy photos from `database/seeders/images` to the public disk. They only create missing rows, so they never overwrite edits made in Nova.
- **Contact form** posts to `ContactRequestController@store` (`StoreContactRequest` validates; a hidden `website` honeypot field rejects bots; `throttle:5,1`). `contactForm.js` sends it with fetch and shows server errors per field; without JS the form posts normally and the page re-renders with errors or the sent message. Each request is a `ContactRequest` in the Nova Inbox (read-only), and `ContactRequestObserver` notifies admins in the Nova bell.
- **Meta tags**: every view calls `<x-meta :page="$content" />` (`resources/views/components/meta.blade.php`) right after `@extends`. It fills the layout's `meta` section with the title, description, keywords, canonical, Open Graph, Twitter and hreflang tags. The SEO tab in Nova (`meta_title`, `meta_description`, `meta_image`, "Index Page") wins over the fallbacks the view passes (`:title`, `:description`, `:image`, `type="article"`, `:published`); with no image anywhere it uses `public/img/share.jpg`. " | I MUST" is added to titles that don't already name the brand.
- **Structured data** (`spatie/schema-org`): `<x-meta>` prints one JSON-LD `@graph` from `App\Support\StructuredData`: the agency (`ProfessionalService`, contact details and real social links from Nova settings) and the `WebSite` on every page, plus the nodes a controller passes as `schema` (`blogPosting()`, `project()`, `breadcrumbs([label => url])`). Posts and projects refer to the agency by `@id` instead of repeating it.
- **Sitemap** (`spatie/laravel-sitemap`): `php artisan sitemap:generate` writes `public/sitemap.xml` (git-ignored) with every page, active post and project in all three languages, linked by hreflang, skipping anything with "Index Page" off. `RegeneratesSitemap` on `Post`, `Project` and `StaticPage` reruns it on every save or delete, so a new public page needs its route added to `GenerateSitemap::PAGES`. URLs come from `APP_URL`, so production must set it to `https://imust.am`.
- On a new install: `php artisan migrate`, `php artisan storage:link`, `php artisan db:seed`, `php artisan sitemap:generate`.
- Translatable settings and Nova Page fields store JSON per locale; `translator()` in `app/Support/helpers.php` picks the current language.

## Checking a change

Run `npx vite build` and `php artisan view:clear`. Check the page at 320, 390, 768, 1024 and 1280px in hy, ru and en, with no horizontal scroll and no console errors.
