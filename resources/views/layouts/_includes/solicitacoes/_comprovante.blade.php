<div class="row clearfix">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="card">
			<div class="header">
				<h2>
					Comprovante
				</h2>
			</div>
			<div class="body">
				@foreach($solicitacao->comprovante as $comprovante)	
				<div class="row clearfix">
					<div class="col-xs-6 col-sm-2">
						<h4>Data</h4>
						<p>{{date('d/m/Y',strtotime($comprovante->data))}}</p>
					</div>
					<div class="ccol-xs-6 col-sm-2">
						<div class="zoom-gallery">
							@if($comprovante->anexo_pdf)
							<h4>Anexo</h4>
							<span>
								<a id="broken-image" class="mfp-image" target="_blank" href="{{URL::to('storage/comprovante/'.$comprovante->anexo_pdf)}}"><i class="material-icons">picture_as_pdf</i></a>
							</span>
							@else
							<h4>Anexo</h4>
							<a href="{{$comprovante->anexo}}" data-source="{{$comprovante->anexo}}" title="COMPROVANTE - {{$solicitacao->tipo}} - {{date('d/m/Y',strtotime($comprovante->data))}}" style="width:50px;height:50px;">
								<img class="img_popup" src="{{$comprovante->anexo}}" width="50" height="50">
							</a>
							@endif
						</div>
					</div>
					@role(['ADMINISTRATIVO','FINANCEIRO'])
					@if($solicitacao->status()->get()[0]->descricao != config('constantes.status_finalizado'))
					<div class="col-sm-2">
						<div class="btn-group-lg btn-group-justified" role="group" aria-label="Justified button group" style="margin-top: 40px">
							<a data-toggle="modal" data-target="#modalComprovante" class="btn bg-orange waves-effect" role="button">
								<i class="material-icons">edit</i>
								<span>EDITAR</span>
							</a>
						</div>
					</div>
					@include('layouts._includes.solicitacoes._editComprovante')
					@endif
					@endrole
				</div>
				@endforeach
			</div>
		</div>
	</div> 												
</div>

