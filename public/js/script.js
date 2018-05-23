//Deixa todas os inputs UpperCase
$(document).ready(function() {
    $.extend(true, $.magnificPopup.defaults, 
    {
        tClose: 'Fechar (Esc)', // Alt text on close button
        tLoading: 'Carregando...', // Text that is displayed during loading. Can contain %curr% and %total% keys
        gallery: {
        tPrev: 'Anterior', // Alt text on left arrow (Left arrow key)
        tNext: 'Próximo', // Alt text on right arrow (Right arrow key)
        tCounter: '%curr% de %total%' // Markup for "1 of 7" counter
    },
    image: {
        tError: '<a target="_blank" href="%url%">Baixar o <i class="material-icons">picture_as_pdf</i> </a>&ensp; Imagem não pode ser carregada.' // Error message when image could not be loaded
    },
    ajax: {
        tError: '<a href="%url%">The content</a> Não pode ser carregada.' // Error message when ajax request failed
    }
});
    $('.zoom-gallery').magnificPopup({
        delegate: 'a',
        type: 'image',
        closeOnContentClick: false,
        closeBtnInside: false,
        mainClass: 'mfp-with-zoom mfp-img-mobile',
        image: {
            verticalFit: true,
            titleSrc: function(item) {
                return item.el.attr('title');
            }
        },
        gallery: {
            enabled: true
        },
        zoom: {
            enabled: true,
            duration: 300, // don't foget to change the duration also in CSS
            opener: function(element) {
                return element.find('img');
            }
        }
    });
});
ativo = false;
function desabilitar(e){
    e.stopPropagation();
    e.preventDefault();

}

function desabilitarClick (e) {

    if(ativo === false) {
        document.addEventListener("click",desabilitar,true);
    }

    ativo = true;

    setTimeout(function(){ document.removeEventListener("click",desabilitar,true); }, 5000);
}
$(document).ready(function() {
    $('.zoom-gallery2').magnificPopup({
        delegate: 'a',
        type: 'image',
        closeOnContentClick: false,
        closeBtnInside: false,
        mainClass: 'mfp-with-zoom mfp-img-mobile',
        image: {
            verticalFit: true,
            titleSrc: function(item) {
                return item.el.attr('title');
            }
        },
        gallery: {
            enabled: true
        },
        zoom: {
            enabled: true,
            duration: 300, // don't foget to change the duration also in CSS
            opener: function(element) {
                return element.find('img');
            }
        }
        
    });
});
$(function() {
    $('input:text').keyup(function() {
        this.value = this.value.toLocaleUpperCase()
    });
    
    var i=0;  
    
    // Wrap your File input in a wrapper <div>
    var wrapper = $('<div/>').css({height:0,width:0,'overflow':'hidden'});
    var fileInput = $('#anexo_comprovante0').wrap(wrapper);
    // When your file input changes, update the text for your button
    fileInput.change(function(){
        $this = $(this);
        // If the selection is empty, reset it
        if($this.val().length != 0) {
            $('#file0').text($this.val());
        }
    });
        // When your fake button is clicked, simulate a click of the file button
        $('#file0').click(function(){
            fileInput.click();
        }).show();

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
                +'<div class="col-md-4">'
                +'<div class="form-group">'
                +'<div class="form-line">'
                +'<label for="descricao">Descrição</label>'
                +'<input id="descricao" type="text" value="" name="descricao[]" class="form-control" placeholder="Descrição do produto" required/>'
                +'</div>'
                +'</div>'
                +'</div>'
                +'<div class="col-md-3">'
                +'<div class="form-group">'
                +'<div class="form-line">'
                +'<label for="fornecedor">Fornecedor</label>'
                +'<input id="fornecedor" type="text" value="" name="fornecedor[]" class="form-control" placeholder="Descrição do produto" required />                                     '
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
                // +'<div class="col-md-3">'
                // +'<div class="form-group">'
                // +'<div class="form-line">'
                // +'<label style="margin-bottom: 17px;" for="anexo_comprovante">Envie um Arquivo (jpeg,bmp,png)</label>'
                // +'<input type="file" name="anexo_comprovante[]" id="anexo_comprovante" required/>'
                // +'</div>'
                // +'</div>'
                // +'</div>'
                +'<div class="col-md-1">'
                +'<div class="form-group">'
                +'<div class="form-line">'
                +'<label for="quantidade">Valor R$</label>'
                +'<input type="numeric" name="valor[]" style="text-align:right" name="valor" class="form-control" size="11"  value="" onKeyUp="moeda(this);" required>'
                +'</div>'
                +'</div>'
                +'</div>'
                // +'<div class="col-md-2">'
                // +'<div class="form-line">'
                // +'<!-- Define your button -->'
                // +'<button type="button" style="padding: 10px 0;width:100%;overflow:hidden;margin-top: 16px;white-space: nowrap;" id="file'+i+'"> Anexar Arquivo </button>'
                // +'<!-- Your File element -->'
                // +' <input type="file" name="anexo_comprovante[]" id="anexo_comprovante'+i+'"/>'
                // +'</div>'
                // +'</div>'
                +'<div class="col-md-1" style="margin-top: 20px; padding-left: 0px !important;">'
                +'<button type="button" name="remove" id="'+i+'" class="btn bg-red waves-effect btn_remove">'
                +'<i class="material-icons">remove_circle</i>'
                +'<span>DEL.</span>'
                +'</button>'
                +'</div>'
                +'</div>'); 
            bind();
            changeFileInput(i);
            //$('.datepicker').bootstrapMaterialDatePicker('setDate', moment());
        });  
    });

