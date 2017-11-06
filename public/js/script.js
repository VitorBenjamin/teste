//Deixa todas os inputs UpperCase
$(function() {
    $('input:text').keyup(function() {
        this.value = this.value.toLocaleUpperCase()
    });
});

//Desativa o select de CLIENTES Caso Origem da despesa seja = Escritório
$('#origem_despesa').change(function() {
      
      var value = $(this).val();

      if (value == "ESCRITÓRIO") {
      
         $('#clientes').attr("disabled", true);
         $('.selectpicker').selectpicker('refresh');
      
      }else{
       
       $('#clientes').removeAttr('disabled',false);
       $('.selectpicker').selectpicker('refresh');
      
      }
});


//Ajax para trazer os clientes
$('#solicitantes')
    .selectpicker({
        liveSearch: true
    })
    .ajaxSelectPicker({
        ajax: {
            url: urlSoli,
            type: 'GET',
            data: function () {
                var params = {
                    q: '{{{q}}}'
                };
            }
        },
        locale: {
            emptyTitle: 'Buscar Por Solicitantes...',
            statusInitialized: 'Digite para Buscar',
            statusNoResults: 'Nenhum Resultado',
            statusSearching: 'Buscando'
        },
        preprocessData: function(data){
            var solicitantes = [];
            if(data.hasOwnProperty('solicitantes')){
                var len = data.solicitantes.length;
                for(var i = 0; i < len; i++){
                    var curr = data.solicitantes[i];
                    solicitantes.push(
                        {
                            'value': curr.id,
                            'text': curr.nome,
                            // 'data': {
                            //     'icon': 'icon-person'
                            //     // 'subtext': 'Internal'
                            // },
                            'disabled': false
                        }
                    );
                }
            }
            return solicitantes;
        },
        preserveSelected: false
    });

//Ajax para trazer os clientes
$('#clientes')
    .selectpicker({
        liveSearch: true
    })
    .ajaxSelectPicker({
        ajax: {
            url: urlClientes,
            type: 'GET',
            data: function () {
                var params = {
                    q: '{{{q}}}'
                };
            }
        },
        locale: {
            emptyTitle: 'Buscar Por Clientes...',
            statusInitialized: 'Digite para Buscar',
            statusNoResults: 'Nenhum Resultado',
            statusSearching: 'Buscando'
        },
        preprocessData: function(data){
            var clientes = [];
            if(data.hasOwnProperty('clientes')){
                var len = data.clientes.length;
                for(var i = 0; i < len; i++){
                    var curr = data.clientes[i];
                    clientes.push(
                        {
                            'value': curr.id,
                            'text': curr.nome,
                            // 'data': {
                            //     'icon': 'icon-person'
                            //     // 'subtext': 'Internal'
                            // },
                            'disabled': false
                        }
                    );
                }
            }
            return clientes;
        },
        preserveSelected: false,
        langCode: 'pt-BR'
    });