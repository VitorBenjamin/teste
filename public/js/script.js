//Deixa todas os inputs UpperCase

$(function() {
    $('input:text').keyup(function() {
        this.value = this.value.toLocaleUpperCase()
    });
    $('.show-tick').selectpicker({
        noneResultsText: 'Nenhum Resultado Encontrado',
        deselectAllText:'DESELECIONAR TODOS',
        selectAllText: 'SELECIONAR TODOS'
    });

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
