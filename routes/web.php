<?php












Route::get('/', ['uses' => 'UserController@index','middleware' => 'auth', 'as' => 'user.index']);
Route::post('solictacao-deletar', ['uses' => 'SolicitacaoController@deletar', 'as' => 'solicitacao.deletar']);
Route::get('/ajax/clientes', ['uses' => 'ClienteController@getCliente', 'as' => 'cliente.getCliente']);
Route::get('/ajax/solicitantes', ['uses' => 'SolicitanteController@getSolicitante', 'as' => 'solicitante.getSolicitante']);
Route::get('/ajax/processo', ['uses' => 'ProcessoController@getProcesso', 'as' => 'processo.getProcesso']);

// Route::get('cadastrar', ['uses' => 'CompraController@cadastrar', 'as' => 'compra.cadastrar']);
Auth::routes();
Route::get('/cadastro/registrar-coordenador', 'Auth\RegisterController@showRegistrationFormCoordenador')->name('registerCoordenador');
Route::get('/cadastro/registrar-financeiro', 'Auth\RegisterController@showRegistrationFormFinanceiro')->name('registerFinanceiro');
Route::get('/cadastro/registrar-advogado', 'Auth\RegisterController@showRegistrationFormAdvogado')->name('registerAdvogado');


// // Authentication Routes...
// $this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
// $this->post('login', 'Auth\LoginController@login');
// $this->post('logout', 'Auth\LoginController@logout')->name('logout');

// // Registration Routes...
// $this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');

// $this->post('register', 'Auth\RegisterController@register');

// // Password Reset Routes...
// $this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
// $this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
// $this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
// $this->post('password/reset', 'Auth\ResetPasswordController@reset');

Route::group(['middleware' => ['check.user.role:GOD|COORDENADOR']],function()
{
    Route::get('coordenador-dashboard', ['uses' => 'UserController@coordenadorDash','middleware' => 'auth', 'as' => 'user.coordenadorDash']);
    Route::get('set-reprovar/{id}', ['uses' => 'SolicitacaoController@reprovar', 'as' => 'solicitacao.reprovar']);

});

Route::group(['middleware' => ['check.user.role:FINANCEIRO|COORDENADOR|ADMINISTRATIVO']],function()
{
    Route::get('set-aprovar/{id}', ['uses' => 'SolicitacaoController@aprovar', 'as' => 'solicitacao.aprovar']);
    Route::put('set-devolver/{id}', ['uses' => 'SolicitacaoController@devolver', 'as' => 'solicitacao.devolver']);
    Route::get('set-devolvido/{id}', ['uses' => 'SolicitacaoController@devolvido', 'as' => 'solicitacao.devolvido']);


});

Route::group(['middleware' => ['check.user.role:FINANCEIRO|ADMINISTRATIVO']],function()
{
    Route::get('financeiro-dashboard', ['uses' => 'UserController@financeiroDash','middleware' => 'auth', 'as' => 'user.financeiroDash']);
    Route::get('administrativo-dashboard', ['uses' => 'UserController@administrativoDash','middleware' => 'auth', 'as' => 'user.administrativoDash']);
    Route::get('set-finalizar/{id}', ['uses' => 'SolicitacaoController@finalizar', 'as' => 'solicitacao.finalizar']);
    Route::put('add-comprovante/{id}', ['uses' => 'AntecipacaoController@addComprovante', 'as' => 'antecipacao.addComprovante']);
    Route::put('add-viagem-comprovantes/{id}', ['uses' => 'ViagemController@addComprovante', 'as' => 'viagem.addComprovante']);
    Route::get('set-devolvido/{id}', ['uses' => 'SolicitacaoController@devolvido', 'as' => 'solicitacao.devolvido']);

});
Route::get('advogado-dashboard', ['uses' => 'UserController@advogadoDash','middleware' => 'check.user.role:ADVOGADO', 'as' => 'user.advogadoDash']);


