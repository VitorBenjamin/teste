<div class="row clearfix">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="card">
			<div class="header">
				<h2>
					Comentários
				</h2>
			</div>
			<div class="body">
				<div class="list-group">
					@foreach($solicitacao->comentarios as $comentario)
					@if($comentario->publico == false)
					@role('ADMINISTRATIVO' || 'FINANCEIRO' || 'COORDENADOR')
					<a class="list-group-item comentario">							
						<p class="titulo">{{$comentario->status}} -> {{$comentario->user->nome}}
							{{date('d-m-y H:i:s',strtotime($comentario->created_at))}}
						</p>
						<p class="list-group-item-text">
							{{$comentario->comentario}}
						</p>
					</a>
					@endrole
					@else
					<a class="list-group-item comentario">							
						<p class="titulo">{{$comentario->status}} -> {{$comentario->user->nome}}
							{{date('d-m-y H:i:s',strtotime($comentario->created_at))}}
						</p>
						<p class="list-group-item-text">
							{{$comentario->comentario}}
						</p>
					</a>
					@endif
					<!-- <textarea readonly>{{$comentario->comentario}}</textarea> -->
					@endforeach
				</div>
			</div>
		</div>
	</div>
</div>
