@php
    $serverUrl   = rtrim(config('krafftd-chat.server_url', ''), '/');
    $clientSlug  = config('krafftd-chat.client_slug', '');
    $widgetToken = config('krafftd-chat.widget_token', '');
@endphp
@if($serverUrl && $clientSlug && $widgetToken)
<script
    src="{{ $serverUrl }}/widget/chat-widget.js"
    data-client="{{ $clientSlug }}"
    data-token="{{ $widgetToken }}"
    data-server="{{ $serverUrl }}"
    async
></script>
@endif
