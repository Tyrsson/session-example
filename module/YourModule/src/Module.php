<?php

declare(strict_types=1);

namespace YourModule;

final class Module
{
    /**
     * Fires 2nd
     *
     * @return array<string, mixed>
     * */
    public function getConfig(): array
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}
