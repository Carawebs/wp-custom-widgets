<?php
namespace Carawebs\Widgets;

use Carawebs\Display;
use Carawebs\Fetch;

class Social extends \WP_Widget {

    /**
    * Sets up the widgets name etc
    */
    public function __construct() {

        $widget_ops = array(
            'classname' => 'social-follow',
            'description' => 'Social Media',
        );
        parent::__construct( 'social-follow', 'Carawebs Social Follow', $widget_ops );

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

        echo $before_widget;
        echo "<h3>{$instance['title']}</h3>";
        echo ! empty( $instance['intro'] ) ? "<p>{$instance['intro']}</p>" : null;
        $social = new Display\SocialFollow( new Fetch\SiteVariables );
        $social->links_ul();
        echo $after_widget;
        
    }

    /**
    * Outputs the options form on widget admin
    *
    * @param array $instance The widget options
    */
    public function form( $instance ) {

        // outputs the options form on the widget admin page
        $title    = ! empty( $instance['title'] ) ? esc_attr( $instance['title'] ) : null;
        $intro    = ! empty( $instance['intro'] ) ? esc_attr( $instance['intro'] ) : null;

        ?>
        <p>Enter the widget title here.</p>
        <p>
            <label for="<?= $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?= $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <p>Enter an introductory sentence if required.</p>
        <p>
            <label for="<?= $this->get_field_id('intro'); ?>"><?php _e('Intro:'); ?></label>
            <input class="widefat" id="<?= $this->get_field_id('intro'); ?>" name="<?php echo $this->get_field_name('intro'); ?>" type="text" value="<?php echo $intro; ?>" />
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

        return $instance;

    }

}