function changeFileInput(i) {
    // Wrap your File input in a wrapper <div>
    $('input:text').keyup(function() {
        this.value = this.value.toLocaleUpperCase()
    });
    var wrapper = $('<div/>').css({height:0,width:0,'overflow':'hidden'});
    var fileInput = $('#anexo_comprovante'+i).wrap(wrapper);
    // When your file input changes, update the text for your button
    fileInput.change(function(){
        $this = $(this);
        // If the selection is empty, reset it
        if($this.val().length != 0) {
            $('#file'+i).text($this.val());
        }
    })
      // When your fake button is clicked, simulate a click of the file button
      $('#file'+i).click(function(){
        fileInput.click();
    }).show();
  }
  function bind() {
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
$('.submit2').click(function(event) {
    $( '#relatorioForm2' ).submit();
});
$('.submit3').click(function(event) {
    $( '#relatorioForm3' ).submit();
});


$('.checked_all').on('change', function() {     
    $('.checkbox').prop('checked', $(this).prop("checked"));              
});
    //deselect "checked all", if one of the listed checkbox product is unchecked amd select "checked all" if all of the listed checkbox product is checked
$('.checkbox').change(function(){ //".checkbox" change 
    //console.log($(this).attr("id"));
    var input = $(this).attr("id").toString();
    //console.log("_"+input);
    if ($(this).is(':checked')) {
        $("#_"+input).prop('checked', false);
        console.log("1");
        console.log($("#_"+input).attr("id"));
    }else{
        $("#_"+input).prop('checked', true);
        console.log("2");
        console.log($("#_"+input).attr("id"));
    }
    
});
$( ".codigo" ).on('input',function(e){
    if ($( this ).val()) {
        $('#cliente').removeAttr('required', false);
        $('#advogado').removeAttr('required', false);
    }else{
        $('#cliente').attr('required', true);
        $('#advogado').attr('required', true);
    }
});
$(".finalizado").change(function(){ //".checkbox" change 
    //console.log($( this ).prop("checked"));
    if ($( this ).prop("checked")) {

        $('#cliente').removeAttr('required', false);
        $('#advogado').removeAttr('required', false);
    }else{
        $('#cliente').attr('required', true);
        $('#advogado').attr('required', true);
    }
});
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

        $('.label2').css("color","#ded5d5");
        $('.label3').css("color","#ded5d5");
        $('.label4').css("color","#ded5d5");
        $('.label5').css("color","#ded5d5");

        $('#cliente').selectpicker('deselectAll');
        $('#cliente').removeAttr('required', false);
        $('#cliente').selectpicker('hide');
        $('#cliente').selectpicker('refresh');
        
        $('#solicitante').selectpicker('deselectAll');
        $('#solicitante').removeAttr('required', false);
        $('#solicitante').selectpicker('hide');
        $('#solicitante').selectpicker('refresh');

        $('#contrato').selectpicker('deselectAll');
        $('#contrato').removeAttr('required', false);
        $('#contrato').selectpicker('hide');
        $('#contrato').selectpicker('refresh');

        $('#processo').val("");
        $('#processo').hide();

    }else{
        $('#cliente').attr('required', true);
    }
    var value = $('#selecionar_compra').val();
    if (value == "") {
        $('#cadastrar_cotacao').attr('disabled', true);
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

$('#cliente').change(function() {
    var value = $(this).val();
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        type: 'POST',
        dataType: 'json',
        data:  {
            "data": value
        },
        url: "/ajax/solicitantes",
        success: function (data) {
            //console.log(data);
            //$('#solicitante').selectpicker('destroy');
            $("#solicitante").empty();
            $('#solicitante').selectpicker('refresh');
            $.each(data, function(i, item) {
                console.log( item.id );
                $("#solicitante").append(
                    $("<option>"+item.nome+"</option>").attr("value", item.id)
                    );

                $('#solicitante').selectpicker('refresh');
            });
        },
        error: function (data) {
            $("#solicitante").empty();
            $('#solicitante').selectpicker('refresh');
            console.log('Error:', data);
        }
    });
    // var request = $.ajax({
    //     type: 'GET',
    //     data: value,
    //     url: "/ajax/solicitantes",
    // });
    // request.done(function(data){
    //     console.log(data);
    //     var option_list = [["", "--- Select One ---"]].concat(data);

    //     $("#solicitante").empty();
    //     for (var i = 0; i < option_list.length; i++) {
    //         $("#solicitante").append(
    //             $("<option></option>").attr(
    //                 "value", option_list[i][0]).text(option_list[i][1])
    //             );
    //     }
    // });
});

