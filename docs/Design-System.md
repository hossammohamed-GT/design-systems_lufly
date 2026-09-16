# Design System

Located in `frontend/design-system/`. Pure CSS custom properties — **no hardcoded
colors in component styles**; every color resolves through semantic tokens.

## Token files

| File | Contents |
| --- | --- |
| `colors.css` | Raw palette tokens (`--color-brand-*`, `--color-neutral-*`, status hues) |
| `spacing.css` | `--space-*` scale (4px base), container + grid utilities |
| `typography.css` | Font stacks + type scale (`--text-*`), heading styles |
| `radius.css` | `--radius-xs … --radius-full` |
| `shadows.css` | Elevation tokens (`--shadow-1..3`, `--focus-ring`) |
| `animations.css` | Motion tokens + keyframes + `prefers-reduced-motion` guard |
| `themes.css` | **Semantic tokens per theme** (`--ds-bg`, `--ds-text`, `--ds-primary`, …) |
| `components.css` | All component styles, consuming semantic tokens only |

## Theming

Two themes via `data-theme` on `<html>`: `light` and `dark`. `themes.css` maps
palette tokens to semantic tokens per theme; `frontend/js/theme-switcher.js`
persists the choice in `localStorage` and honours `prefers-color-scheme`.

Adding a theme = adding one `[data-theme="..."]` block in `themes.css`.

## Components

Implemented as PHP partials in `resources/views/components/` + CSS in
`components.css` + behaviour in `frontend/js/`:

| Component | Partial | Notes |
| --- | --- | --- |
| Button | `button.php` | variants: primary/secondary/ghost/danger; sizes sm/md/lg |
| Input | `input.php` | label, validation error state, `old()` re-population |
| Card | `card.php` | header/body/footer, slot content |
| Modal | `modal.php` | `data-modal-open` / `data-modal-close`, ESC + backdrop close |
| Navbar | `navbar.php` | sticky, brand + links + switchers |
| Footer | `footer.php` | — |
| ThemeSwitcher | `theme-switcher.php` | light/dark toggle |
| LanguageSwitcher | `language-switcher.php` | locale-aware URL rewriting |
| SEO head | `seo.php` | meta/OG/canonical/JSON-LD from `SEOService` |
| Alert | `alert.php` | flash success/errors |

Usage inside any view:

```php
<?= $view->component('button', ['label' => trans('common.save'), 'variant' => 'primary']) ?>
```

## Legacy atlas

The original visual atlas shipped with this repository is preserved at
`frontend/design-system/atlas.html`.
