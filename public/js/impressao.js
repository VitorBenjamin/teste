
	// Parser para configurar a data para o formato do Brasil
	$.tablesorter.addParser({
		id: 'datetime',
		is: function(s) {
			return false; 
		},
		format: function(s,table) {
			s = s.replace(/\-/g,"/");
			s = s.replace(/(\d{1,2})[\/\-](\d{1,2})[\/\-](\d{4})/, "$3/$2/$1");
			return $.tablesorter.formatFloat(new Date(s).getTime());
		},
		type: 'numeric'
	});

	$('.tablesorter').tablesorter({
		sortList: [[0,0]],
        // Envia os cabeçalhos 
        headers: { 
            // A sgunda coluna (começa do zero) 
            0: { 
                // Desativa a ordenação para essa coluna 
                sorter: 'datetime' 
            },
            1: { 
                // Desativa a ordenação para essa coluna 
                sorter: false 
            },
            2: { 
                // Desativa a ordenação para essa coluna 
                sorter: false 
            }
        },
		// Formato de data
		dateFormat: 'dd/mm/yyyy'
	});