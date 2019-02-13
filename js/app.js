$(document).ready(function(){
    $('body').hide()
    $('body').fadeIn(1000)
    if(window.location.pathname){
  var lock=window.location.pathname
    lock =lock.substring(1);
    if(lock!=''){
    $('#cargador').load('contenidos/'+lock+'.php');
    $(document).ready(function(){
     includev('dom/'+lock+'.js')
   });
     $(".n"+lock).addClass('activado');



     window.setTimeout(function(){
        $('body,html').animate({
            scrollTop: 0
            }, 1000);

     }, 1);
      }else{
      $('#cargador').load('contenidos/noticias.php')
      $(document).ready(function(){
     includev('dom/noticias.js')
     

   });
      


     $(".snoticias").addClass('marca')
      }
    }
    
    
});

$(function(){ 
    $("#menu a").on('click',function(e){
        e.preventDefault();
        var $this=$(this);
        var link=$this.attr('href');
        $("#menu a").add('.col').removeClass('marca')
        $($this).add('.s'+link).addClass('marca')
        $('script').remove();
        $('#cargador').load('contenidos/'+link+'.php')
        if(history.pushState) {
        history.pushState(null, null,"/"+link);
        }
        var rutaControlador = 'dom/'+link+'.js';
        $(document).ready(function(){
        includev(rutaControlador)
        window.setTimeout(function(){
        
        $('body,html').animate({
            scrollTop: 0
            }, 10);

     }, 1);
       
    });

    });

});

function via(render)
{     
    $("#menu a").add('.col').removeClass('marca')
    $('.s'+render).addClass('marca')
    $('script').remove();
    $('#cargador').load('contenidos/'+render+'.php')
    var rutaControlador = 'dom/'+render+'.js';
    $(document).ready(function(){
    includev(rutaControlador)

       window.setTimeout(function(){
        
        $('body,html').animate({
            scrollTop: 0
            }, 10);

     }, 1);
     });
      return false;
  }
    /**************chat*****************/
    $(document).ready(function(){
 /**scroll down**/
window.setInterval(function(){

var scrolltoh = $('.message_box')[0].scrollHeight;
     $(".message_box").animate({ scrollTop: scrolltoh },5000);

 }, 5000);
    // load messages every 5000 milliseconds from server.
    load_data = {'fetch':1};
    window.setInterval(function(){
     $.post('shout.php', load_data,  function(data) {
        $('.message_box').html(data);
        
       
     });
    }, 5000);
    
    //method to trigger when user hits enter key
    $("#shout_message").keypress(function(evt) {
        evt.stopPropagation();
        if(evt.which == 13) {
                var iusername = $('#shout_username').val();
                var imessage = $('#shout_message').val();
                post_data = {'username':iusername, 'message':imessage};
                
                //send data to "shout.php" using jQuery $.post()
                $.post('shout.php', post_data, function(data) {
                    
                    //append data into messagebox with jQuery fade effect!
                    $(data).hide().appendTo('.message_box').fadeIn();
    
                    //reset value of message box
                    $('#shout_message').val('');
                    //sonido("sonido/codec.mp3")
                    evt.stopPropagation();
                }).fail(function(err) { 
                
                //alert HTTP server error
                alert(err.statusText); 
                });
            }
    });
    
    //toggle hide/show shout box
    $(".close_btn").click(function (msg) {
        msg.stopPropagation();
        //get CSS display state of .toggle_chat element
        var toggleState = $('.toggle_chat').css('display');
        
        //toggle show/hide chat box
        $('.toggle_chat').slideToggle();
        
        //use toggleState var to change close/open icon image
        if(toggleState == 'block')
        {
            $(".header div").attr('class', 'open_btn');
        }else{
            $(".header div").attr('class', 'close_btn');
        }     
         
    });
    /**/
  });

/********************************/
// (function( context ){
//   var globals = { viewGlobals : true },
//       startGlobals = [],
//       newGlobals = [];
 
//   for (var j in window) {
//     globals[j] = true;
//     startGlobals.push(j);
//   }
 
//   setInterval(function() {
//     for ( var j in window ) {
//       if ( !globals[j] ) {
//         globals[j] = true;
//         newGlobals.push(j);
//         console.warn( 'New Global: ' + j + ' = ' + window[j] + '. Typeof: ' + (typeof window[j]) );
//       }
//     }
//   }, 1000);
 
//   context.viewGlobals = function(){
//     console.groupCollapsed( 'View globals' );
//       console.groupCollapsed( 'Initial globals' );
//         console.log( startGlobals.sort().join( ",\n" ) );
//       console.groupEnd();
//       console.groupCollapsed( 'New globals' );
//         console.warn( newGlobals.sort().join( ",\n" ) );
//       console.groupEnd();
//     console.groupEnd();
//   };
 
// })(this);


$(document).ready(function(){
  $("#IrArriba").hide();
$(window).scroll(function () {
if ($(this).scrollTop() > 200) {
$('#IrArriba').fadeIn();
} else {
$('#IrArriba').fadeOut();
}
});
$('#IrArriba a').click(function () {
$('body,html').animate({
scrollTop: 0
}, 1000);
return false;
});

});