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

// Route::get('/', function () {
//     $teste = 'active';
//     return view('welcome',compact('teste'));
// });

Route::get('/', ['uses' => 'SolicitacaoController@index', 'as' => 'solicitacao.index']);

Route::get('/ajax/clientes', ['uses' => 'ClienteController@getCliente', 'as' => 'cliente.getCliente']);
Route::get('/ajax/solicitantes', ['uses' => 'SolicitanteController@getSolicitante', 'as' => 'solicitante.getSolicitante']);


// INICIO ROTAS DE SOLICITAÇÃO
Route::group(['prefix' => 'solicitacao'],function()
{

    // INICIO ROTAS DE COMPRA
    Route::group(['prefix' => 'compra'],function()
    {

       Route::get('', ['uses' => 'CompraController@index', 'as' => 'compra.index']);
       Route::get('cadastrar', ['uses' => 'CompraController@cadastrar', 'as' => 'compra.cadastrar']);
       Route::post('salvar', ['uses' => 'CompraController@salvar', 'as' => 'compra.salvar']);
       Route::put('atualizar-cabecalho/{id}', ['uses' => 'CompraController@atualizarCabecalho', 'as' => 'compra.atualizarCabecalho']);
       Route::put('add-compra/{id}', ['uses' => 'CompraController@addCompra', 'as' => 'compra.addCompra']);
       Route::get('deletar-compra/{id}', ['uses' => 'CompraController@deletarCompra', 'as' => 'compra.deletarCompra']);
       Route::get('editar-compra/{id}', ['uses' => 'CompraController@editar', 'as' => 'compra.editar']);
       Route::put('atualizar-compra/{id}', ['uses' => 'CompraController@atualizarCompra', 'as' => 'compra.atualizarCompra']);
    });
    // FIM ROTAS DE COMPRA

    // INICIO ROTAS DE ANTECIPAÇÃO
    Route::group(['prefix' => 'antecipacao'],function()
    {
       Route::get('', ['uses' => 'AntecipacaoController@index', 'as' => 'antecipacao.index']);
       Route::get('cadastrar', ['uses' => 'AntecipacaoController@cadastrar', 'as' => 'antecipacao.cadastrar']);
       Route::post('salvar', ['uses' => 'AntecipacaoController@salvar', 'as' => 'antecipacao.salvar']);
       Route::put('atualizar-cabecalho/{id}', ['uses' => 'AntecipacaoController@atualizarCabecalho', 'as' => 'antecipacao.atualizarCabecalho']);
       Route::put('add-antecipacao/{id}', ['uses' => 'AntecipacaoController@addAntecipacao', 'as' => 'antecipacao.addAntecipacao']);
       Route::get('deletar-antecipacao/{id}', ['uses' => 'AntecipacaoController@deletarAntecipacao', 'as' => 'antecipacao.deletarAntecipacao']);
       Route::get('editar-antecipacao/{id}', ['uses' => 'AntecipacaoController@editar', 'as' => 'antecipacao.editar']);
       Route::put('atualizar-antecipacao/{id}', ['uses' => 'AntecipacaoController@atualizarAntecipacao', 'as' => 'antecipacao.atualizarAntecipacao']);
    });
    // FIM ROTAS DE ANTECIPAÇÃO

    // INICIO ROTAS DE ANTECIPAÇÃO
    Route::group(['prefix' => 'guia'],function()
    {
       Route::get('', ['uses' => 'GuiaController@index', 'as' => 'guia.index']);
       Route::get('cadastrar', ['uses' => 'GuiaController@cadastrar', 'as' => 'guia.cadastrar']);
       Route::post('salvar', ['uses' => 'GuiaController@salvar', 'as' => 'guia.salvar']);
       Route::put('atualizar-cabecalho/{id}', ['uses' => 'GuiaController@atualizarCabecalho', 'as' => 'guia.atualizarCabecalho']);
       Route::put('add-guia/{id}', ['uses' => 'GuiaController@addGuia', 'as' => 'guia.addGuia']);
       Route::get('deletar-guia/{id}', ['uses' => 'GuiaController@deletarGuia', 'as' => 'guia.deletarGuia']);
       Route::get('editar-guia/{id}', ['uses' => 'GuiaController@editar', 'as' => 'guia.editar']);
       Route::put('atualizar-guia/{id}', ['uses' => 'GuiaController@atualizarGuia', 'as' => 'guia.atualizarGuia']);
    });
    // FIM ROTAS DE ANTECIPAÇÃO    

    // INICIO ROTAS DE REEMBOLSO
    Route::group(['prefix' => 'reembolso'],function()
    {
        Route::get('', ['uses' => 'ReembolsoController@index', 'as' => 'reembolso.index']);
        Route::get('cadastrar', ['uses' => 'ReembolsoController@cadastrar', 'as' => 'reembolso.cadastrar']);
        Route::post('salvar', ['uses' => 'ReembolsoController@salvar', 'as' => 'reembolso.salvar']);
        Route::get('editar-reembolso/{id}', ['uses' => 'ReembolsoController@editar', 'as' => 'reembolso.editar']);
        Route::put('atualizar-cabecalho/{id}', ['uses' => 'ReembolsoController@atualizarCabecalho', 'as' => 'reembolso.atualizarCabecalho']);
        Route::put('atualizar-despesa/{id}', ['uses' => 'ReembolsoController@atualizarDespesa', 'as' => 'reembolso.atualizarDespesa']);
        Route::put('atualizar-translado/{id}', ['uses' => 'ReembolsoController@atualizarTranslado', 'as' => 'reembolso.atualizarTranslado']);
        Route::get('deletar/{id}', ['uses' => 'ReembolsoController@deletar', 'as' => 'reembolso.deletar']);
        Route::get('deletar-translado/{id}', ['uses' => 'ReembolsoController@deletarTranslado', 'as' => 'reembolso.deletarTranslado']); 
        Route::get('editar-translado/{id}', ['uses' => 'ReembolsoController@editarTranslado', 'as' => 'reembolso.editarTranslado']);        
        Route::get('deletar-despesa/{id}', ['uses' => 'ReembolsoController@deletarDespesa', 'as' => 'reembolso.deletarDespesa']);
        Route::get('editar-despesa/{id}', ['uses' => 'ReembolsoController@editarDespesa', 'as' => 'reembolso.editarDespesa']);
        Route::put('add-translado/{id}', ['uses' => 'ReembolsoController@addTranslado', 'as' => 'reembolso.addTranslado']);
        Route::put('add-despesa/{id}', ['uses' => 'ReembolsoController@addDespesa', 'as' => 'reembolso.addDespesa']);
    });
    // FIM ROTAS DE REEMBOLSO

    // INICIO ROTAS DE VIAGEM
    Route::group(['prefix' => 'viagem'],function()
    {
        Route::get('', ['uses' => 'ViagemController@index', 'as' => 'viagem.index']);
        Route::get('cadastrar', ['uses' => 'ViagemController@cadastrar', 'as' => 'viagem.cadastrar']);
        Route::post('salvar', ['uses' => 'ViagemController@salvar', 'as' => 'viagem.salvar']);
        Route::put('add-viagem/{id}', ['uses' => 'ViagemController@addViagem', 'as' => 'viagem.addViagem']);
        Route::get('editar-viagem/{id}', ['uses' => 'ViagemController@editar', 'as' => 'viagem.editar']);
        Route::put('atualizar-cabecalho/{id}', ['uses' => 'ViagemController@atualizarCabecalho', 'as' => 'viagem.atualizarCabecalho']);
    });
    // FIM ROTAS DE VIAGEM
});
// FIM DAS ROTAS DE SOLICITAÇÃO


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





