/**
 * @file
 * Attaches several functionalities to the utility block.
 */

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
    }
    return "";
}
 
(function ($) {
  Drupal.behaviors.tl_block_utility = {
    attach: function (context, settings) {

      $(".print a").click(function(){
        javascript:window.print();
        return false;
      });

      $(".contrast a").click(function(){
        $('body').toggleClass('contrast');
        if (getCookie('contrast') == 'true') {
          document.cookie ='contrast=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/'; 
        } else {
          document.cookie ='contrast=true; path=/';  
        }
        return false;
      });

      $(".large-text a").click(function(){
        document.cookie ='medium-text=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/';
        document.cookie ='small-text=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/';  
        document.cookie ='large-text=true; path=/';
        $('body').removeClass( "medium-text" ).addClass( "large-text" );
        return false;
      });

      $(".medium-text a").click(function(){
        document.cookie ='large-text=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/';
        document.cookie ='small-text=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/';
        document.cookie ='medium-text=true; path=/';
        $('body').removeClass( "large-text" ).addClass( "medium-text" );
        return false;
      }); 

      $(".small-text a").click(function(){
        document.cookie ='large-text=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/';
        document.cookie ='medium-text=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/';
	    $('body').removeClass( "medium-text large-text" );
        return false;
      });
  
      if (getCookie('contrast') == 'true') {
        $('body').addClass('contrast');
      }
      if (getCookie('large-text') == 'true') {
	    $('body').addClass('large-text');
      }
      if (getCookie('medium-text') == 'true') {
	    $('body').addClass('medium-text');
      } 
    }
  }
})(jQuery);