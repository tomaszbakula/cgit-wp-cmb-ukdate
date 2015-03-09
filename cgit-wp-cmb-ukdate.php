<?php

/*

Plugin Name: Castlegate IT WP CMB UK date
Description: UK custom date field for Custom Meta Boxes
Version: 1.0
Author: Richard Lane, Castlegate IT
Author URI: http://www.castlegateit.co.uk/
License: MIT

*/


/**
 * Create a UK date field type - designate a field as a UK date using the field type "UK_date"
 */
class CGIT_UK_Date_Field extends CMB_Field {

    public function enqueue_scripts() {

        parent::enqueue_scripts();

        wp_enqueue_style( 'cmb-jquery-ui', trailingslashit( CMB_URL ) . 'css/vendor/jquery-ui/jquery-ui.css', '1.10.3' );

        wp_enqueue_script( 'cmb-datetime', trailingslashit( CMB_URL ) . 'js/field.datetime.js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-datepicker', 'cmb-scripts' ) );

        wp_enqueue_script( 'uk-datepicker', plugins_url('/js/uk-datepicker.js', __FILE__), array('cmb-datetime'));

    }

    public function html() { ?>

        <input <?php $this->id_attr(); ?> <?php $this->boolean_attr(); ?> <?php $this->class_attr( 'cmb_text_small cgit_uk_datepicker' ); ?> type="text" <?php $this->name_attr(); ?>  value="<?php echo $this->value ? esc_attr( date( 'd\/m\/Y', $this->value ) ) : '' ?>" />

    <?php }

    public function parse_save_values() {

        foreach( $this->values as &$value )
            $value = strtotime(implode('-',array_reverse(explode('/', $value))));


        sort( $this->values );

    }
}

add_filter( 'cmb_field_types', function( $cmb_field_types ) {
    $cmb_field_types['UK_date'] = 'CGIT_UK_Date_Field';
    return $cmb_field_types;
} );
