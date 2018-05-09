<div class="modal fade" id="addComprovante{{$viagem->id}}" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="defaultModalLabel">COMPROVANTES DA VIAGEM</h4>
			</div>
			<div class="modal-body">
				<form action="{{ route('viagem.addComprovante',$solicitacao->id)}}" method="POST" enctype="multipart/form-data">
					{{ csrf_field() }}
					{{ method_field('PUT') }}
					<input type="hidden" name="viagem_id" value="{{$viagem->id}}">
					<div class="col-md-12">
						@if (!$viagem->translado)
						<div class="row clearfix">
							<div class="col-md-2">
								<div class="form-group">
									<div class="form-line">
										<label for="data_compra">Data</label>
										<input type="text" id="data_compra" value="{{old('data_compra')}}" name="data_compra" class="datepicker form-control" placeholder="Clique" required/>
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
										<input type="numeric" value="{{$viagem->valor}}" name="custo_passagem" class="form-control valor" required/>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<div class="form-line">
										<label style="margin-bottom: 20px" for="anexo_passagem">Anexar Passagem</label>
										<input type="file" name="anexo_passagem" id="anexo_passagem" accept="image/jpeg, image/png" required />
									</div>
								</div>
							</div>
						</div>
						@endif
						@if($viagem->hospedagens)
						<div class="row clearfix">
							<div class="col-md-2">
								<div class="form-group">
									<div class="form-line">
										<label for="data_hospedagem">Data Hospedagem</label>
										<input type="text" id="data_hospedagem" value="{{old('data_hospedagem')}}" name="data_hospedagem" class="datepicker form-control" placeholder="Clique" required />
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
										<input type="numeric" value="{{$viagem->hospedagens->custo_hospedagem}}" name="custo_hospedagem" class="form-control valor" required />
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<div class="form-line">
										<label style="margin-bottom: 20px" for="anexo_hospedagem">Anexar Hospedagem</label>
										<input type="file" name="anexo_hospedagem" id="anexo_hospedagem" accept="image/jpeg, image/png" required />
									</div>
								</div>
							</div>
						</div>
						@endif
						@if($viagem->locacoes)
						<div class="row clearfix">
							<div class="col-md-2">
								<div class="form-group">
									<div class="form-line">
										<label for="data_locacao">Data Locação</label>
										<input type="text" id="data_locacao" value="{{old('data_locacao')}}"name="data_locacao" class="datepicker form-control" placeholder="Clique" required />
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
										<input type="numeric" value="{{$viagem->locacoes->valor}}" name="custo_locacao" class="form-control valor" required/>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<div class="form-line">
										<label style="margin-bottom: 20px" for="anexo_locacao">Anexar Locação</label>
										<input type="file" name="anexo_locacao" id="anexo_locacao" accept="image/jpeg, image/png" required/>											
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
								<span>ANEXAR COMPROVANTES</span>
							</button>
						</div>
						<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CANCELAR</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>