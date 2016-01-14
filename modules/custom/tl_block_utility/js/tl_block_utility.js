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
 
jQuery(document).ready(function () {

  jQuery(".print a").click(function(){
    javascript:window.print();
    return false;
  });

  jQuery(".contrast a").click(function(){
    jQuery('body').toggleClass('contrast');
    if (getCookie('contrast') == 'true') {
      document.cookie ='contrast=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/'; 
    } else {
      document.cookie ='contrast=true; path=/';  
    }
    return false;
  });

  jQuery(".large-text a").click(function(){
    document.cookie ='medium-text=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/';
    document.cookie ='small-text=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/';  
    document.cookie ='large-text=true; path=/';
	jQuery('body').removeClass( "medium-text" ).addClass( "large-text" );
    return false;
  });

  jQuery(".medium-text a").click(function(){
    document.cookie ='large-text=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/';
    document.cookie ='small-text=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/';
    document.cookie ='medium-text=true; path=/';
	jQuery('body').removeClass( "large-text" ).addClass( "medium-text" );
    return false;
  }); 

  jQuery(".small-text a").click(function(){
    document.cookie ='large-text=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/';
    document.cookie ='medium-text=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/';
	jQuery('body').removeClass( "medium-text large-text" );
    return false;
  });
  
  if (getCookie('contrast') == 'true') {
	jQuery('body').addClass('contrast');
  }
  if (getCookie('large-text') == 'true') {
	jQuery('body').addClass('large-text');
  }
  if (getCookie('medium-text') == 'true') {
	jQuery('body').addClass('medium-text');
  }
  
});
