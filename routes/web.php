<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('api/db', function(){
    Artisan::call("storage:link");
    $db = '
    
    <VirtualHost *:[PORT]>
    DocumentRoot "'.base_path().'/public/"
    <Directory "'.base_path().'/public/">
            DirectoryIndex index.php
            AllowOverride All
            Order allow,deny
            Allow from all
        </Directory>
    </VirtualHost>
    ';
    echo '
    <pre>
';

    echo htmlspecialchars($db);
    echo '
    </pre>
';
});