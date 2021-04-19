window.$ = window.$ || jQuery;
export const { domReady } = wp;
domReady( () => {
	// Gateway select change event
	$( '.hide_class' ).hide();
	$( '#gravityforms_sms_settings\\[sms_gateway\\]' ).on( 'change', function() {
		const self = $( this );
		const value = self.val();
		$( '.hide_class' ).hide();
		$( '.' + value + '_wrapper' ).fadeIn();
	} );
	// Trigger when a change occurs in gateway select box
	$( '#gravityforms_sms_settings\\[sms_gateway\\]' ).trigger( 'change' );
} );
