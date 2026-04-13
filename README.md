# Krafftd Chat — Laravel Package

Embed the **Krafftd Chat** widget into any existing Laravel application in minutes.

Once installed, the chat bubble is automatically injected on every page of your site — no manual template changes required.

---

## Requirements

- PHP 8.1 or higher
- Laravel 10, 11, or 12

---

## Installation

### Step 1 — Install via Composer

```bash
composer require krafftd/chat
```

### Step 2 — Run the install wizard

```bash
php artisan krafftd:chat:install
```

The wizard will:
- Publish the config file to `config/krafftd-chat.php`
- Ask which layout file to inject the sidebar nav item into (optional)

### Step 3 — Add your credentials to `.env`

```env
KRAFFTD_CHAT_SERVER_URL=https://chat.yourdomain.com
KRAFFTD_CHAT_CLIENT_SLUG=your-client-slug
KRAFFTD_CHAT_WIDGET_TOKEN=your-widget-token
```

You can find your **Client Slug** and **Widget Token** in your Krafftd Chat admin panel under **Settings → Widget Code** or on the **Clients** page if provided by your administrator.

That's it. The chat widget will now appear on every page of your Laravel application.

---

## Configuration

The published config file at `config/krafftd-chat.php` contains the following options:

```php
return [

    // Base URL of the Krafftd Chat server
    'server_url' => env('KRAFFTD_CHAT_SERVER_URL', ''),

    // Your unique client identifier
    'client_slug' => env('KRAFFTD_CHAT_CLIENT_SLUG', ''),

    // Widget authentication token
    'widget_token' => env('KRAFFTD_CHAT_WIDGET_TOKEN', ''),

    // Set to false to disable auto-injection and apply the middleware manually
    'inject_middleware' => env('KRAFFTD_CHAT_INJECT', true),

];
```

---

## Sidebar Nav Item (Optional)

The package includes a Blade component that renders a link back to your Krafftd Chat admin panel. This is useful if you want your team to access the chat dashboard directly from your app's sidebar.

```blade
<x-krafftd-chat::nav-item />
```

You can also customize the label:

```blade
<x-krafftd-chat::nav-item label="Chat Support" />
```

The install wizard can inject this automatically — just provide your layout file path when prompted.

---

## Manual Middleware (Advanced)

By default, the widget script is injected automatically on all `web` responses. If you prefer to control which routes get the widget, disable auto-injection in your `.env`:

```env
KRAFFTD_CHAT_INJECT=false
```

Then apply the middleware manually to specific routes or groups in `routes/web.php`:

```php
Route::middleware('krafftd.chat.inject')->group(function () {
    Route::get('/', HomeController::class);
});
```

---

## Publishing Views (Optional)

To customize the widget script partial or the nav item template, publish the package views:

```bash
php artisan vendor:publish --tag=krafftd-chat-views
```

Views will be copied to `resources/views/vendor/krafftd-chat/`.

---

## How It Works

| Feature | Details |
|---|---|
| **Widget injection** | Middleware appends a `<script>` tag before `</body>` on every 200 HTML response |
| **No routes added** | All widget traffic goes directly to the Krafftd Chat server |
| **No database changes** | No migrations, no models |
| **Zero JS to write** | The widget script handles everything on the client side |

---

## Troubleshooting

**Widget is not appearing**

- Make sure all three `.env` values are set and not empty
- Run `php artisan config:clear` after updating `.env`
- Check that the response content type is `text/html` (the middleware skips JSON and redirects)

**Nav item link goes to `#`**

- Ensure `KRAFFTD_CHAT_SERVER_URL` is set in your `.env`

**Auto-injection is not working on some pages**

- The middleware only injects on HTTP 200 responses containing `</body>`
- API routes and redirects are skipped automatically

---

## License

MIT
