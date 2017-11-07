$(document).ready(function(){
  
  // Donde queremos cambiar el tamaño de la fuente
  var tamañoInicial=$("body").css("font-size");
  
  // Resetear Font Size
  $(".resetearFont").click(function(){
  donde.css('font-size', sizeFuenteOriginal);
  });
 
  // Aumentar Font Size
  $(".div-control-plus").click(function(){
    var tamano=$("body").css("font-size");
    var nuevotamano=tamano.slice(0,-2);
    $("body").css("font-size",(parseInt(nuevotamano)+2)+"px");
  });
 
  // Disminuir Font Size
  $(".div-control-minus").click(function(){
    var tamano=$("body").css("font-size");
    var nuevotamano=tamano.slice(0,-2);
    $("body").css("font-size",(parseInt(nuevotamano)-2)+"px");
  });
  
});