
/***************************chat box******************************************************************/
function sonido(soundfile) {
 document.getElementById("es").innerHTML=
 "<embed src=\""+soundfile+"\" hidden=\"true\" autostart=\"true\" loop=\"false\" />";
 }
$(document).ready(function() {
   
  /**scroll down**/
window.setInterval(function(){

var scrolltoh = $('.message_box')[0].scrollHeight;
     $(".message_box").animate({ scrollTop: scrolltoh },4000);

 }, 5000);
    // load messages every 1000 milliseconds from server.
    load_data = {'fetch':1};
    window.setInterval(function(){
     $.post('shout.php', load_data,  function(data) {
        $('.message_box').html(data);
        
       
     });
    }, 1000);
    
    //method to trigger when user hits enter key
    $("#shout_message").keypress(function(evt) {

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
                    sonido("sonido/codec.mp3")
                    evt.stopPropagation();
                }).fail(function(err) { 
                
                //alert HTTP server error
                alert(err.statusText); 
                });
            }
    });
    
    //toggle hide/show shout box
    $(".close_btn").click(function (e) {
        e.stopPropagation();
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
});

/***************************************/
$(document).ready(function(){
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
             window.location="administrador.php";
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
});
