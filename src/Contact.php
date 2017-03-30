<?php

namespace Carawebs\Widgets;

use Carawebs\Display;
use Carawebs\Fetch;

class Contact extends \WP_Widget {

    /**
    * Sets up the widgets name etc
    */
    public function __construct() {

        $widget_ops = array(
            'classname' => 'contact',
            'description' => 'Contact Links',
        );
        parent::__construct( 'contact', 'Carawebs Contact Links', $widget_ops );

    }

    /**
    * Outputs the content of the widget
    *
    * @param array $args
    * @param array $instance
    */
    public function widget( $args, $instance ) {

        $title = ! empty( $instance['title'] ) ? apply_filters('widget_title', $instance['title']) : NULL;
        $additional = [];
        if (! empty( $instance['custom_type']) ) {
            $additional = [
                'type' => $instance['custom_type'],
                'value' => $instance['custom_value'] ?? NULL,
                'label' => $instance['custom_label'] ?? NULL,
                'mobile_label' => $instance['custom_mobile_label'] ?? NULL
            ];
        }

        echo $args['before_widget'];
        echo "<h3>$title</h3>";
        echo ! empty( $instance['intro'] ) ? "<p>{$instance['intro']}</p>" : null;
        echo Display\ContactList::contacts( new Fetch\SiteVariables, $additional );
        echo $args['after_widget'];

    }

    /**
    * Outputs the options form on widget admin
    *
    * @param array $instance The widget options
    */
    public function form( $instance ) {

        // outputs the options form on the widget admin page
        $title  = ! empty( $instance['title'] ) ? esc_attr( $instance['title'] ) : NULL;
        $intro  = ! empty( $instance['intro'] ) ? esc_attr( $instance['intro'] ) : NULL;
        $custom_type = ! empty( $instance['custom_type'] ) ? esc_attr( $instance['custom_type'] ) : NULL;
        $custom_value = ! empty( $instance['custom_value'] ) ? esc_attr( $instance['custom_value'] ) : NULL;
        $custom_label = ! empty( $instance['custom_label'] ) ? esc_attr( $instance['custom_label'] ) : NULL;
        $custom_mobile_label = ! empty( $instance['custom_mobile_label'] ) ? esc_attr( $instance['custom_mobile_label'] ) : NULL;
        $custom_types = [
            'Mobile phone' => 'mobile',
            'Landline phone' => 'landline',
            'Email' => 'email'
        ];
        ?>
        <p>Enter the widget title here.</p>
        <p>
            <label for="<?= $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?= $this->get_field_id('title'); ?>" name="<?= $this->get_field_name('title'); ?>" type="text" value="<?= $title; ?>" />
        </p>
        <p>Enter an introductory sentence if required.</p>
        <p>
            <label for="<?= $this->get_field_id('intro'); ?>"><?php _e('Intro:'); ?></label>
            <input class="widefat" id="<?= $this->get_field_id('intro'); ?>" name="<?= $this->get_field_name('intro'); ?>" type="text" value="<?= $intro; ?>" />
        </p>
        <h2>Custom Contact</h2>
        <p>If you need a custom contact method, add it here:</p>
        <p>
            <?php
            $field = $this->get_field_name('custom_type');
            $i = 0;
            foreach ($custom_types as $key => $value) {
                ?>
                <label for="<?= $field ?>-<?= $i; ?>"><?= $key; ?></label>
                <input type="radio" name="<?= $field; ?>" id="<?= $field; ?>-1" tabindex="<?= $i; ?>" value="<?= $value; ?>" <?php checked( $custom_type, $value ); ?> >
                <?php
            }
            ?>
        </p>
        <p>
            <label for="<?= $this->get_field_id('custom_value'); ?>"><?php _e('Value - email address or phone number:'); ?></label>
            <input class="widefat" id="<?= $this->get_field_id('custom_value'); ?>" name="<?= $this->get_field_name('custom_value'); ?>" type="text" value="<?= $custom_value; ?>" />
        </p>
        <p>
            <label for="<?= $this->get_field_id('custom_label'); ?>"><?php _e('Label: this will be a prefix for a phone number, or link text for an email.'); ?></label>
            <input class="widefat" id="<?= $this->get_field_id('custom_label'); ?>" name="<?= $this->get_field_name('custom_label'); ?>" type="text" value="<?= $custom_label; ?>" />
        </p>
        <p>
            <label for="<?= $this->get_field_id('custom_mobile_label'); ?>"><?php _e('Mobile Label: this will be used as click to call text at mobile screen sizes.'); ?></label>
            <input class="widefat" id="<?= $this->get_field_id('custom_mobile_label'); ?>" name="<?= $this->get_field_name('custom_mobile_label'); ?>" type="text" value="<?= $custom_mobile_label; ?>" />
        </p>
        <?php wp_nonce_field('nonce', 'social_nonce');

    }

    /**
    * Process widget options on save
    *
    * @param array $new_instance The new options
    * @param array $old_instance The previous options
    */
    public function update( $new_instance, $old_instance ) {

        $formNonce = $_POST['social_nonce'];

        if (!wp_verify_nonce($formNonce, 'nonce')) {

            echo json_encode(array(
                'success' => false,
                'message' => __('Nonce was not verified!', 'Carawebs')
            ));
            die;

        }

        // processes widget options to be saved
        $instance = $old_instance;
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['intro'] = strip_tags( $new_instance['intro'] );
        $instance['custom_type'] = strip_tags( $new_instance['custom_type'] );
        $instance['custom_value'] = strip_tags( $new_instance['custom_value'] );
        $instance['custom_label'] = strip_tags( $new_instance['custom_label'] );
        $instance['custom_mobile_label'] = strip_tags( $new_instance['custom_mobile_label'] );

        return $instance;

    }

}
