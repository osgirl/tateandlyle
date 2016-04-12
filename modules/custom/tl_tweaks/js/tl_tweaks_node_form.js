/**
 * @file
 * Removes delete option from translation pages.
 */

(function ($) {
  Drupal.behaviors.tl_tweaks_node_form = {
    attach: function (context, settings) {
      $(document).ready(function() {
		$( "#block-seven-content .dropbutton-wrapper" ).each(function( index ) {
          if ($( this ).attr( "class" ) == "dropbutton-wrapper dropbutton-multiple") {
  		    $( this ).addClass( "dropbutton-single" );
		    $( this ).removeClass( "dropbutton-multiple" );
            $( this ).find( ".dropbutton-toggle" ).remove();
            $( this ).find( ".secondary-action" ).remove();
          }
        });
      });
    }
  };

})(jQuery);
