<?php

namespace Krafftd\Chat\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class NavItem extends Component
{
    public string $url;
    public string $label;

    public function __construct(
        ?string $url   = null,
        ?string $label = null,
    ) {
        $serverUrl = rtrim(config('krafftd-chat.server_url', ''), '/');

        $this->url   = $url   ?? ($serverUrl ? $serverUrl . '/admin' : '#');
        $this->label = $label ?? 'Krafftd Chat';
    }

    public function render(): View
    {
        return view('krafftd-chat::components.nav-item');
    }
}
