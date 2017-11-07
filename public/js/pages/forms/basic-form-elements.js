// moment.locale('pt-br');
$(function () {
    //Textare auto growth
    autosize($('textarea.auto-growth'));

    //Datetimepicker plugin
    
    $('.datetimepicker').bootstrapMaterialDatePicker({
        //format: 'dddd DD MMMM YYYY - HH:mm',
        format: 'YYYY-MM-DD - HH:mm:00',
        lang: 'pt-br',
        clearButton: true,
        clearText: 'Limpar',
        cancelText : 'Cancelar',
        weekStart: 1,
    });

    $('.datepicker').bootstrapMaterialDatePicker({
        // format: 'dddd DD MMMM YYYY',
        format : 'YYYY-MM-DD',
        lang: 'pt-br',
        clearButton: true,
        clearText: 'Limpar',
        cancelText : 'Cancelar',
        weekStart: 1,
        time: false
    });

    // $('.timepicker').bootstrapMaterialDatePicker({
    //     format: 'HH:mm',
    //     clearButton: true,
    //     date: false
    // });
});