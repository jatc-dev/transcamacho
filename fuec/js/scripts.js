$(function() {
    $("#buscaplaca").autocomplete({
        source: "buscaplaca.php", 
        minLength: 2,
        select: function(event, ui) {
  event.preventDefault();
  $('#buscaplaca').val(ui.item.buscaplaca); //para el campo de busqueda
  $('#idvehi').val(ui.item.idvehi);
  $('#placa').val(ui.item.placa);
  $('#modelo').val(ui.item.modelo);
  $('#marca').val(ui.item.marca);
  $('#clase').val(ui.item.clase);
  $('#numinterno').val(ui.item.numinterno);
  $('#numtarjeta').val(ui.item.numtarjeta);
  $('#emprvehi').val(ui.item.emprvehi);

  $("#buscaplaca").focus();
   }
    });
});



$(function() {
    $("#buscacontrato").autocomplete({
        source: "buscacontrato.php", 
        minLength: 2,
        select: function(event, ui) {
  event.preventDefault();
  $('#buscacontrato').val(ui.item.buscacontrato); //para el campo de busqueda
  $('#idcontrato').val(ui.item.idcontrato);
  $('#contratante').val(ui.item.contratante);
  $('#nitcontratante').val(ui.item.nitcontratante);
  $('#objetocontrato').val(ui.item.objetocontrato);
  $('#respcont').val(ui.item.respcont);
  $('#docuresp').val(ui.item.docuresp);
  $('#teleresp').val(ui.item.teleresp);
  $('#direresp').val(ui.item.direresp);


  $("#buscacontrato").focus();
   }
    });
});


$(function() {
    $("#buscaconductor1").autocomplete({
        source: "buscaconductor1.php", 
        minLength: 2,
        select: function(event, ui) {
  event.preventDefault();
  $('#buscaconductor1').val(ui.item.buscaconductor1); //para el campo de busqueda
  $('#idcond1').val(ui.item.idcond1);
  $('#nombcond1').val(ui.item.nombcond1);
  $('#docucond1').val(ui.item.docucond1);
  $('#licecond1').val(ui.item.licecond1);
  $('#vigecond1').val(ui.item.vigecond1);


  $("#buscaconductor1").focus();
   }
    });
});


$(function() {
    $("#buscaconductor2").autocomplete({
        source: "buscaconductor2.php", 
        minLength: 2,
        select: function(event, ui) {
  event.preventDefault();
  $('#buscaconductor2').val(ui.item.buscaconductor2); //para el campo de busqueda
  $('#idcond2').val(ui.item.idcond2);
  $('#nombcond2').val(ui.item.nombcond2);
  $('#docucond2').val(ui.item.docucond2);
  $('#licecond2').val(ui.item.licecond2);
  $('#vigecond2').val(ui.item.vigecond2);


  $("#buscaconductor2").focus();
   }
    });
});


$(function() {
    $("#buscaconductor3").autocomplete({
        source: "buscaconductor3.php", 
        minLength: 2,
        select: function(event, ui) {
  event.preventDefault();
  $('#buscaconductor3').val(ui.item.buscaconductor3); //para el campo de busqueda
  $('#idcond3').val(ui.item.idcond3);
  $('#nombcond3').val(ui.item.nombcond3);
  $('#docucond3').val(ui.item.docucond3);
  $('#licecond3').val(ui.item.licecond3);
  $('#vigecond3').val(ui.item.vigecond3);


  $("#buscaconductor3").focus();
   }
    });
});

$(function() {
    $("#origen").autocomplete({
        source: "buscaorigen.php", 
        minLength: 2,
        select: function(event, ui) {
  event.preventDefault();
  $('#origen').val(ui.item.origen); //para el campo de busqueda
  $('#origen1').val(ui.item.origen1);

  $("#origen").focus();
   }
    });
});

$(function() {
    $("#destino").autocomplete({
        source: "buscadestino.php", 
        minLength: 2,
        select: function(event, ui) {
  event.preventDefault();
  $('#destino').val(ui.item.destino); //para el campo de busqueda

  $("#destino").focus();
   }
    });
});


$(function() {
    $("#contratante").autocomplete({
        source: "buscacontratante.php", 
        minLength: 2,
        select: function(event, ui) {
  event.preventDefault();
  $('#contratante').val(ui.item.contratante); //para el campo de busqueda

  $("#contratante").focus();
   }
    });
});

