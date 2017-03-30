<?php
namespace Carawebs\Widgets;

use Carawebs\Views;

class Mailchimp extends \WP_Widget {

    use Views\PartialSelector;

    /**
    * Sets up the widgets name etc
    */
    public function __construct() {

        // Set the default attributes in the theme by means of an action hook.
        $this->attributes = apply_filters( 'carawebs/mailchimp_defaults', NULL );

        // No default title - this should be controlled by the widget.
        $this->attributes['title'] = NULL;

        $widget_ops = array(
            'classname' => 'mailchimp-signup',
            'description' => 'Mailchimp Signup Form',
        );
        parent::__construct( 'mailchimp-signup', 'Mailchimp Signup Form', $widget_ops );

    }

    /**
    * Outputs the content of the widget
    *
    * @param array $args
    * @param array $instance
    */
    public function widget( $args, $instance ) {

        // outputs the content of the widget
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);

        // $this->attributes = apply_filters( 'carawebs/mailchimp_defaults', NULL);
        // $this->attributes['title'] = NULL;
        $attributes = $this->attributes;

        echo $before_widget;
        echo ! empty( $instance['title'] ) ? "<h3>{$instance['title']}</h3>" : NULL;
        echo ! empty( $instance['intro'] ) ? "<div class='small text-muted'>" . nl2br( $instance['intro'] ) . "</div>" : NULL;
        ob_start();
        include $this->static_partial_selector( 'forms/mailchimp' );
        echo ob_get_clean();
        echo $after_widget;

    }

    /**
    * Outputs the options form on widget admin
    *
    * @param array $instance The widget options
    */
    public function form( $instance ) {

        // outputs the options form on the widget admin page
        $title    = ! empty( $instance['title'] ) ? esc_attr( $instance['title'] ) : NULL;
        $intro    = ! empty( $instance['intro'] ) ? esc_attr( $instance['intro'] ) : NULL;
        $post_to_url = ! empty( $instance['post_to_url'] ) ? esc_attr( $instance['post_to_url'] ) : $this->attributes['post_to_url'];
        ?>
        <p>Enter the widget title here.</p>
        <p>
            <label for="<?= $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?= $this->get_field_id('title'); ?>" name="<?= $this->get_field_name('title'); ?>" type="text" value="<?= $title; ?>" />
        </p>
        <p>Enter introductory text if required.</p>
        <p>
            <label for="<?= $this->get_field_id('intro'); ?>"><?php _e('Intro:'); ?></label>
            <textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id('intro'); ?>" name="<?php echo $this->get_field_name('intro'); ?>"><?php echo $intro; ?></textarea>
        </p>
        <p>Enter a Mailchimp URL if needed.</p>
        <p class="small text-muted">Default: <?= $this->attributes['post_to_url']; ?></p>
        <p>
            <label for="<?= $this->get_field_id('post_to_url'); ?>"><?php _e('Mailchimp URL:'); ?></label>
            <input class="widefat" id="<?= $this->get_field_id('post_to_url'); ?>" name="<?= $this->get_field_name('post_to_url'); ?>" type="text" value="<?= $post_to_url; ?>" />
        </p>
        <?php wp_nonce_field( 'safe_mailchimp_widget', 'mailchimp_nonce' ); // $action, $name

    }

    /**
    * Process widget options on save
    *
    * @param array $new_instance The new options
    * @param array $old_instance The previous options
    */
    public function update( $new_instance, $old_instance ) {

        $formNonce = $_POST['mailchimp_nonce'];

        if ( ! wp_verify_nonce( $formNonce, 'safe_mailchimp_widget' ) ) { // $name, $action

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
        $instance['post_to_url'] = $new_instance['post_to_url'];

        return $instance;

    }

}
