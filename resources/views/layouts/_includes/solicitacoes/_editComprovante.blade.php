@role(['ADMINISTRATIVO','FINANCEIRO'])
<!-- MODAL DESPESA -->
<div class="modal fade" id="modalComprovante" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="largeModalLabel">EDITAR COMPROVANTE</h4>
			</div>
			<!-- INCIO SESSÃO DESPESA -->
			<div class="modal-body">
				<form action="{{ route('solicitacao.editComprovante',$solicitacao->id)}}" method="POST" enctype="multipart/form-data">
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
								</div>
								<div class="body">
									<input type="hidden" name="comprovante_id" value="{{$solicitacao->comprovante[0]->id}}">
									<div class="row clearfix">
										<div class="col-md-3">
											<div class="form-group">
												<div class="form-line">
													<label for="data">Data</label>
													<input type="text" value="{{date('d/m/Y',strtotime($solicitacao->comprovante[0]->data))}}" name="data" class="datepicker form-control" placeholder="Escolha uma Data" required />
												</div>
											</div>
										</div>
										<div class="col-md-5">
											<div class="form-group">
												<div class="form-line">
													<label style="margin-bottom: 20px" for="anexo">Comprovante de Pagamento(jpeg,png)</label>
													<input type="file" name="anexo" id="anexo" accept="image/jpg, image/png" required/>
												</div>
											</div>
										</div>
									</div>
									<div class="modal-footer">
										<div class="form-group">
											<button class="btn btn-info">
												<i class="material-icons">update</i>
												<span>EDITAR COMPROVANTE</span>
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
@endrole