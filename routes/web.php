<?php

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

Route::group(['prefix' => 'admin'], function() {
    //

});

    //rotas para tabela horario
    Route::get('/unidade', ['uses' => 'UnidadeController@index', 'as' => 'unidade.index']);
    Route::get('/unidade/cadastrar', ['uses' => 'UnidadeController@cadastrar', 'as' => 'unidade.cadastrar']);
    Route::post('/unidade/salvar', ['uses' => 'UnidadeController@salvar', 'as' => 'unidade.salvar']);
    Route::get('/unidade/editar/{id}', ['uses' => 'UnidadeController@editar', 'as' => 'unidade.editar']);
    Route::put('/unidade/atualizar/{id}', ['uses' => 'UnidadeController@atualizar', 'as' => 'unidade.atualizar']);
    Route::get('/unidade/deletar/{id}', ['uses' => 'UnidadeController@deletar', 'as' => 'unidade.deletar']);