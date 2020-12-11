/* place holder focus none in login form */
$(function(){
    
    
    //dashboard icon plus
    $('.plus').click(function(){
        $(this).toggleClass('selected').parent().next('.panel-body').fadeToggle(100);
       if($(this).hasClass('selected')){
        $(this).html('<i class="fa fa-minus"></i>');
       }else{
        $(this).html('<i class="fa fa-plus"></i>');
        }
        });
    $('[placeholder]').focus(function(){
        
       $(this).attr('data-text',$(this).attr('placeholder'));
       $(this).attr('placeholder',"");
    });
    /* place holder blur none in login form */
    $('[placeholder]').blur(function(){
       $(this).attr('placeholder',$(this).attr('data-text'));
    });
    /******************** add asterisk in required input ***********/
    $("input").each(function(){
       if($(this).attr('required')=='required'){
        $(this).after('<span class="astersik">*</span>');
        
       }
    });
    /***** password show with icon eye ****/
    $('.showpass').hover(function(){
        $('.password').attr('type','text');
        
    },function(){
          $('.password').attr('type','password');
    });
    /*** confirm deleting**/
    $('.confirm').on("click",function(){
        
        return confirm('are you sure delete user');
    });
    // category view
    $('.cat h3').click(function(){
       $(this).next('.full-view').fadeToggle(200); 
    });
    $('.option span').click(function(){
        $(this).addClass('active').siblings('span').removeClass('active');
        if($(this).data('view')==='full'){
            $('.full-view').fadeIn(200);
        }else{
             $(' .full-view').fadeOut(200);
        }
    });
    $('.childcat').hover(function(){
        $(this).find('.showdelete').fadeIn(500);
    },function(){
        $(this).find('.showdelete').fadeOut(200);
    });
    
});