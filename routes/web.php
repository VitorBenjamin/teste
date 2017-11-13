<?php


Route::get('/', ['uses' => 'SolicitacaoController@index','middleware' => 'auth', 'as' => 'solicitacao.index']);
Route::post('solictacao-deletar', ['uses' => 'SolicitacaoController@deletar', 'as' => 'solicitacao.deletar']);
Route::get('/ajax/clientes', ['uses' => 'ClienteController@getCliente', 'as' => 'cliente.getCliente']);
Route::get('/ajax/solicitantes', ['uses' => 'SolicitanteController@getSolicitante', 'as' => 'solicitante.getSolicitante']);
// Route::get('cadastrar', ['uses' => 'CompraController@cadastrar', 'as' => 'compra.cadastrar']);

Auth::routes();

// INICIO ROTAS DE SOLICITAÇÃO
Route::group(['prefix' => 'solicitacao','middleware' => 'auth'],function()
{

  Route::get('set-andamento/{id}', ['uses' => 'SolicitacaoController@andamento', 'as' => 'solicitacao.andamento']);
  Route::get('set-devolvido/{id}', ['uses' => 'SolicitacaoController@devolvido', 'as' => 'solicitacao.devolvido']);

    // INICIO ROTAS DE COMPRA
  Route::group(['prefix' => 'compra'],function()
  {

   Route::get('', ['uses' => 'CompraController@index', 'as' => 'compra.index']);
   Route::get('cadastrar', ['uses' => 'CompraController@cadastrar', 'as' => 'compra.cadastrar']);
   Route::post('salvar', ['uses' => 'CompraController@salvar', 'as' => 'compra.salvar']);
   Route::put('atualizar-cabecalho/{id}', ['uses' => 'CompraController@atualizarCabecalho', 'as' => 'compra.atualizarCabecalho']);
   Route::put('add-compra/{id}', ['uses' => 'CompraController@addCompra', 'as' => 'compra.addCompra']);
   Route::get('deletar-compra/{id}', ['uses' => 'CompraController@deletarCompra', 'as' => 'compra.deletarCompra']);
   Route::get('editar-compra/{id}', ['uses' => 'CompraController@veriicarSolicitacao', 'as' => 'compra.editar']);
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
   Route::get('editar-antecipacao/{id}', ['uses' => 'AntecipacaoController@veriicarSolicitacao', 'as' => 'antecipacao.editar']);
   Route::put('atualizar-antecipacao/{id}', ['uses' => 'AntecipacaoController@atualizarAntecipacao', 'as' => 'antecipacao.atualizarAntecipacao']);
 });
    // FIM ROTAS DE ANTECIPAÇÃO

    // INICIO ROTAS DE GUIA
  Route::group(['prefix' => 'guia'],function()
  {
   Route::get('', ['uses' => 'GuiaController@index', 'as' => 'guia.index']);
   Route::get('cadastrar', ['uses' => 'GuiaController@cadastrar', 'as' => 'guia.cadastrar']);
   Route::post('salvar', ['uses' => 'GuiaController@salvar', 'as' => 'guia.salvar']);
   Route::put('atualizar-cabecalho/{id}', ['uses' => 'GuiaController@atualizarCabecalho', 'as' => 'guia.atualizarCabecalho']);
   Route::put('add-guia/{id}', ['uses' => 'GuiaController@addGuia', 'as' => 'guia.addGuia']);
   Route::get('deletar-guia/{id}', ['uses' => 'GuiaController@deletarGuia', 'as' => 'guia.deletarGuia']);
   Route::get('editar-guia/{id}', ['uses' => 'GuiaController@veriicarSolicitacao', 'as' => 'guia.editar']);
   Route::get('edicao-guia/{id}', ['uses' => 'GuiaController@editarGuia', 'as' => 'guia.editarGuia']);
   Route::put('atualizar-guia/{id}', ['uses' => 'GuiaController@atualizarGuia', 'as' => 'guia.atualizarGuia']);
 });
    // FIM ROTAS DE GUIA    

    // INICIO ROTAS DE REEMBOLSO
  Route::group(['prefix' => 'reembolso'],function()
  {
    Route::get('', ['uses' => 'ReembolsoController@index', 'as' => 'reembolso.index']);
    Route::get('cadastrar', ['uses' => 'ReembolsoController@cadastrar', 'as' => 'reembolso.cadastrar']);
    Route::post('salvar', ['uses' => 'ReembolsoController@salvar', 'as' => 'reembolso.salvar']);
    Route::get('editar-reembolso/{id}', ['uses' => 'ReembolsoController@veriicarSolicitacao', 'as' => 'reembolso.editar']);
    Route::put('atualizar-cabecalho/{id}', ['uses' => 'ReembolsoController@atualizarCabecalho', 'as' => 'reembolso.atualizarCabecalho']);
    Route::put('atualizar-despesa/{id}', ['uses' => 'ReembolsoController@atualizarDespesa', 'as' => 'reembolso.atualizarDespesa']);
    Route::put('atualizar-translado/{id}', ['uses' => 'ReembolsoController@atualizarTranslado', 'as' => 'reembolso.atualizarTranslado']);
    Route::post('/deletar', ['uses' => 'ReembolsoController@deletar', 'as' => 'reembolso.deletar']);
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

    Route::get('deletar-viagem/{id}', ['uses' => 'ViagemController@deletarViagem', 'as' => 'viagem.deletarViagem']);
    Route::get('editar-viagem/{id}', ['uses' => 'ViagemController@veriicarSolicitacao', 'as' => 'viagem.editar']);
    Route::put('atualizar-cabecalho/{id}', ['uses' => 'ViagemController@atualizarCabecalho', 'as' => 'viagem.atualizarCabecalho']);
    Route::put('atualizar-viagem/{id}', ['uses' => 'ViagemController@atualizarViagem', 'as' => 'viagem.atualizarViagem']);

  });
    // FIM ROTAS DE VIAGEM
});
// FIM DAS ROTAS DE SOLICITAÇÃO