$('#clientes_id').change(function() {
    var value = $(this).val();
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    console.log(value);
    $.ajax({
        type: 'POST',
        dataType: 'json',
        data:  {
            "data": value
        },
        url: "/ajax/relatorio-data",
        success: function (data) {
            console.log(data);
            //$('#solicitante').selectpicker('destroy');
            $("#data_inicial").val(data);

        },
        error: function (data) {

            console.log('Error:', data);
        }
    });
});
$('#my-form').on('submit', function () {
    // body...
});
$('#selecionar_compra').change(function() {
    var value = $(this).val();
    if ($(this).val() == "") {
        $('#cadastrar_cotacao').attr('disabled', true);
    }else{
        $('#cadastrar_cotacao').removeAttr('disabled', false);
    }
    $('#compras_id').val(value);
    console.log($('#compras_id').val());

});
$('#origem_despesa').change(function() {

    var value = $(this).val();

    if (value == "ESCRITÓRIO") {
        $('.label2').css("color","#ded5d5");
        $('.label3').css("color","#ded5d5");
        $('.label4').css("color","#ded5d5");
        $('.label5').css("color","#ded5d5");

        $('#cliente').selectpicker('deselectAll');
        $('#cliente').removeAttr('required', false);
        $('#cliente').selectpicker('hide');
        $('#cliente').selectpicker('refresh');
        
        $('#solicitante').selectpicker('deselectAll');
        $('#solicitante').removeAttr('required', false);
        $('#solicitante').selectpicker('hide');
        $('#solicitante').selectpicker('refresh');

        $('#contrato').selectpicker('deselectAll');
        $('#contrato').removeAttr('required', false);
        $('#contrato').selectpicker('hide');
        $('#contrato').selectpicker('refresh');

        $('#processo').val("");
        $('#processo').hide();
    }else{
        $('.label2').css("color","#555"); 
        $('.label3').css("color","#555");
        $('.label4').css("color","#555"); 
        $('.label5').css("color","#555");
        
        $('#cliente').removeAttr('disabled',false);
        $('#cliente').selectpicker('show');
        $('#cliente').attr('required', true);
        $('#cliente').selectpicker('refresh');

        $('#solicitante').removeAttr('disabled',false);
        $('#solicitante').selectpicker('show');
        $('#solicitante').attr('required', true);
        $('#solicitante').selectpicker('refresh');

        $('#contrato').removeAttr('disabled',false);
        $('#contrato').selectpicker('show');
        $('#contrato').attr('required', true);
        $('#contrato').selectpicker('refresh');

        $('#processo').show();
        

    }
});

$('#origem_despesa').change(function() {

    var value = $(this).val();

    if (value == "ESCRITÓRIO") {
        $('#label').css("color","#ded5d5");

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
