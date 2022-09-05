<?php

declare(strict_types=1);

namespace YourModule\Session;

use YourModule\Session\Container;

trait SessionContainerAwareTrait
{
    /** @var Container $sessionContainer */
    protected $session;

    public function setSessionContainer(Container $container)
    {
        $this->session = $container;
    }

    public function getSessionContainer(): Container
    {
        return $this->session;
    }
}
