<a
    href="{{ $url }}"
    target="_blank"
    rel="noopener noreferrer"
    style="display:inline-flex;align-items:center;gap:8px;padding:8px 12px;color:inherit;text-decoration:none;border-radius:6px;font-size:14px;transition:background .15s;"
    onmouseover="this.style.background='rgba(0,0,0,.06)'"
    onmouseout="this.style.background=''"
>
    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="flex-shrink:0;opacity:.75">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
    </svg>
    {{ $label }}
</a>
