# Localization

Three independent layers:

## 1. Static translations

Files in `resources/lang/{locale}/{file}.php`:

```
resources/lang/
├── en/  home.php common.php errors.php routes.php auth.php products.php
├── tr/  ...
└── cs/  ...
```

Usage anywhere:

```php
trans('home.hero_title');
trans('errors.upload_too_large', ['max' => '10240']);
trans('common.save', [], 'tr');      // explicit locale
```

**Adding a language** = create `resources/lang/<code>/` with the same files, add the
code to `config/localization.php → supported` and insert a row in the `languages`
table. No code changes required.

## 2. Dynamic translations

Content entities own a `*_translations` table (`locale`, entity FK, translated
columns). `App\Services\LocalizationService` (implemented by the Languages module)
provides `getTranslations`, `upsertTranslation`, `syncTranslations`:

```php
$localization->syncTranslations('product', $productId, [
    'en' => ['name' => 'Aurora Smart Lamp', ...],
    'tr' => ['name' => 'Aurora Akıllı Lamba', ...],
]);
```

Product output merges row + translation: `Product::translate($locale)` with `en`
fallback.

## 3. Localized routing

Route paths are translated per locale through `resources/lang/{locale}/routes.php`:

```php
// en:  'products.index' => 'products'        → /en/products
// tr:  'products.index' => 'urunler'         → /tr/urunler
// cs:  'products.index' => 'produkty'        → /cs/produkty
```

Registration:

```php
$router->localized('GET', 'products.show', [ProductController::class, 'show'])
      ->where('slug', '[a-z0-9\-]+')
      ->name('products.show');
```

URL generation respects the active locale: `route('products.show', ['slug' => $slug])`.

The `LanguageSwitcher` component rewrites the current localized URL into the target
locale (same route key, same parameters), and falls back to `/lang/{code}` (session
locale + redirect) for non-localized pages.

## Locale resolution order

1. `{locale}` prefix of a matched localized route
2. `?lang=` query parameter (SetLocale middleware)
3. session locale
4. `config/localization.default`
