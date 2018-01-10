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
    $('.relatorio-previa').DataTable({
        autoWidth: false,
        aLengthMenu: [[30, 50, 100, -1], [30, 50, 100, "Todos"]],
        paging: true,
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Portuguese-Brasil.json" 
        },
        aoColumnDefs: [
        {
            bSortable: false,
            aTargets: [ -1 ]
        }
        ],   
        responsive: {
            details: {
                type: 'column',
                target: 'tr'
            }
        },
        aaSorting: [[ 0, 'asc' ]], 
        aoColumns: [ 
        { sType: "date-uk" }, null, null, null, null ],
        columnDefs: [ {
            className: 'control',
            orderable: false
        } ],
        dom: 'lfrtip',

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
            .column( 3 )
            .data()
            .reduce( function (a, b) {
                if (intVal(b) < 0) {
                    b= 0;
                }
                return intVal(a) + intVal(b);
            }, 0 );

            // Total over this page
            pageTotal = api
            .column( 3, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
                if (intVal(b) < 0) {
                    b= 0;
                }
                //console.log(parseFloat(b));
                return intVal(a) + intVal(b);
            }, 0 );

            // Update footer
            var numFormat = $.fn.dataTable.render.number( '\.', ',', 2, 'R$ ' ).display;
            $( api.column( 2 ).footer() ).html(
                '<span style="margin: 0 90px 0 0;text-align:right;">'+'TOTAL DA PAGINA '+numFormat(pageTotal)+'</span>'
                );
            $( api.column( 3 ).footer() ).html(
                '<span style="margin: 0 90px 0 0;">'+'TOTAL '+ numFormat(total)+'</span>'
                );
        }
    });
    $('.relatorio-aberto').DataTable({
        autoWidth: false,
        aLengthMenu: [[30, 50, 100, -1], [30, 50, 100, "Todos"]],
        paging: true,
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Portuguese-Brasil.json" 
        },
        aoColumnDefs: [
        {
            bSortable: false,
            aTargets: [ -1 ]
        }
        ],   
        responsive: {
            details: {
                type: 'column',
                target: 'tr'
            }
        },
        aaSorting: [[ 0, 'asc' ]], 
        aoColumns: [ 
        { sType: "date-uk" }, null, null, null, null ],
        columnDefs: [ {
            className: 'control',
            orderable: false
        } ],
        dom: 'lBfrtip',
        // responsive: true,
        buttons:[
        // {
        //     extend: 'copy',
        //     footer: true,
        // },
        // {
        //     extend: 'csv',
        // },
        // {
        //     extend: 'excel',
        //     footer: true,
        // },
        {
            extend: 'pdfHtml5',
            footer: true,
            text: '<i class="material-icons">picture_as_pdf</i>',
            header: true,
            title: t,
            orientation: 'landscape',
            exportOptions: {
                columns: [ 0, 1, 2, 3 ],
                // format: {
                //     body: function ( data, row, column ) {
                //         console.log(row);
                //         // return column === 3 ?
                //         //     data.replace( /[$,]/g, '' ) :
                //         //     data;
                //         return data;
                //     }
                // },
                rows: function ( idx, data, node ) {
                    //$(nRow).css('background-color', '#e96464');
                    //console.log(idx);
                    //node.attributes.style = {background-color: "#000";};
                    //console.log(this.api().row(row).nodes().to$());
                    return true;
                    // return data[2] === 'London' ?
                    // true : false;
                }
            },
            customize: function(doc) {
                
                //console.log(doc.styles.tableBodyOdd.fillColor="#000");
                //console.log(doc.content[1].table.body[0]);
                // console.log(doc.content[1]);
                // for (var r=1;r<doc.content[1].table.body.length;r++) {
                //     var row = doc.content[1].table.body[r];
                //     //console.log(row);
                //     for (c=0;c<row.length;c++) {
                //         var exportColor = table
                //         .cell( {row: r-1, column: c} )
                //         .nodes()
                //         .to$()
                //         .attr('export-color');
                //         //console.log(row[c].fillColor);
                //         if (exportColor) {
                            
                //             row[c].fillColor = exportColor;
                //         }
                //     }
                // }
                
                doc.content.splice( 1, 0, {
                    margin: [ 0, 0, 0, 0 ],
                    alignment: 'center',
                    image: 'data:image/png;base64,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'
                } );
                doc.defaultStyle.fontSize = 10;
                doc.pageMargins = [20,10,10,10];
                doc.styles.tableHeader.fontSize = 12;
                doc.styles.title.fontSize = 11;
                // Remove spaces around page title
                doc.content[0].text = doc.content[0].text.trim();
            } 

        }
        // {
        //     extend: 'print',
        //     footer: true,
        // }

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
            .column( 3 )
            .data()
            .reduce( function (a, b) {
                if (intVal(b) < 0) {
                    b= 0;
                }
                return intVal(a) + intVal(b);
            }, 0 );

            // Total over this page
            pageTotal = api
            .column( 3, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
                if (intVal(b) < 0) {
                    b= 0;
                }
                //console.log(parseFloat(b));
                return intVal(a) + intVal(b);
            }, 0 );

            // Update footer
            var numFormat = $.fn.dataTable.render.number( '\.', ',', 2, 'R$ ' ).display;
            $( api.column( 2 ).footer() ).html(
                '<span style="margin: 0 90px 0 0;text-align:right;">'+'TOTAL DA PAGINA '+numFormat(pageTotal)+'</span>'
                );
            $( api.column( 3 ).footer() ).html(
                '<span style="margin: 0 90px 0 0;">'+'TOTAL '+ numFormat(total)+'</span>'
                );
        }
    });
    $('.relatorio-final').DataTable({
        autoWidth: false,
        aLengthMenu: [[30, 50, 100, -1], [30, 50, 100, "Todos"]],
        paging: true,
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Portuguese-Brasil.json" 
        },
        aoColumnDefs: [
        {
            bSortable: false,
            aTargets: [ -1 ]
        }
        ],   
        responsive: {
            details: {
                type: 'column',
                target: 'tr'
            }
        },
        aaSorting: [[ 0, 'asc' ]], 
        aoColumns: [ 
        { sType: "date-uk" }, null, null, null, null ],
        columnDefs: [ {
            className: 'control',
            orderable: false
        } ],
        dom: 'lBfrtip',
        // responsive: true,
        buttons:[
        // {
        //     extend: 'copy',
        //     footer: true,
        // },
        // {
        //     extend: 'csv',
        // },
        // {
        //     extend: 'excel',
        //     footer: true,
        // },
        {
            extend: 'pdfHtml5',
            footer: true,
            text: '<i class="material-icons">picture_as_pdf</i>',
            header: true,
            title: t,
            orientation: 'landscape',
            exportOptions: {
                stripHtml:true,
                columns: [ 0, 1, 2, 3, 4 ],
                // format: {
                //     body: function ( data, row, column ) {
                //         console.log(row);
                //         // return column === 3 ?
                //         //     data.replace( /[$,]/g, '' ) :
                //         //     data;
                //         return data;
                //     }
                // },
                rows: function ( idx, data, node ) {
                    //$(nRow).css('background-color', '#e96464');
                    //console.log(idx);
                    //node.attributes.style = {background-color: "#000";};
                    //console.log(this.api().row(row).nodes().to$());
                    return true;
                    // return data[2] === 'London' ?
                    // true : false;
                }
            },
            customize: function(doc) {
                
                //console.log(doc.styles.tableBodyOdd.fillColor="#000");
                //console.log(doc.content[1].table.body[0]);
                // console.log(doc.content[1]);
                // for (var r=1;r<doc.content[1].table.body.length;r++) {
                //     var row = doc.content[1].table.body[r];
                //     //console.log(row);
                //     for (c=0;c<row.length;c++) {
                //         var exportColor = table
                //         .cell( {row: r-1, column: c} )
                //         .nodes()
                //         .to$()
                //         .attr('export-color');
                //         //console.log(row[c].fillColor);
                //         if (exportColor) {
                            
                //             row[c].fillColor = exportColor;
                //         }
                //     }
                // }
                
                doc.content.splice( 1, 0, {
                    margin: [ 0, 0, 0, 0 ],
                    alignment: 'center',
                    image: 'data:image/png;base64,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'
                } );
                doc.defaultStyle.fontSize = 10;
                doc.pageMargins = [20,10,10,10];
                doc.styles.tableHeader.fontSize = 12;
                doc.styles.title.fontSize = 11;
                // Remove spaces around page title
                doc.content[0].text = doc.content[0].text.trim();
            } 
        }
        // {
        //     extend: 'print',
        //     text:'<i class="material-icons">print</i>',
        //     footer: true,
        // }

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
            .column( 3 )
            .data()
            .reduce( function (a, b) {
                if (intVal(b) < 0) {
                    b= 0;
                }
                return intVal(a) + intVal(b);
            }, 0 );

            // Total over this page
            pageTotal = api
            .column( 3, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
                if (intVal(b) < 0) {
                    b= 0;
                }
                //console.log(parseFloat(b));
                return intVal(a) + intVal(b);
            }, 0 );

            // Update footer
            var numFormat = $.fn.dataTable.render.number( '\.', ',', 2, 'R$ ' ).display;
            $( api.column( 2 ).footer() ).html(
                '<span style="margin: 0 90px 0 0;text-align:right;">'+'TOTAL DA PAGINA '+numFormat(pageTotal)+'</span>'
                );
            $( api.column( 3 ).footer() ).html(
                '<span style="margin: 0 90px 0 0;">'+'TOTAL '+ numFormat(total)+'</span>'
                );
        }
    });

    $('.table-simples').DataTable({
        autoWidth: false,
        searching: false,
        paging: false,
        info:false,
        ordering: false,
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
    var t = "adasdadas";
    $('.exportacao-simples').DataTable({
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
        aaSorting: [[ 0, 'asc' ]], 
        aoColumns: [ 
        { sType: "date-uk" }, null, null ],

        dom: 'Bfrtip',
        responsive: true,
        buttons:[
        {
            extend: 'pdfHtml5',
            footer: true,
            text: 'PDF',
            header: true,
            title: t,
            orientation: 'landscape',
            customize: function(doc) {
                doc.content.splice( 1, 0, {
                    margin: [ 0, 0, 0, 0 ],
                    alignment: 'center',
                    image: 'data:image/png;base64,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'
                } );
                doc.defaultStyle.fontSize = 10;
                doc.pageMargins = [20,10,10,10];
                doc.styles.tableHeader.fontSize = 14;
                doc.styles.title.fontSize = 12;
                    // Remove spaces around page title
                    doc.content[0].text = doc.content[0].text.trim();
                } 

            }
            ]
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
        aaSorting: [[ 0, 'asc' ]], 
        aoColumns: [ 
        { sType: "date-uk" }, null, null, null ],
        
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
            extend: 'pdfHtml5',
            footer: true,
            text: 'PDF',
            header: true,
            title: t,
            orientation: 'landscape',
            exportOptions: {
                rows: function ( idx, data, node ) {
                    //node.attributes.style = {background-color: "#000";};
                    console.log(node.attributes.style);
                    //return true;
                    // return data[2] === 'London' ?
                    // true : false;
                }
            },
            customize: function(doc) {
                //console.log(doc.styles.tableBodyOdd.fillColor="#000");
                // console.log(doc.content[1].table);
                // for (var r=1;r<doc.content[1].table.body.length;r++) {
                //     var row = doc.content[1].table.body[r];
                //     for (c=0;c<row.length;c++) {
                //         var exportColor = table
                //         .cell( {row: r-1, column: c} )
                //         .nodes()
                //         .to$()
                //         .attr('export-color');
                //         //console.log(row[c].fillColor);
                //         if (exportColor) {
                //             row[c].fillColor = exportColor;
                //         }
                //     }
                // }
                
                doc.content.splice( 1, 0, {
                    margin: [ 0, 0, 0, 0 ],
                    alignment: 'center',
                    image: 'data:image/png;base64,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'
                } );
                doc.defaultStyle.fontSize = 10;
                doc.pageMargins = [20,10,10,10];
                doc.styles.tableHeader.fontSize = 14;
                doc.styles.title.fontSize = 12;
                // Remove spaces around page title
                doc.content[0].text = doc.content[0].text.trim();
            } 

        },
        {
            extend: 'print',
            footer: true,
        }

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
            .column( 3 )
            .data()
            .reduce( function (a, b) {
                if (intVal(b) < 0) {
                    b= 0;
                }
                return intVal(a) + intVal(b);
            }, 0 );

            // Total over this page
            pageTotal = api
            .column( 3, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
                if (intVal(b) < 0) {
                    b= 0;
                }
                //console.log(parseFloat(b));
                return intVal(a) + intVal(b);
            }, 0 );

            // Update footer
            var numFormat = $.fn.dataTable.render.number( '\.', ',', 2, 'R$ ' ).display;
            $( api.column( 2 ).footer() ).html(
                '<span style="margin: 0 90px 0 0;text-align:right;">'+'TOTAL DA PAGINA '+numFormat(pageTotal)+'</span>'
                );
            $( api.column( 3 ).footer() ).html(
                '<span style="margin: 0 90px 0 0;">'+'TOTAL '+ numFormat(total)+'</span>'
                );
        },
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
            var valor = aData[3].split('$');
            //console.log(teste);
            if (parseInt(valor[1])<0) { 
                $(nRow).css('background-color', '#e96464');
            }else{
                $(nRow).css('background-color', '#cdedc1');
            }
        }

    });
});
$.extend($.fn.dataTableExt.oSort, { 
    "date-uk-pre": function(a) { 
        var ukDatea = a.split('/'); 
        return (ukDatea[2] + ukDatea[1] + ukDatea[0]) * 1; 
    }, 
    "date-uk-asc": function(a, b) { 
        return ((a < b) ? -1 : ((a > b) ? 1 : 0)); 
    }, 
    "date-uk-desc": function(a, b) { 
        return ((a < b) ? 1 : ((a > b) ? -1 : 0)); 
    }
});
