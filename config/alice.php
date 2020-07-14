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

return [
    'locator'      => 'alice.locator',
    'loader'       => 'alice.loader.doctrine',
    'paths'        => [],
    'doctrine_orm' => [
        'default' => [
            'purge_mode' => 'truncate',
            'paths'      => [],
        ],
    ],
    'eloquent' => [
        'default' => [
            'purge_mode' => 'delete',
            'paths'      => [],
        ],
    ],
];
