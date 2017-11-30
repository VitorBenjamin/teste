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
					@role('COORDENADOR','FINANCEIRO')
					<a class="list-group-item ">							
						<h5 class="list-group-item-heading">{{$comentario->status}} -> {{$comentario->user->nome}}</h5>
						<h4 class="list-group-item-heading">{{date('d-m-y H:m',strtotime($comentario->created_at))}} </h4>
						<br>
						<p class="list-group-item-text">
							{{$comentario->comentario}}
						</p>
					</a>
					@endrole
					@else
					<a class="list-group-item ">							
						<h5 class="list-group-item-heading">{{$comentario->status}} -> {{$comentario->user->nome}}</h5>
						<h4 class="list-group-item-heading">{{date('d-m-y H:m',strtotime($comentario->created_at))}} </h4>
						<br>
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
