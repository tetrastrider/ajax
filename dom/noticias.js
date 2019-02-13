
(function( window, undefined ) {
 
  var document  = window.document,
      navigator = window.navigator,
      location  = window.location;
      /******OBJETO AJAX********/
      
        ajax=function(){ 
        var req = false; try { req = new XMLHttpRequest(); } catch(err1) { try { req = new ActiveXObject("Msxml2.XMLHTTP"); } catch(err2) { try { req = new ActiveXObject("Microsoft.XMLHTTP"); } catch(err3) { req = false; } } } return req;
      }
      var ajax =ajax();
      /****************/
 
  var oculto = {
    /**********************/
      
        
    /**************************/
  };
 
/****************login**************/
$("#l_error").css('display', 'none', 'important');
     $("#dale").click(function(){
        event.stopPropagation();
     event.preventDefault(); 
          username=$("#lusuario").val();
          password=$("#lpass").val();

                      var request = $.ajax({
              url: "verificar.php",
              type: "GET",
              data: { usuario:username,password:password },
              dataType: "html"
            });
             
            request.done(function( msg ) {
            
              if(msg=='true')    {
             window.location="administrador.html";
            }
            else    {
            $("#l_error").css('display', 'table', 'important');
             $("#l_error").html("usuario o password incorrectos").fadeOut( 1000 );
             username.val('');
             password.val('');
            }
            
            });
             
            request.fail(function( jqXHR, textStatus ) {
              alert( "Request failed: " + textStatus );
            });

            return false;
    });

/**************************/

  var alex = (function(){
 
    var core = {
 
       from:function(orden,ide,url,limit){
      var azar=parseInt(Math.random()*99999999);
      var vinculo=url+"?orden="+orden+"&rand="+azar+"&limit="+limit;
      ajax.open("GET",vinculo,true);
      ajax.onreadystatechange=ajax.onreadystatechange=function(){
          if (ajax.readyState==4)
          {
              if (ajax.status==200)
              {
                  var http=ajax.responseText;
                  document.getElementById(ide).innerHTML= http;
      }}}
      ajax.send(null);

    },
          /*******PAGINA POR ID*********************************/
      val:function(ident) 
         {
         idvalor=ident
      $.ajax({
                    url:'contenidos/noticiasid.php',
                    type: "GET",
                    cache:false,
                    data:'id='+idvalor,
                    dataType: "html"
              }).done(function(re) { $('#cargador').html(re); });
              window.setTimeout(function(){
              
              
              $('body,html').animate({
                  scrollTop: 0
                  }, 1);

           }, 1);
              if(history.pushState) {
        history.pushState(null, null,"/noticias?id="+idvalor);
        }
      },
      /*******POR CATEGORIA**********************/
      cat:function(cate) 
         {
         categoria=cate
      $.ajax({
                    url:'contenidos/noticias.php',
                    type: "GET",
                    cache:false,
                    data:'categoria='+categoria,
                    dataType: "html"
              }).done(function(re) { $('#cargador').html(re); });

              window.setTimeout(function(){
              
              $('body,html').animate({
                  scrollTop: 0
                  }, 1000);

           }, 1);
      },
/*************************/
      pag:function(pag,ord,lim) 
         {
          $.ajax({
                    url:'contenidos/noticias.php',
                    type: "GET",
                    cache:false,
                    data:'pagina='+pag+'&orden='+ord+'&limit='+lim,
                    dataType: "html"
              }).done(function(re) { $('#cargador').html(re); });

              window.setTimeout(function(){
              
              $('body,html').animate({
                  scrollTop: 0
                  }, 1000);

           }, 1);
      },
      /****BUSCAR*********************/
      buscar:function(busca) 
         {

            $.ajax({
                    url:'contenidos/noticias.php',
                    type: "GET",
                    cache:false,
                    data:'b='+busca,
                    dataType: "html"
              }).done(function(re) { $('#cargador').html(re); });

              window.setTimeout(function(){
              
              $('body,html').animate({
                  scrollTop: 0
                  }, 1000);

           }, 1);
      }

/************************************/
    };
 
    return core;
 
  })();
 
return  window.alex = alex;
 
})(window);
/*******************************/
window.addEventListener('load',function(){
 var audio;
var playlist;
var tracks;
var current;

init();
function init(){
    current = 0;
    audio = $('#audio');
    playlist = $('#playlist');
    tracks = playlist.find('li a');
    len = tracks.length - 1;
    audio[0].volume = .5;
    audio[0].play();
    playlist.find('a').click(function(e){
        e.preventDefault();
        link = $(this);
        current = link.parent().index();
        run(link, audio[0]);
    });
    audio[0].addEventListener('ended',function(e){
        current++;
        if(current == len){
            current = 0;
            link = playlist.find('a')[0];
        }else{
            link = playlist.find('a')[current];    
        }
        run($(link),audio[0]);
    });
}
function run(link, player){
        player.src = link.attr('href');
        par = link.parent();
        par.addClass('active').siblings().removeClass('active');
        audio[0].load();
        audio[0].play();
} });
/*******************/

