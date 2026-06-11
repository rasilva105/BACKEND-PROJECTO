<?php

use Illuminate\Database\Capsule\Manager as Capsule;


// Conexión a la base de datos bd_seguimiento


$capsule = new Capsule();

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'port'      => 3306,
    'database'  => 'bd_seguimiento',
    'username'  => 'root',
    'password'  => '',
    'charset'   => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix'    => ''
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();