// moment.locale('pt-br');
$(function () {
    //Textare auto growth
    autosize($('textarea.auto-growth'));

    //Datetimepicker plugin
    
    $('.datetimepicker').bootstrapMaterialDatePicker({
        //format: 'dddd DD MMMM YYYY - HH:mm',
        format: 'DD-MM-YYYY HH:mm:00',
        minDate : new Date(),
        lang: 'pt-br',
        // clearButton: true,
        // clearText: 'Limpar',
        switchOnClick:true,
        // cancelText : 'Cancelar',
        autoClose: true,
        weekStart: 0
    });

    $('.datepicker').bootstrapMaterialDatePicker({
        // format: 'dddd DD MMMM YYYY',
        //format : 'YYYY-MM-DD',
        format : 'DD-MM-YYYY',
        lang: 'pt-br',
        // clearButton: true,
        // clearText: 'Limpar',
        switchOnClick:true,
        // cancelText : 'Cancelar',
        autoClose: true,
        weekStart: 0,
        time: false
    });
    $('.datepicker2').bootstrapMaterialDatePicker({
        // format: 'dddd DD MMMM YYYY',
        //format : 'YYYY-MM-DD',
        format : 'DD-MM-YYYY',
        minDate : new Date(),
        lang: 'pt-br',
        switchOnClick:true,
        autoClose: true,
        weekStart: 0,
        time: false
    });
    // $('.volta').bootstrapMaterialDatePicker({
    //     format : 'DD-MM-YYYY',
    //     lang: 'pt-br',
    //     switchOnClick:true,
    //     autoClose: true,
    //     weekStart: 0,
    //     time: false,
    //     pickTime: false

    // });
    // $('.ida').bootstrapMaterialDatePicker({
    //     lang: 'pt-br',
    //     minDate : new Date(),
    //     format : 'DD-MM-YYYY',
    //     switchOnClick:true,
    //     autoClose: true,
    //     weekStart: 0,
    //     time: false,
    //     pickTime: false
    // }).on('change', function(e, date)
    // {
    //     $('.volta').bootstrapMaterialDatePicker('setMinDate', date);
    // }); 

    // $('.timepicker').bootstrapMaterialDatePicker({
    //     format: 'HH:mm',
    //     clearButton: true,
    //     date: false
    // });
});