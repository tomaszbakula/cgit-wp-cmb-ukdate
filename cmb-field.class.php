<?php

/**
 * Create a UK date field type - designate a field as a UK date using the field
 * type "UK_date"
 */
class CGIT_UK_Date_Field extends CMB_Field {

    public function enqueue_scripts() {

        parent::enqueue_scripts();

        wp_enqueue_style( 'cmb-jquery-ui', trailingslashit( CMB_URL ) . 'css/vendor/jquery-ui/jquery-ui.css', '1.10.3' );

        wp_enqueue_script( 'cmb-datetime', trailingslashit( CMB_URL ) . 'js/field.datetime.js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-datepicker', 'cmb-scripts' ) );

        wp_enqueue_script( 'uk-datepicker', get_template_directory_uri() . '/libs/castlegateit/cgit-wp-cmb-ukdate/js/uk-datepicker.js', array('cmb-datetime'));

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

/**
 * Date picker for UK date and time (seperate fields) box.
 *
 */
class CGIT_UK_Datetime_Timestamp_Field extends CMB_Field {

    public function enqueue_scripts() {

        parent::enqueue_scripts();

        wp_enqueue_style( 'cmb-jquery-ui', trailingslashit( CMB_URL ) . 'css/vendor/jquery-ui/jquery-ui.css', '1.10.3' );

        wp_enqueue_script( 'cmb-timepicker', trailingslashit( CMB_URL ) . 'js/jquery.timePicker.min.js', array( 'jquery', 'cmb-scripts' ) );
        wp_enqueue_script( 'cmb-datetime', trailingslashit( CMB_URL ) . 'js/field.datetime.js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-datepicker', 'cmb-scripts' ) );
        wp_enqueue_script( 'uk-datepicker', get_template_directory_uri() . '/libs/castlegateit/cgit-wp-cmb-ukdate/js/uk-datepicker.js', array('cmb-datetime'));
    }

    public function html() { ?>

        <input <?php $this->id_attr('date'); ?> <?php $this->boolean_attr(); ?> <?php $this->class_attr( 'cmb_text_small cgit_uk_datepicker' ); ?> type="text" <?php $this->name_attr( '[date]' ); ?>  value="<?php echo $this->value ? esc_attr( date( 'd\/m\/Y', $this->value ) ) : '' ?>" />
        <input <?php $this->id_attr('time'); ?> <?php $this->boolean_attr(); ?> <?php $this->class_attr( 'cmb_text_small cmb_timepicker' ); ?> type="text" <?php $this->name_attr( '[time]' ); ?> value="<?php echo $this->value ? esc_attr( date( 'h:i A', $this->value ) ) : '' ?>" />

    <?php }

    public function parse_save_values() {

        // Convert all [date] and [time] values to a unix timestamp.
        // If date is empty, assume delete. If time is empty, assume 00:00.
        foreach( $this->values as $key => &$value ) {
            if ( empty( $value['date'] ) )
                unset( $this->values[$key] );
            else
                // Jigger around the order within the date to ISO order

                $value['date'] = implode('-',array_reverse(explode('/', $value['date'])));

                $value = strtotime( $value['date'] . ' ' . $value['time'] );
        }

        $this->values = array_filter( $this->values );
        sort( $this->values );

        parent::parse_save_values();

    }

}
