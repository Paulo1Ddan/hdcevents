<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventController extends Controller
{
    //Rota Index
    public function index(){

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
    }

    // Rota Create
    public function create(){
        return view("events.create");
    }
}
