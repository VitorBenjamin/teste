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
    $teste = 'active';
    return view('welcome',compact('teste'));
});

Route::get('/ajax/clientes', ['uses' => 'ClienteController@getCliente', 'as' => 'cliente.getCliente']);
Route::get('/ajax/solicitantes', ['uses' => 'SolicitanteController@getSolicitante', 'as' => 'solicitante.getSolicitante']);



Route::group(['prefix' => 'solicitacao'],function(){


	Route::get('/compra', ['uses' => 'CompraController@index', 'as' => 'compra.index']);
    Route::get('/compra/cadastrar', ['uses' => 'CompraController@cadastrar', 'as' => 'compra.cadastrar']);
    Route::post('/compra/salvar', ['uses' => 'CompraController@salvar', 'as' => 'compra.salvar']);
    Route::put('/compra/atualizar/{id}', ['uses' => 'CompraController@atualizar', 'as' => 'compra.atualizar']);
    Route::put('/compra/add-compra/{id}', ['uses' => 'CompraController@addCompra', 'as' => 'compra.addCompra']);
    Route::get('/compra/deletar-compra/{id}', ['uses' => 'CompraController@deletarCompra', 'as' => 'compra.deletarCompra']);
    Route::get('/compra/editar-compra/{id}', ['uses' => 'CompraController@editar', 'as' => 'compra.editar']);
    Route::put('/compra/atualizar-compra/{id}', ['uses' => 'CompraController@atualizarCompra', 'as' => 'compra.atualizarCompra']);

    // Rotas para controle de Reembolso
    Route::get('/reembolso', ['uses' => 'ReembolsoController@index', 'as' => 'reembolso.index']);
    Route::get('/reembolso/cadastrar', ['uses' => 'ReembolsoController@cadastrar', 'as' => 'reembolso.cadastrar']);
    Route::post('/reembolso/salvar', ['uses' => 'ReembolsoController@salvar', 'as' => 'reembolso.salvar']);
    Route::get('/reembolso/editar-reembolso/{id}', ['uses' => 'ReembolsoController@editar', 'as' => 'reembolso.editar']);
    Route::put('/reembolso/atualizar/{id}', ['uses' => 'ReembolsoController@atualizar', 'as' => 'reembolso.atualizar']);
    Route::put('/reembolso/atualizar-despesa/{id}', ['uses' => 'ReembolsoController@atualizarDespesa', 'as' => 'reembolso.atualizarDespesa']);
    Route::put('/reembolso/atualizar-translado/{id}', ['uses' => 'ReembolsoController@atualizarTranslado', 'as' => 'reembolso.atualizarTranslado']);
    Route::get('/reembolso/deletar/{id}', ['uses' => 'ReembolsoController@deletar', 'as' => 'reembolso.deletar']);
    Route::get('/reembolso/deletar-translado/{id}', ['uses' => 'ReembolsoController@deletarTranslado', 'as' => 'reembolso.deletarTranslado']); 
    Route::get('/reembolso/editar-translado/{id}', ['uses' => 'ReembolsoController@editarTranslado', 'as' => 'reembolso.editarTranslado']);        
    Route::get('/reembolso/deletar-despesa/{id}', ['uses' => 'ReembolsoController@deletarDespesa', 'as' => 'reembolso.deletarDespesa']);
    Route::get('/reembolso/editar-despesa/{id}', ['uses' => 'ReembolsoController@editarDespesa', 'as' => 'reembolso.editarDespesa']);
    Route::put('/reembolso/add-translado/{id}', ['uses' => 'ReembolsoController@addTranslado', 'as' => 'reembolso.addTranslado']);
    Route::put('/reembolso/add-despesa/{id}', ['uses' => 'ReembolsoController@addDespesa', 'as' => 'reembolso.addDespesa']);

    //Rotas para controle de Viagem
    Route::get('viagem', ['uses' => 'ViagemController@index', 'as' => 'viagem.index']);
    Route::get('/viagem/cadastrar', ['uses' => 'ViagemController@cadastrar', 'as' => 'viagem.cadastrar']);
    Route::post('/viagem/salvar', ['uses' => 'ViagemController@salvar', 'as' => 'viagem.salvar']);
    Route::put('/viagem/add-viagem/{id}', ['uses' => 'ViagemController@addViagem', 'as' => 'viagem.addViagem']);
    Route::get('/viagem/editar-viagem/{id}', ['uses' => 'ViagemController@editar', 'as' => 'viagem.editar']);
    Route::put('/viagem/atualizar/{id}', ['uses' => 'ViagemController@atualizar', 'as' => 'viagem.atualizar']);
    
    
});