// INICIO ROTAS DE SOLICITAÇÃO
Route::group(['prefix' => 'solicitacao','middleware' => ['check.user.role:ADVOGADO|FINANCEIRO|GOD|COORDENADOR|ADMINISTRATIVO']],function()
{
    Route::get('set-finalizar/{id}', ['uses' => 'SolicitacaoController@finalizar', 'as' => 'solicitacao.finalizar']);
    Route::get('analisar-compra/{id}', ['uses' => 'CompraController@analisar', 'as' => 'compra.analisar']);
    Route::get('analisar-antecipacao/{id}', ['uses' => 'AntecipacaoController@analisar', 'as' => 'antecipacao.analisar']);
    Route::get('analisar-guia/{id}', ['uses' => 'GuiaController@analisar', 'as' => 'guia.analisar']);
    Route::get('analisar-reembolso/{id}', ['uses' => 'ReembolsoController@analisar', 'as' => 'reembolso.analisar']);
    Route::get('analisar-viagem/{id}', ['uses' => 'ViagemController@analisar',  'as' => 'viagem.analisar']);
    Route::put('add-contacao/{id}', ['uses' => 'CompraController@addCotacao', 'as' => 'compra.addCotacao']);
    Route::get('set-andamento/{id}', ['uses' => 'SolicitacaoController@andamento', 'as' => 'solicitacao.andamento']);


});

