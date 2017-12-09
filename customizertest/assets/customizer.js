
( function( $ ) {

  wp.customize( 'background_color', function( value ) {
		value.bind( function( newval ) {
			$( 'body' ).css( 'background-color', newval );
		} );
	} );

  wp.customize( 'blogname', function( value ) {
    value.bind( function( newval ) {
      $( '#intro h1' ).html( newval );
    } );
  } );

  wp.customize( 'blogdescription', function( value ) {
    value.bind( function( newval ) {
      $( '#intro h2' ).html( newval );
    } );
  } );

} )( jQuery );
