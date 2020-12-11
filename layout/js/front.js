/* place holder focus none in login form */
$(function(){
    
    //switch between login and signup
 $('.loginPage h1 span').click(function(){
    $(this).addClass('selected').siblings().removeClass('selected');
    $('.loginPage form').hide();
    $('.' + $(this).data('class')).fadeIn(100);
    });
    
    $('[placeholder]').focus(function(){
        
       $(this).attr('data-text',$(this).attr('placeholder'));
       $(this).attr('placeholder',"");
    });
    /* place holder blur none in login form */
    $('[placeholder]').blur(function(){
       $(this).attr('placeholder',$(this).attr('data-text'));
    });
    // live writing item
    $('.livename').keyup(function(){
     $('.livepreview  h3').text($(this).val());      
    });
     $('.liveDesc').keyup(function(){
     $('.livepreview .caption p').text($(this).val());      
    });
      $('.liveprice').keyup(function(){
     $('.livepreview span').text($(this).val());      
    });
      $('.liveimage').keyup(function(){
     $('.livepreview img').text($(this).val());      
    });
});