Route::group(['prefix' => 'solicitacao','middleware' => ['check.user.role:ADVOGADO|GOD|COORDENADOR']],function()

{

    Route::put('atualizar-cabecalho/{id}', ['uses' => 'SolicitacaoController@atualizarCabecalho', 'as' => 'solicitacao.atualizarCabecalho']);

    // INICIO ROTAS DE COMPRA
    Route::group(['prefix' => 'compra'],function()
    {

        Route::get('', ['uses' => 'CompraController@index', 'as' => 'compra.index']);
        Route::get('cadastrar', ['uses' => 'CompraController@cadastrar', 'as' => 'compra.cadastrar']);
        Route::post('salvar', ['uses' => 'CompraController@salvar', 'as' => 'compra.salvar']);
        Route::put('add-compra/{id}', ['uses' => 'CompraController@addCompra', 'as' => 'compra.addCompra']);
        Route::get('deletar-compra/{id}', ['uses' => 'CompraController@deletarCompra', 'as' => 'compra.deletarCompra']);
        Route::get('editar-compra/{id}', ['uses' => 'CompraController@verificarSolicitacao', 'as' => 'compra.editar']);
        Route::put('atualizar-compra/{id}', ['uses' => 'CompraController@atualizarCompra', 'as' => 'compra.atualizarCompra']);
        

    });
    // FIM ROTAS DE COMPRA

    // INICIO ROTAS DE ANTECIPAÇÃO
    Route::group(['prefix' => 'antecipacao'],function()
    {
        Route::get('', ['uses' => 'AntecipacaoController@index', 'as' => 'antecipacao.index']);
        Route::get('cadastrar', ['uses' => 'AntecipacaoController@cadastrar', 'as' => 'antecipacao.cadastrar']);
        Route::post('salvar', ['uses' => 'AntecipacaoController@salvar', 'as' => 'antecipacao.salvar']);
        Route::put('add-antecipacao/{id}', ['uses' => 'AntecipacaoController@addAntecipacao', 'as' => 'antecipacao.addAntecipacao']);
        Route::get('deletar-antecipacao/{id}', ['uses' => 'AntecipacaoController@deletarAntecipacao', 'as' => 'antecipacao.deletarAntecipacao']);
        Route::get('editar-antecipacao/{id}', ['uses' => 'AntecipacaoController@verificarSolicitacao', 'as' => 'antecipacao.editar']);
        Route::put('atualizar-antecipacao/{id}', ['uses' => 'AntecipacaoController@atualizarAntecipacao', 'as' => 'antecipacao.atualizarAntecipacao']);
        Route::put('add-despesa/{id}', ['uses' => 'AntecipacaoController@addDespesa', 'as' => 'antecipacao.addDespesa']);
        Route::put('atualizar-despesa/{id}', ['uses' => 'AntecipacaoController@atualizarDespesa', 'as' => 'antecipacao.atualizarDespesa']);
        Route::get('deletar-despesa/{id}', ['uses' => 'AntecipacaoController@deletarDespesa', 'as' => 'antecipacao.deletarDespesa']);
        Route::get('editar-despesa/{id}', ['uses' => 'AntecipacaoController@editarDespesa', 'as' => 'antecipacao.editarDespesa']);
        


    });
    // FIM ROTAS DE ANTECIPAÇÃO

    // INICIO ROTAS DE GUIA
    Route::group(['prefix' => 'guia'],function()
    {
        Route::get('', ['uses' => 'GuiaController@index', 'as' => 'guia.index']);
        Route::get('cadastrar', ['uses' => 'GuiaController@cadastrar', 'as' => 'guia.cadastrar']);
        Route::post('salvar', ['uses' => 'GuiaController@salvar', 'as' => 'guia.salvar']);
        Route::put('add-guia/{id}', ['uses' => 'GuiaController@addGuia', 'as' => 'guia.addGuia']);
        Route::get('deletar-guia/{id}', ['uses' => 'GuiaController@deletarGuia', 'as' => 'guia.deletarGuia']);
        Route::get('editar-guia/{id}', ['uses' => 'GuiaController@verificarSolicitacao', 'as' => 'guia.editar']);
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
        Route::get('editar-reembolso/{id}', ['uses' => 'ReembolsoController@verificarSolicitacao', 'as' => 'reembolso.editar']);
        Route::put('atualizar-despesa/{id}', ['uses' => 'ReembolsoController@atualizarDespesa', 'as' => 'reembolso.atualizarDespesa']);
        Route::put('atualizar-translado/{id}', ['uses' => 'ReembolsoController@atualizarTranslado', 'as' => 'reembolso.atualizarTranslado']);
        Route::post('deletar', ['uses' => 'ReembolsoController@deletar', 'as' => 'reembolso.deletar']);
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
        Route::get('editar-viagem/{id}', ['uses' => 'ViagemController@verificarSolicitacao', 'as' => 'viagem.editar']);
        Route::put('atualizar-viagem/{id}', ['uses' => 'ViagemController@atualizarViagem', 'as' => 'viagem.atualizarViagem']);
        
        Route::put('add-despesa/{id}', ['uses' => 'ViagemController@addDespesa', 'as' => 'viagem.addDespesa']);
        Route::put('atualizar-despesa/{id}', ['uses' => 'ViagemController@atualizarDespesa', 'as' => 'viagem.atualizarDespesa']);
        Route::get('deletar-despesa/{id}', ['uses' => 'ViagemController@deletarDespesa', 'as' => 'viagem.deletarDespesa']);
        Route::get('editar-despesa/{id}', ['uses' => 'ViagemController@editarDespesa', 'as' => 'viagem.editarDespesa']);



    });
    // FIM ROTAS DE VIAGEM
});
Route::group(['prefix' => 'admin','middleware' => ['check.user.role:COORDENADOR']],function()
{
    Route::get('cadastrar' , ['uses' => 'ClienteController@cadastrar', 'as' => 'cliente.cadastrar']);
    Route::post('salvar', ['uses' => 'ClienteController@salvar', 'as' => 'cliente.salvar']);
    Route::get('listagem-cliente', ['uses' => 'ClienteController@getAll', 'as' => 'cliente.getAll']);
    Route::get('editar-cliente/{id}', ['uses' => 'ClienteController@editar', 'as' => 'cliente.editar']);
    Route::put('atualizar-cliente/{id}', ['uses' => 'ClienteController@atualizar', 'as' => 'cliente.atualizar']);
    Route::get('deletar-cliente/{id}', ['uses' => 'ClienteController@deletarLimite', 'as' => 'cliente.deletarLimite']);

    Route::group(['prefix' => 'unidade','middleware' => ['check.user.role:COORDENADOR']],function()
    {
        Route::post('salvar', ['uses' => 'UnidadeController@salvar', 'as' => 'unidade.salvar']);
        Route::get('listagem-unidade', ['uses' => 'UnidadeController@getAll', 'as' => 'unidade.getAll']);
        Route::put('atualizar-unidade/{id}', ['uses' => 'UnidadeController@atualizar', 'as' => 'unidade.atualizar']);
        Route::get('deletar-unidade/{id}', ['uses' => 'UnidadeController@deletarLimite', 'as' => 'unidade.deletarLimite']);
    });
    Route::group(['prefix' => 'processo','middleware' => ['check.user.role:COORDENADOR']],function()
    {
        Route::get('cadastrar' , ['uses' => 'ProcessoController@cadastrar', 'as' => 'processo.cadastrar']);
        Route::post('salvar', ['uses' => 'ProcessoController@salvar', 'as' => 'processo.salvar']);
        Route::get('listagem-processo', ['uses' => 'ProcessoController@getAll', 'as' => 'processo.getAll']);
        Route::get('editar-processo/{id}', ['uses' => 'ProcessoController@editar', 'as' => 'processo.editar']);
        Route::put('atualizar-processo/{id}', ['uses' => 'ProcessoController@atualizar', 'as' => 'processo.atualizar']);
        Route::get('deletar-processo/{id}', ['uses' => 'ProcessoController@deletarLimite', 'as' => 'processo.deletarLimite']);
    });
    Route::group(['prefix' => 'solicitante','middleware' => ['check.user.role:COORDENADOR']],function()
    {
        Route::get('cadastrar' , ['uses' => 'SolicitanteController@cadastrar', 'as' => 'solicitante.cadastrar']);
        Route::post('salvar', ['uses' => 'SolicitanteController@salvar', 'as' => 'solicitante.salvar']);
        Route::get('listagem-solicitante', ['uses' => 'SolicitanteController@getAll', 'as' => 'solicitante.getAll']);
        Route::get('editar-solicitante/{id}', ['uses' => 'SolicitanteController@editar', 'as' => 'solicitante.editar']);
        Route::put('atualizar-solicitante/{id}', ['uses' => 'SolicitanteController@atualizar', 'as' => 'solicitante.atualizar']);
        Route::get('deletar-solicitante/{id}', ['uses' => 'SolicitanteController@deletarLimite', 'as' => 'solicitante.deletarLimite']);
    });

});
Route::group(['prefix' => 'administrativo/relatorio','middleware' => ['check.user.role:COORDENADOR']],function()
{
    Route::get('buscar', ['uses' => 'RelatorioController@relatorio', 'as' => 'relatorio.buscar']);
    Route::put('extornar', ['uses' => 'RelatorioController@extornar', 'as' => 'relatorio.extornar']);
    Route::put('salvar', ['uses' => 'RelatorioController@salvarRelatorio', 'as' => 'relatorio.salvar']);
    Route::get('finalizar/{id}', ['uses' => 'RelatorioController@finalizar', 'as' => 'relatorio.finalizar']);
    Route::get('previa', ['uses' => 'RelatorioController@previa', 'as' => 'relatorio.previa']);
    Route::get('visualizar/{id}', ['uses' => 'RelatorioController@visualizar', 'as' => 'relatorio.visualizar']);
    Route::get('editar/{id}', ['uses' => 'RelatorioController@editar', 'as' => 'relatorio.editar']);
    Route::get('deletar/{id}', ['uses' => 'RelatorioController@deletar', 'as' => 'relatorio.deletar']);
    Route::get('listagem', ['uses' => 'RelatorioController@listagem', 'as' => 'relatorio.listar']);



});
Route::group(['prefix' => 'relatorio','middleware' => ['auth.basic']],function()
{
    //Route::get('buscar', ['uses' => 'RelatorioController@gerarRelatorio', 'as' => 'relatorio.gerar']);



});

Route::group(['prefix' => 'user','middleware' => ['check.user.role:COORDENADOR']],function()
{
    Route::get('listagem-users', ['uses' => 'UserController@getAll', 'as' => 'user.getAll']);
    Route::get('editar-user/{id}', ['uses' => 'UserController@edit', 'as' => 'user.editar']);
    Route::put('atualizar-user/{id}', ['uses' => 'UserController@atualizar', 'as' => 'user.atualizar']);
    Route::put('add-limite/{id}', ['uses' => 'UserController@addLimite', 'as' => 'limite.add']);
    Route::get('deletar-limite/{user}/{limite}', ['uses' => 'UserController@deletarLimite', 'as' => 'user.deletarLimite']);
    Route::put('editar-limite/{id}', ['uses' => 'UserController@atualizarLimite', 'as' => 'limite.atualizar']);
});
// FIM DAS ROTAS DE SOLICITAÇÃO