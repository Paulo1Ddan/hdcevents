<?php

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


    $arr = [1, 2, 3, 4, 5, 6];

    $arrName = ["Paulo", "Maria", "João", "Carlos", "Ronaldo"];

    $name = "Paulo";

    $pessoa = array(
        [
            "nome" => "Paulo",
            "idade" => 20
        ],
        [
            "nome" => "Ana",
            "idade" => 25
        ],
        [
            "nome" => "Robson",
            "idade" => 40
        ]
    );

    return view('welcome', [
        "name" => $name,
        "idade" => 20,
        "profissao" => "Programador",
        "arr" => $arr,
        "arrName" => $arrName,
        "pessoas" => $pessoa
    ]);
});

Route::get('/contact', function(){
    return view("contact");
});

Route::get('/products', function(){
    $busca = request("search");
    return view("products", ['busca' => $busca]);
});

Route::get('/products_test/{id?}', function($id = 1){
    return view("product", ['id' => $id]);
});


