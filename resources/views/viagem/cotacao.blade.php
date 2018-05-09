<div class="modal fade" id="addCotacao{{$viagem->id}}" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="defaultModalLabel">DADOS REFERENTE À COTAÇÃO DA VIAGEM</h4>
			</div>
			<div class="modal-body">
				<form action="{{ route('viagem.addCotacao',$solicitacao->id)}}" method="POST" enctype="multipart/form-data">
					{{ csrf_field() }}
					{{ method_field('PUT') }}
					<input type="hidden" name="viagem_id" value="{{$viagem->id}}">
					<div class="col-md-12">
						@if(!$viagem->translado)
						<div class="row clearfix">
							<div class="col-md-2">
								<div class="form-group">
									<div class="form-line">
										<label for="data_cotacao_passagem">Data Passagem</label>
										<input type="text" id="data_cotacao_passagem" value="{{$viagem->data_cotacao ? date('d-m-Y', strtotime($viagem->data_cotacao)) : ''}}" name="data_cotacao_passagem" class="datepicker form-control" placeholder="Clique" required/>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<div class="form-line">
										<label for=">observacao_passagem">Observação Passagem</label>
										<input type="text" value="{{$viagem->data_cotacao ? $viagem->observacao_comprovante : ''}}" name="observacao_passagem" class="form-control" placeholder="Observação"/>
									</div>
								</div>
							</div>											
							<div class="col-md-2">
								<b>Custo da Passagem</b>
								<div class="input-group">
									<span class="input-group-addon">
										R$
									</span>
									<div class="form-line">
										<input type="numeric" value="{{$viagem->data_cotacao ? $viagem->valor : ''}}" name="custo_passagem" class="form-control valor" required/>
									</div>
								</div>
							</div>
						</div>
						@endif
						@if($viagem->hospedagem == 1)
						<div class="row clearfix">
							<div class="col-md-2">
								<div class="form-group">
									<div class="form-line">
										<label for="data_cotacao_hospedagem">Data Hospedagem</label>
										<input type="text" id="data_cotacao_hospedagem" value="{{$viagem->hospedagens ? date('d-m-Y', strtotime($viagem->hospedagens->data_cotacao)) : ''}}" name="data_cotacao_hospedagem" class="datepicker form-control" placeholder="Clique"/>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<div class="form-line">
										<label for="observacao_hospedagem">Observação Hospedagem</label>
										<input type="text" value="{{$viagem->hospedagens ? $viagem->hospedagens->observacao : ''}}" name="observacao_hospedagem" class="form-control" placeholder="Observação"/>	
									</div>
								</div>
							</div>
							<div class="col-md-2">
								<b>Custo da Hospedagem</b>
								<div class="input-group">
									<span class="input-group-addon">
										R$
									</span>
									<div class="form-line">
										<input type="numeric" value="{{$viagem->hospedagens != null ? $viagem->hospedagens->custo_hospedagem : ''}}" name="custo_hospedagem" class="form-control valor" required />
									</div>
								</div>
							</div>
						</div>
						@endif
						@if($viagem->locacao == 1)
						<div class="row clearfix">
							<div class="col-md-2">
								<div class="form-group">
									<div class="form-line">
										<label for="data_cotacao">Data Locação</label>
										<input type="text" id="data_locacao" value="{{$viagem->locacoes != null ? date('d-m-Y', strtotime($viagem->locacoes->data_cotacao)) : ''}}" name="data_cotacao_locacao" class="datepicker form-control" placeholder="Clique"/>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<div class="form-line">
										<label for="observacao_locacao">Observação Locação</label>
										<input type="text" value="{{$viagem->locacoes != null ? $viagem->locacoes->observacao : ''}}" name="observacao_locacao" class="form-control" placeholder="Observação"/>										
									</div>
								</div>
							</div>
							<div class="col-md-2">
								<b>Custo da Locação</b>
								<div class="input-group">
									<span class="input-group-addon">
										R$
									</span>
									<div class="form-line">
										<input type="numeric" value="{{$viagem->locacoes != null ? $viagem->locacoes->valor : ''}}" name="custo_locacao" class="form-control valor" required/>
									</div>
								</div>
							</div>
						</div>
						@endif
					</div>
					<div class="modal-footer">
						<div class="form-group">
							<button class="btn btn-info">
								<i class="material-icons">save</i>
								<span>ADD COTAÇÕES</span>
							</button>
						</div>
						<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CANCELAR</button>
					</div>
				</form>
			</div>

		</div>
	</div>
</div>