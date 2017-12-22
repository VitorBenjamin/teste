$(function () {
    $('.js-basic-example').DataTable({
       autoWidth: false,
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
        targets:   0,
        render: function ( data, type, row ) {
            return data.substr( 0, 5 );
        }
    } ]
});
    $('.table-simples').DataTable({
       autoWidth: false,
       searching: false,
       paging: false,
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
        targets:   0,
        render: function ( data, type, row ) {
            return data.substr( 0, 5 );
        }
    } ]
});

    //Exportable table
    $('.js-exportable').DataTable({
        pageLength: 50,
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
        order: [ 1, 'asc' ],   
        dom: 'Bfrtip',
        responsive: true,
        buttons:[
        {
            extend: 'copy',
            footer: true,
        },
        {
            extend: 'csv',
        },
        {
            extend: 'excel',
            footer: true,
        },
        {
            extend: 'pdf',
            footer: true,
            text: 'PDF',

        },
        {
            extend: 'print',
            footer: true,
        },
        ],
        footerCallback: function ( row, data, start, end, display ) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                i.replace(/[\R$,]/g, '')*1 :
                typeof i === 'number' ?
                i : 0;
            };
            // Total over all pages
            total = api
            .column( 4 )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

            // Total over this page
            pageTotal = api
            .column( 4, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
                return intVal(a) + intVal(b);
            }, 0 );

            // Update footer
            var numFormat = $.fn.dataTable.render.number( '\.', ',', 2, 'R$ ' ).display;
            $( api.column( 3 ).footer() ).html(
                '<span style="margin: 0 90px 0 0;text-align:right;">'+'TOTAL DA PAGINA '+numFormat(pageTotal)+'</span>'
                );
            $( api.column( 4 ).footer() ).html(
                '<span style="margin: 0 90px 0 0;">'+'TOTAL '+ numFormat(total)+'</span>'
                );
        }

    });
});