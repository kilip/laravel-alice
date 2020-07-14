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

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEloquentUsersTable extends Migration
{
    public const TABLE_NAME = 'eloquent_users';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(static::TABLE_NAME, function (Blueprint $table) {
            $table->integer('id');
            $table->string('username');
            $table->string('fullname');
            $table->date('birthdate');
            $table->string('email');
            $table->integer('favoriteNumber')->nullable(true);
            $table->integer('id_group');
            $table->timestamps();
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop(static::TABLE_NAME);
    }
}
