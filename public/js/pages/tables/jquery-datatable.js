$(function () {
    $('.js-basic-example').DataTable({
     language: {
        url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Portuguese-Brasil.json" 
    },       
    responsive: {
        details: {
            type: 'column',
            target: 'tr'
        }
    },
    columnDefs: [ {
        className: 'control',
        orderable: false,
        targets:   0
    } ],
    order: [ 1, 'asc' ]
});

    //Exportable table
    $('.js-exportable').DataTable({
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Portuguese-Brasil.json" 
        },   
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
        'copy', 'excel', 'pdf', 'print'
        ]

    });
});