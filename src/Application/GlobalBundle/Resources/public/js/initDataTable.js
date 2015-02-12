    $( document ).ready(function( ) {
        var $docHeight = window.innerHeight - 300;
        
        var table = $('table').DataTable( {
        "scrollY": $docHeight,
        "scrollX": "100%",
        "scrollCollapse": true,
        "paging": false,
        "ordering": false,
        "filter": false,
        "info": false
        } );
        
            
        new $.fn.dataTable.FixedColumns( table, {
            "leftColumns": 4
        } );
    });
