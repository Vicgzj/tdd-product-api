<?php

declare(strict_types=1);

namespace Coolblue\Utils\Config;

interface ConfigInterface
{
    /**
     * @param string $key
     * @return bool
     */
    public function has($key);

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get($key, $default = null);
}
