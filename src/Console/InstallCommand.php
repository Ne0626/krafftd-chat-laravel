<?php

namespace Krafftd\Chat\Console;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature   = 'krafftd:chat:install';
    protected $description = 'Install the Krafftd Chat widget into this Laravel application.';

    public function handle(): int
    {
        $this->newLine();
        $this->line('  <fg=blue;options=bold>Krafftd Chat — Install Wizard</>');
        $this->line('  ─────────────────────────────────');
        $this->newLine();

        // 1. Publish config
        $this->call('vendor:publish', ['--tag' => 'krafftd-chat-config']);
        $this->line('  <fg=green>✓</> Config published → <comment>config/krafftd-chat.php</comment>');
        $this->newLine();

        // 2. Prompt for layout file
        $layout = $this->ask(
            'Which layout file should receive the nav item? (relative to resources/views)',
            'layouts/app.blade.php'
        );

        $layoutPath = resource_path('views/' . ltrim($layout, '/'));

        if (! file_exists($layoutPath)) {
            $this->newLine();
            $this->warn("  Layout not found: {$layoutPath}");
            $this->line('  Add <fg=yellow><x-krafftd-chat::nav-item /></> manually where needed.');
        } else {
            $this->injectNavItem($layoutPath, $layout);
        }

        // 3. Remind about .env keys
        $this->newLine();
        $this->line('  <fg=green;options=bold>Done!</> Add these to your <comment>.env</comment>:');
        $this->newLine();
        $this->line('  <fg=yellow>KRAFFTD_CHAT_SERVER_URL</>  = https://chat.yourdomain.com');
        $this->line('  <fg=yellow>KRAFFTD_CHAT_CLIENT_SLUG</> = your-client-slug');
        $this->line('  <fg=yellow>KRAFFTD_CHAT_WIDGET_TOKEN</> = your-widget-token');
        $this->newLine();
        $this->line('  The widget <script> tag is injected automatically on all web responses.');
        $this->newLine();

        return self::SUCCESS;
    }

    private function injectNavItem(string $layoutPath, string $label): void
    {
        $contents  = file_get_contents($layoutPath);
        $component = '<x-krafftd-chat::nav-item />';

        if (str_contains($contents, $component)) {
            $this->line("  <fg=yellow>→</> Nav item already present in <comment>{$label}</comment> — skipped.");
            return;
        }

        // Try common closing tags to find a good injection point
        $targets = ['</nav>', '</ul>', '</aside>'];

        foreach ($targets as $needle) {
            if (str_contains($contents, $needle)) {
                $contents = str_replace(
                    $needle,
                    "        {$component}\n{$needle}",
                    $contents
                );
                file_put_contents($layoutPath, $contents);
                $this->line("  <fg=green>✓</> Nav item injected before <comment>{$needle}</comment> in <comment>{$label}</comment>");
                return;
            }
        }

        $this->warn("  Could not find </nav>, </ul>, or </aside> in {$label}.");
        $this->line('  Add <fg=yellow><x-krafftd-chat::nav-item /></> manually where needed.');
    }
}
