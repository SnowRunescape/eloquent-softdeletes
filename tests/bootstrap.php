<?php

use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Events\Dispatcher;

$db = new DB();
$db->addConnection([
    'driver' => 'sqlite',
    'database' => ':memory:',
]);
$db->setAsGlobal();
$db->setEventDispatcher(new Dispatcher());
$db->bootEloquent();

DB::schema()->dropIfExists('posts');

DB::schema()->create('posts', function ($table) {
    $table->increments('id');
    $table->string('title');
    $table->timestamps();
    $table->integer('status')->default(1);
});
