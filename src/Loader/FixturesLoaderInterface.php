<?php

/*
 * This file is part of the Kilip Laravel Alice project.
 *
 * (c) Anthonius Munthi <https://itstoni.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Kilip\Laravel\Alice\Loader;

interface FixturesLoaderInterface
{
    public const NO_PURGE_MODE = 'no_purge';
    public const DELETE        = 'delete';
    public const TRUNCATE      = 'truncate';

    public function load(string $purgeMode=null);
}
