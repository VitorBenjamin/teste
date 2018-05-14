@role(['ADMINISTRATIVO','FINANCEIRO'])
<div class="row clearfix">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="card">
			<div class="header">
				<h2>
					Comprovante
				</h2>
			</div>
			<div class="body">
				<form action="{{ route('solicitacao.addComprovante',$solicitacao->id)}}" method="POST" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="row clearfix">
						<div class="col-md-3">
							<div class="form-group">
								<div class="form-line">
									<label for="data">Data</label>
									<input type="text" value="" name="data" class="datepicker form-control" placeholder="Escolha uma Data" required />
								</div>
							</div>
						</div>
						<div class="col-md-5">
							<div class="form-group">
								<div class="form-line">
									<label style="margin-bottom: 20px" for="anexo">Comprovante do Pagamento (JPG)</label>
									<input type="file" name="anexo" id="anexo" accept="image/jpeg" required/>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<button class="btn btn-info" type="submit" style="margin-top: 25px;">
									<i class="material-icons">save</i>
									<span>ANEXAR COMPROVANTE</span>
								</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div> 												
</div>
@endrole