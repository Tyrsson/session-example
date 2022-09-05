<?php

/**
 * Usage:
 * This Interface is mostly for controllers to implement so that a common factory, abstract factory,
 * delegator or initilaizer can then set a container instance on the object
 * Usually you will use the matched Trait to implement the interface
 */

declare(strict_types=1);

namespace YourModule\Session;

use YourModule\Session\Container;

interface SessionContainerAwareInterface
{
    public function setSessionContainer(Container $container);

    public function getSessionContainer(): Container;
}
