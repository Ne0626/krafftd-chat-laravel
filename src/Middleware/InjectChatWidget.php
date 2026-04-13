<?php

namespace Krafftd\Chat\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InjectChatWidget
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Response $response */
        $response = $next($request);

        if (! $this->shouldInject($response)) {
            return $response;
        }

        $content = $response->getContent();

        if (! str_contains($content, '</body>')) {
            return $response;
        }

        $script = view('krafftd-chat::widget-script')->render();

        $response->setContent(
            str_replace('</body>', $script . '</body>', $content)
        );

        return $response;
    }

    private function shouldInject(Response $response): bool
    {
        // Skip if credentials are not configured
        if (! config('krafftd-chat.client_slug') || ! config('krafftd-chat.widget_token')) {
            return false;
        }

        // Only inject into successful HTML responses
        if ($response->getStatusCode() !== 200) {
            return false;
        }

        $contentType = $response->headers->get('Content-Type', '');

        return str_contains($contentType, 'text/html');
    }
}
