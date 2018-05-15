<!-- MODAL CADASTRO DO PRODUTO -->
<div class="modal fade" id="comprovante{{$compra->id}}" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="largeModalLabel">Adicione um Comprovante de Compra</h4>
			</div>
			<div class="modal-body">
				<form action="{{ route('compra.addComprovante',$compra->id)}}" method="POST" enctype="multipart/form-data">
					{{ csrf_field() }}
					{{ method_field('PUT') }}
					<div class="body">
						<div class="row clearfix">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="card">
									<div class="header">
										<h2>
											Preencha os campos abaixo com atenção
										</h2>
									</div>
									<div class="body">
										<div class="row clearfix">
											<div class="col-md-2">
												<div class="form-group">
													<div class="form-line">
														<label for="data_compra">Data</label>
														<input type="text" value="" name="data_compra" class="datepicker form-control" placeholder="Escolha uma Data"/>
													</div>
												</div>
											</div>
											<div class="col-md-4">
												<label for="cotacao_id">Cotação</label>
												<select id="cotacao_id" name="cotacao_id" class="form-control show-tick" disabled>
													@foreach ($compra->cotacao as $cotacao)
													@if ($cotacao->aprovado)													
													<option value="{{$cotacao->id}}">{{$cotacao->descricao}}-{{$cotacao->fornecedor}}</option>
													@endif
													@endforeach
												</select>
											</div>
											{{-- <div class="col-md-1">
												<input type="number" name="" value="" placeholder="" disabled>
											</div> --}}
											<div class="col-md-4">
												<div class="form-group">
													<div class="form-line">
														<label style="margin-bottom: 20px" for="anexo_comprovante">Comprovante de Compra (JPG)</label>
														<input type="file" name="anexo_comprovante" id="anexo_comprovante" accept="image/jpeg,image/jpg" required/>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="modal-footer">
										<div class="form-group">
											<button class="btn btn-info">
												<i class="material-icons">save</i>
												<span>ADD COMPROVANTE</span>
											</button>
										</div>
										<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CANCELAR</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- FIM MODAL CADASTRO DA PRODUTO -->