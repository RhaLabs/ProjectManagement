 $(function() {
    
    $( "#accordion" ).accordion({
      heightStyle: "content",
      collapsible: true,
      });
    

    
    var availableTags = [
      "ActionScript",
      "AppleScript",
      "Asp",
      "BASIC",
      "C",
      "C++",
      "Clojure",
      "COBOL",
      "ColdFusion",
      "Erlang",
      "Fortran",
      "Groovy",
      "Haskell",
      "Java",
      "JavaScript",
      "Lisp",
      "Perl",
      "PHP",
      "Python",
      "Ruby",
      "Scala",
      "Scheme"
    ];
    $( "#autocomplete" ).autocomplete({
      source: availableTags
    });
    

    
    //$( "#button" ).button();
    $(".button").button({
      icons: { primary: "ui-icon-triangle-1-e"}
    });
    $( "#radioset" ).buttonset();
    

    
    $( "#tabs" ).tabs();
    

    
    $( "#dialog" ).dialog({
      autoOpen: false,
      width: 400,
      buttons: [
        {
          text: "Ok",
          click: function() {
            $( this ).dialog( "close" );
          }
        },
        {
          text: "Cancel",
          click: function() {
            $( this ).dialog( "close" );
          }
        }
      ]
    });

    // Link to open the dialog
    $( "#dialog-link" ).click(function( event ) {
      $( "#dialog" ).dialog( "open" );
      event.preventDefault();
    });
    

    
    $( "#datepicker" ).datepicker({
      inline: true,
      dateFormat: "yy-mm-dd"
    });
    

    
    $( "#slider" ).slider({
      range: true,
      values: [ 17, 67 ]
    });
    

    
    $( "#progressbar" ).progressbar({
      value: 20
    });
    
    $( "#menu" ).menu({
      icons: {
       dropdown: "ui-icon-circle-triangle-e"
      },
      autoExpand:true,
      menuIcon:true,
      buttons:true
    });
    
    $( ".menubar" ).menubar();

    // Hover states on the static widgets
    $( "#dialog-link, #icons li" ).hover(
      function() {
        $( this ).addClass( "ui-state-hover" );
      },
      function() {
        $( this ).removeClass( "ui-state-hover" );
      }
    );
  });
  
  
