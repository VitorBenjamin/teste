<div class="modal fade" id="modalDevolver" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="largeModalLabel">DESEJA DEVOLVER ESSA SOLICITAÇÂO?</h4>
			</div>
			<!-- INCIO SESSÃO DESPESA -->
			<div class="modal-body">
				<form action="{{ route('solicitacao.devolver',$solicitacao->id)}}" method="POST" enctype="multipart/form-data">
					{{ csrf_field() }}
					{{ method_field('PUT') }}
					<div class="body">
						<div class="row clearfix">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="card">
									<div class="header">
										<h2>
											Deixe uma Observação 
										</h2>
									</div>
									<div class="body">
										<div class="row clearfix">
											<div class="col-md-12">
												<div class="form-group">
													<div class="form-line">
														<label for="comentario">Observação</label>
														<textarea name="comentario" class="form-control" placeholder="..." required></textarea>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="modal-footer">
										<div class="form-group">
											<button class="btn btn-info">
												<i class="material-icons">replay</i>
												<span>DEVOLVER</span>
											</button>
										</div>
										<!-- <button type="button" class="btn btn-link waves-effect">SAVE CHANGES</button> -->
										<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CANCELAR</button>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- FIM SESSÃO DESPESA -->
				</form>
			</div>
		</div>
	</div>
</div>