Route::group(['prefix' => 'admin'], function() {

    // Rotas para Tabela Unidade
    // Route::get('/unidade', ['uses' => 'UnidadeController@index', 'as' => 'unidade.index']);
    // Route::get('/unidade/cadastrar', ['uses' => 'UnidadeController@cadastrar', 'as' => 'unidade.cadastrar']);
    // Route::post('/unidade/salvar', ['uses' => 'UnidadeController@salvar', 'as' => 'unidade.salvar']);
    // Route::get('/unidade/editar/{id}', ['uses' => 'UnidadeController@editar', 'as' => 'unidade.editar']);
    // Route::put('/unidade/atualizar/{id}', ['uses' => 'UnidadeController@atualizar', 'as' => 'unidade.atualizar']);
    // Route::get('/unidade/deletar/{id}', ['uses' => 'UnidadeController@deletar', 'as' => 'unidade.deletar']);

    // Rotas para Tabela Clientes
    Route::get('/cliente', ['uses' => 'ClienteController@index', 'as' => 'cliente.index']);
    Route::get('/cliente/cadastrar', ['uses' => 'ClienteController@cadastrar', 'as' => 'cliente.cadastrar']);
    Route::post('/cliente/salvar', ['uses' => 'ClienteController@salvar', 'as' => 'cliente.salvar']);
    Route::get('/cliente/editar/{id}', ['uses' => 'ClienteController@editar', 'as' => 'cliente.editar']);
    Route::put('/cliente/atualizar/{id}', ['uses' => 'ClienteController@atualizar', 'as' => 'cliente.atualizar']);
    Route::get('/cliente/deletar/{id}', ['uses' => 'ClienteController@deletar', 'as' => 'cliente.deletar']);

    // Rotas para Tabela Status
    Route::get('/status', ['uses' => 'StatusController@index', 'as' => 'status.index']);
    Route::get('/status/cadastrar', ['uses' => 'StatusController@cadastrar', 'as' => 'status.cadastrar']);
    Route::post('/status/salvar', ['uses' => 'StatusController@salvar', 'as' => 'status.salvar']);
    Route::get('/status/editar/{id}', ['uses' => 'StatusController@editar', 'as' => 'status.editar']);
    Route::put('/status/atualizar/{id}', ['uses' => 'StatusController@atualizar', 'as' => 'status.atualizar']);
    Route::get('/status/deletar/{id}', ['uses' => 'StatusController@deletar', 'as' => 'status.deletar']);

    // Rotas para Tabela User
    Route::get('/user', ['uses' => 'UserController@index', 'as' => 'user.index']);
    Route::get('/user/cadastrar', ['uses' => 'UserController@cadastrar', 'as' => 'user.cadastrar']);
    Route::post('/user/salvar', ['uses' => 'UserController@salvar', 'as' => 'user.salvar']);
    Route::get('/user/editar/{id}', ['uses' => 'UserController@editar', 'as' => 'user.editar']);
    Route::put('/user/atualizar/{id}', ['uses' => 'UserController@atualizar', 'as' => 'user.atualizar']);
    Route::get('/user/deletar/{id}', ['uses' => 'UserController@deletar', 'as' => 'user.deletar']);

});




