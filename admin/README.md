# Admin Panel

The admin panel is a protected route group (`/admin`) rendered on top of the shared
design system. Module screens live inside each module's `Views/Admin` directory and
are wired in `modules/*/Routes/routes.php` with `permission:*` middleware.

| Area | Route | Permission |
| --- | --- | --- |
| Dashboard | `/admin` | any authenticated user |
| Products | `/admin/products` | `products.view`, `products.manage` |
| Users | `/admin/users` | `users.manage` |
| Roles | `/admin/roles` | `permissions.manage` |
| Languages | `/admin/languages` | `languages.manage` |
| Media | `/admin/media` | `media.view`, `media.manage` |
| Settings | `/admin/settings` | `settings.manage` |
| SEO | `/admin/seo` | `seo.manage` |

Assets for the panel live in `admin/assets/` and are served directly by Apache.
