/* global everest_forms_admin, PerfectScrollbar */
( function( $, params ) {

	// Colorpicker.
	$( '.colorpicker' ).wpColorPicker();

	// Enable Perfect Scrollbar.
	$( document ).on( 'init_perfect_scrollbar', function() {
		var nav_wrapper = $( 'nav.evf-nav-tab-wrapper' );

		if ( nav_wrapper.length >= 1 ) {
			window.evf_nav_ps = new PerfectScrollbar( nav_wrapper.selector, {
				suppressScrollY : true,
				useBothWheelAxes: true,
				wheelPropagation: true
			});
		}
	});

	// Update Perfect Scrollbar.
	$( window ).on( 'resize orientationchange', function() {
		var resizeTimer,
			nav_wrapper = $( 'nav.evf-nav-tab-wrapper' );

		if ( nav_wrapper.length >= 1 ) {
			clearTimeout( resizeTimer );
			resizeTimer = setTimeout( function() {
				window.evf_nav_ps.update();
			}, 250 );
		}
	});

	// Trigger Perfect Scrollbar.
	$( document ).ready( function( $ ) {
		if ( 'undefined' !== typeof PerfectScrollbar ) {
			$( document ).trigger( 'init_perfect_scrollbar' );
		}
	});

	// Field validation error tips.
	$( document.body )

		.on( 'evf_add_error_tip', function( e, element, error_type, locale ) {
			var offset = element.position();

			if ( element.parent().find( '.evf_error_tip' ).length === 0 ) {
				element.after( '<div class="evf_error_tip ' + error_type + '">' + locale[error_type] + '</div>' );
				element.parent().find( '.evf_error_tip' )
					.css( 'left', offset.left + element.width() - ( element.width() / 2 ) - ( $( '.evf_error_tip' ).width() / 2 ) )
					.css( 'top', offset.top + element.height() )
					.fadeIn( '100' );
			}
		})

		.on( 'evf_remove_error_tip', function( e, element, error_type ) {
			element.parent().find( '.evf_error_tip.' + error_type ).fadeOut( '100', function() { $( this ).remove(); } );
		})

		.on( 'click', 'input:not([type=number])', function() {
			$( '.evf_error_tip' ).fadeOut( '100', function() { $( this ).remove(); } );
		})

		.on( 'blur', '.evf-input-meta-key[type=text], .evf-input-number[type=number]', function() {
			$( '.evf_error_tip' ).fadeOut( '100', function() { $( this ).remove(); } );
		})

		.on( 'change', '.evf-input-meta-key[type=text], .evf-input-number[type=number]', function() {
			var regex;

			if ( $( this ).is( '.evf-input-number' ) ) {
				regex = new RegExp( '[^-0-9]+', 'gi' );
			} else {
				regex = new RegExp( '[^a-z0-9_]+', 'gi' );
			}

			var value    = $( this ).val();
			var newvalue = value.replace( regex, '' );

			if ( value !== newvalue ) {
				$( this ).val( newvalue );
			}
		})

		.on( 'keyup', '.evf-input-meta-key[type=text]', function() {
			var regex, error;

			if ( $( this ).is( '.evf-input-meta-key' ) ) {
				regex = new RegExp( '[^a-z0-9_]+', 'gi' );
				error = 'i18n_field_meta_key_error';
			}

			var value    = $( this ).val();
			var newvalue = value.replace( regex, '' );

			if ( value !== newvalue ) {
				$( document.body ).triggerHandler( 'evf_add_error_tip', [ $( this ), error, params ] );
			} else {
				$( document.body ).triggerHandler( 'evf_remove_error_tip', [ $( this ), error ] );
			}
		})

		.on( 'keyup focus', '.evf-input-number[type=number]', function() {
			var fieldId  = $( this ).parent().data( 'fieldId' );
			var maxField = $( "input#everest-forms-field-option-"+fieldId+"-max_value" );
			var minField = $( "input#everest-forms-field-option-"+fieldId+"-min_value" );
			var maxVal   = maxField.val();
			var minVal   = minField.val();

			if ( 0 !== minVal.length && 0 !== maxVal.length ) {
				if ( parseFloat( minVal ) > parseFloat( maxVal ) ) {
					if( $( this ).attr( 'id' ).indexOf( 'min_value' ) !== -1 ) {
						$( document.body ).triggerHandler( 'evf_add_error_tip', [ $( this ), 'i18n_field_min_value_greater', params ] );
					} else {
						$( document.body ).triggerHandler( 'evf_add_error_tip', [ $( this ), 'i18n_field_max_value_smaller', params ] );
					}
				} else {
					$( document.body ).triggerHandler( 'evf_remove_error_tip', [ $( this ), 'i18n_field_max_value_smaller' ] );
					$( document.body ).triggerHandler( 'evf_remove_error_tip', [ $( this ), 'i18n_field_min_value_greater' ] );
				}
			}
		})

		.on( 'init_tooltips', function() {
			$( '.tips, .help_tip, .everest-forms-help-tip, .everest-forms-help-tooltip' ).tooltipster( {
				maxWidth: 200,
				multiple: true,
				interactive: true,
				position: 'bottom',
				contentAsHTML: true,
				updateAnimation: false,
				restoration: 'current',
				functionInit: function( instance, helper ) {
					var $origin = $( helper.origin ),
						dataTip = $origin.attr( 'data-tip' );

					if ( dataTip ) {
						instance.content( dataTip );
					}
				}
			} );
		});

		// Dynamic live binding on newly created elements.
		$( 'body' ).on( 'mouseenter', '.evf-content-email-settings-inner .everest-forms-help-tooltip:not(.tooltipstered)', function() {
			$( this ).tooltipster({
				maxWidth: 200,
				multiple: true,
				interactive: true,
				position: 'bottom',
				contentAsHTML: true,
				updateAnimation: false,
				restoration: 'current',
				functionInit: function( instance, helper ) {
					var $origin = $( helper.origin ),
						dataTip = $origin.attr( 'data-tip' );
					if ( dataTip ) {
						instance.content( dataTip );
					}
				}
			});
			$( this ).tooltipster( 'open' );
		});

		$( document ).on('click', '.everest-forms-email-add', function(){
			$( '.evf-content-email-settings-inner .tooltipstered' ).tooltipster( 'destroy' );
		});

	// Tooltips
	$( document.body ).trigger( 'init_tooltips' );
})( jQuery, everest_forms_admin );
