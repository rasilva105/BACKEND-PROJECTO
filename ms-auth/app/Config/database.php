<?php

use Illuminate\Database\Capsule\Manager as Capsule;

// Configuración de Eloquent

$capsule = new Capsule();

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'port'      => 3306,
    'database'  => 'bd_auth',
    'username'  => 'root',
    'password'  => '',
    'charset'   => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix'    => ''
]);


//Hace disponible la conexión globalmente

$capsule->setAsGlobal();


// Inicializa Eloquent ORM

$capsule->bootEloquent();