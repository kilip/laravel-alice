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

namespace Tests\Kilip\Laravel\Alice\Resources\Model\Eloquent;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'eloquent_users';

    protected $primaryKey = 'id';

    protected $fillable = [
        'username',
        'fullname',
        'birthdate',
        'email',
        'favoriteNumber',
        'id_group',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class, 'id_group', 'id');
    }
}
