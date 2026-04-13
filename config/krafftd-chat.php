<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Krafftd Chat Server URL
    |--------------------------------------------------------------------------
    | The base URL of the Krafftd Chat server. Used in the injected widget
    | script tag (data-server attribute) and in the admin nav item link.
    |
    | Example: https://chat.yourdomain.com
    */
    'server_url' => env('KRAFFTD_CHAT_SERVER_URL', ''),

    /*
    |--------------------------------------------------------------------------
    | Client Slug
    |--------------------------------------------------------------------------
    | Your unique client identifier on the Krafftd Chat server.
    | Found in your Krafftd Chat admin under Settings → Widget Code.
    */
    'client_slug' => env('KRAFFTD_CHAT_CLIENT_SLUG', ''),

    /*
    |--------------------------------------------------------------------------
    | Widget Token
    |--------------------------------------------------------------------------
    | The widget authentication token issued by the Krafftd Chat server.
    | Found in your Krafftd Chat admin under Settings → Widget Code.
    */
    'widget_token' => env('KRAFFTD_CHAT_WIDGET_TOKEN', ''),

    /*
    |--------------------------------------------------------------------------
    | Auto-inject Middleware
    |--------------------------------------------------------------------------
    | When true, the InjectChatWidget middleware is automatically pushed onto
    | the "web" middleware group so the <script> tag is inserted on every
    | full HTML response. Set to false to apply the middleware manually on
    | specific routes or middleware groups instead.
    */
    'inject_middleware' => env('KRAFFTD_CHAT_INJECT', true),

];
