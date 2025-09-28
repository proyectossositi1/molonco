// A $( document ).ready() block.
$( document ).ready(function() {
    console.log( "ready!" );
    var currentWidhtVp=  $(window).width();
    $(window).on('resize', function() {

        var currentWidth = $(window).width();
        
        //var currentHeight = $(window).height();
        //console.log("Current dimensions: " + currentWidth + "x" + currentHeight);
        if(currentWidth<=640){
            console.log("Window resize event detected!");
            $("#menu").prependTo("#menumobil1")
        }else{
            $("#menu").insertBefore("#buscador")
        }
    });
    if(currentWidhtVp<=640){
        console.log("Window resize event detected!");
        $("#menu").prependTo("#menumobil1")
    }else{
        $("#menu").insertBefore("#buscador")
    }
    $("#btnmenumobil1").click(function(){
        $("#menu").toggleClass("active");
    });
    $("#btnmenumobil2").click(function(){
        $("#contentmenucategorias").toggleClass("active");
    });
    
    
});