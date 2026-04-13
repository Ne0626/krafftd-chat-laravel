<?php

namespace Krafftd\Chat;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Krafftd\Chat\Console\InstallCommand;
use Krafftd\Chat\Middleware\InjectChatWidget;
use Krafftd\Chat\View\Components\NavItem;

class ChatServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/krafftd-chat.php',
            'krafftd-chat'
        );
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'krafftd-chat');

        Blade::component('krafftd-chat::components.nav-item', NavItem::class, 'krafftd-chat');

        /** @var Router $router */
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('krafftd.chat.inject', InjectChatWidget::class);

        if (config('krafftd-chat.inject_middleware', true)) {
            $router->pushMiddlewareToGroup('web', InjectChatWidget::class);
        }

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/krafftd-chat.php' => config_path('krafftd-chat.php'),
            ], 'krafftd-chat-config');

            $this->publishes([
                __DIR__ . '/../resources/views' => resource_path('views/vendor/krafftd-chat'),
            ], 'krafftd-chat-views');

            $this->commands([InstallCommand::class]);
        }
    }
}
