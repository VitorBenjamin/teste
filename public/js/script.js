//Deixa todas os inputs UpperCase
$(function() {
    var i=1;  
    $('input:text').keyup(function() {
        this.value = this.value.toLocaleUpperCase()
    });
    $('#add').click(function(){  

        i++;  

        $('#dynamic_field').append(
            '<div class="row clearfix" id="row'+i+'">'
            +'<div class="col-md-2">'
            +'<div class="form-group">'
            +'<div class="form-line">'
            +'<label for="data_cotacao">Data</label>'
            +'<input id="data_cotacao" type="text" value="" name="data_cotacao[]" class="datepicker form-control" placeholder="Escolha uma Data" required/>'
            +'</div>'
            +'</div>'
            +'</div>'
            +'<div class="col-md-3">'
            +'<div class="form-group">'
            +'<div class="form-line">'
            +'<label for="descricao">Descrição</label>'
            +'<input id="descricao" type="text" value="" name="descricao[]" class="form-control" placeholder="Descrição do produto" required/>'
            +'</div>'
            +'</div>'
            +'</div>'
            +'<div class="col-md-1">'
            +'<div class="form-group">'
            +'<div class="form-line">'
            +'<label for="quantidade">Qtd.</label>'
            +'<input type="text" value="" name="quantidade[]" class="form-control" placeholder="Qtd." required/>'
            +'</div>'
            +'</div>                              '
            +'</div>'
            +'<div class="col-md-3">'
            +'<div class="form-group">'
            +'<div class="form-line">'
            +'<label style="margin-bottom: 17px;" for="anexo_comprovante">Envie um Arquivo (jpeg,bmp,png)</label>'
            +'<input type="file" name="anexo_comprovante[]" id="anexo_comprovante" required/>'

            +'</div>'
            +'</div>'
            +'</div>'
            +'<div class="col-md-2" style="margin-top: 20px">'
            +'<a name="remove" id="'+i+'" class="btn bg-red waves-effect btn_remove">'
            +'<i class="material-icons">remove_circle</i>'
            +'<span>REMOVER</span>'
            +'</a>'
            +'</div>'
            +'</div>'); 
        fazBind();
        //$('.datepicker').bootstrapMaterialDatePicker('setDate', moment());
    });  

});


function fazBind() {
    $('.datepicker').bootstrapMaterialDatePicker({
        // format: 'dddd DD MMMM YYYY',
        //format : 'YYYY-MM-DD',
        format : 'DD-MM-YYYY',
        lang: 'pt-br',
        // clearButton: true,
        // clearText: 'Limpar',
        // cancelText : 'Cancelar',
        switchOnClick:true,
        autoClose: true,
        weekStart: 0,
        time: false
    });
}

$(document).on('click', '.btn_remove', function(){  

    var button_id = $(this).attr("id");   
    console.log(button_id);
    $('#row'+button_id+'').remove();  

});  
$('.submit').click(function(event) {
    $( '#relatorioForm' ).submit();
});


$('.checked_all').on('change', function() {     
    $('.checkbox').prop('checked', $(this).prop("checked"));              
});
    //deselect "checked all", if one of the listed checkbox product is unchecked amd select "checked all" if all of the listed checkbox product is checked
$('.checkbox').change(function(){ //".checkbox" change 
    if($('.checkbox:checked').length == $('.checkbox').length){
        $('.checked_all').prop('checked',true);
    }else{
        $('.checked_all').prop('checked',false);
    }
});

$( window ).load(function() {

    var value = $('#origem_despesa').val();

    if (value == "ESCRITÓRIO") {

        $('#label').css("color","#ded5d5");
        $('#cliente').selectpicker('deselectAll');
        $('#cliente').selectpicker('hide');
        $('#cliente').selectpicker('refresh');

    }else{
      $('#cliente').attr('required', true);
  }
    //$('.js-basic-example').DataTable().responsive.recalc();
    //console.log($('.js-basic-example').DataTable().responsive.recalc());
});

function moeda(z)
{     
    v = z.value;    
    v=v.replace(/\D/g,"")  
    //permite digitar apenas números  
    v=v.replace(/[0-9]{12}/,"inválido")   
    //limita pra máximo 999.999.999,99  
    // v=v.replace(/(\d{1})(\d{8})$/,"$1.$2") 
    //coloca ponto antes dos últimos 8 digitos  
    // v=v.replace(/(\d{1})(\d{5})$/,"$1.$2")  
    //coloca ponto antes dos últimos 5 digitos
    v=v.replace(/(\d{1})(\d{1,2})$/,"$1.$2")  
    //coloca virgula antes dos últimos 2 digitos    
    z.value = v;  
}
$(document).ready(function () {

    $("a[data-toggle=\"tab\"]").on("shown.bs.tab", function (e) {
        $($.fn.dataTable.tables(true)).DataTable()
        .columns.adjust()
        .responsive.recalc();
    });

    $('#processo').typeahead({
        source: function(query, result)
        {
            $.ajax(
            {
                url: "/ajax/processo",
                method:"GET",
                data:{query:query},
                dataType:"json",
                success:function(data)
                {
                    result($.map(data, function(item){
                        return item;
                    }));
                }
            })
        }
    });

});

//Desativa o select de CLIENTES Caso Origem da despesa seja = Escritório
$('#contrato').change(function() {
    var value = $(this).val();
    if (value =="CONTENSIOSO") {
        $('#processo').attr('required', true);
    }else{
        $('#processo').removeAttr('required', false);
    }
});
$('#origem_despesa').change(function() {

    var value = $(this).val();

    if (value == "ESCRITÓRIO") {
        $('#label').css("color","#ded5d5");

        // $('#clientes').closest('label').addClass("red2");
    //console.log('ghjhgjgj');
    // $('#clientes').attr("disabled", true);
    $('#cliente').selectpicker('deselectAll');
    $('#cliente').removeAttr('required', false);
    $('#cliente').selectpicker('hide');
    $('#cliente').selectpicker('refresh');

}else{
    $('#label').css("color","#555"); 
    $('#cliente').removeAttr('disabled',false);
    $('#cliente').selectpicker('show');
    $('#cliente').attr('required', true);
    $('#cliente').selectpicker('refresh');
}
});
// $( "#cliente" ).change(function () {
//     var str = "";
//     alert($(this).val());

// });


//Ajax para trazer os clientes
$('#solicitantes')
.selectpicker({
    liveSearch: true
})
.ajaxSelectPicker({
  ajax: {
    url: "/ajax/solicitantes",
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
    statusSearching: 'Buscando',
    searchPlaceholder: 'Buscar...'
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
$('#clientesAjax')
.selectpicker({
    liveSearch: true
})
.ajaxSelectPicker({
  ajax: {
    url: "/ajax/solicitantes",
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
    statusSearching: 'Buscando',
    searchPlaceholder: 'Buscar...'

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

function openModal() {
  document.getElementById('myModal').style.display = "block";
}

function closeModal() {
  document.getElementById('myModal').style.display = "none";
}

var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("demo");
  var captionText = document.getElementById("caption");
  if (n > slides.length) {slideIndex = 1}
    if (n < 1) {slideIndex = slides.length}
      for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[slideIndex-1].style.display = "block";
    dots[slideIndex-1].className += " active";
    captionText.innerHTML = dots[slideIndex-1].alt;
}
