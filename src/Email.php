<?php
namespace Carawebs\Widgets;

use Carawebs\Widgets\Controllers;
/**
* Register an email widget
*
* A widget that displays the email set in the options table.
*
* @link       http://dev-notes.eu
* @since      1.0.0
*
*/
class Email extends \WP_Widget {

    /**
    * Sets up the widgets name etc
    */
    public function __construct(Controllers\Contact $data) {
        $this->data = $data;
        parent::__construct(
            'email_widget',                                     // Base ID
            __( 'Carawebs Email', 'address' ),                  // Name
            ['description' => __( 'Output an email link', 'address' )] // Args
        );
    }

    /**
    * Outputs the content of the widget
    *
    * @param array $args Widget arguments
    * @param array $instance Saved Values from Database
    */
    public function widget( $args, $instance )
    {
        $defaultEmail = $this->data->getAddress()['email'];
        $defaultEmail = antispambot($defaultEmail);
        echo $args['before_widget'];
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
        }

        ob_start();
        ?>
        <p>
            <?= $instance['intro'] ?? NULL; ?>
            <a href='mailto:<?= $defaultEmail; ?>'><?= $defaultEmail; ?></a>
        </p>
        <?php
        echo ob_get_clean();
        echo $args['after_widget'];
    }

    /**
    * Outputs the options form on admin.
    *
    * @param array $instance The widget options
    */
    public function form( $instance )
    {
        // outputs the options form on admin
        $title = ! empty( $instance['title'] ) ? $instance['title'] : NULL;
        $intro = ! empty( $instance['intro'] ) ? $instance['intro'] : NULL;
        ?>
        <p>
            This widget outputs a properly formatted email link.
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Optional Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'intro' ); ?>"><?php _e( 'Optional Intro text:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'intro' ); ?>" name="<?php echo $this->get_field_name( 'intro' ); ?>" type="text" value="<?php echo esc_attr( $intro ); ?>">
        </p>
        <?php
    }

    /**
    * Processing widget options on save
    *
    * @param array $new_instance The new options
    * @param array $old_instance The previous options
    */
    public function update( $new_instance, $old_instance )
    {
        // processes widget options to be saved
        $instance = [];
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['intro'] = ( ! empty( $new_instance['intro'] ) ) ? strip_tags( $new_instance['intro'] ) : '';
        return $instance;
    }
}
