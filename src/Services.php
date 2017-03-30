<?php
namespace Carawebs\Widgets;

use Carawebs\Display;

class Services extends \WP_Widget {

    /**
    * Sets up the widgets name etc
    */
    public function __construct() {

        $widget_ops = array(
            'classname' => 'services-list',
            'description' => 'List of site services',
        );
        parent::__construct( 'services-list', 'Carawebs Services List', $widget_ops );

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

        switch ($instance['type']) {
            case 'blocks':
            ?>
            <div class="service-teasers">
                <?php
                // $services = new \Carawebs\Loops\Services();
                // echo $services->the_services();
                $args = [
                    'post_type'         => 'service',
                    'pagination'        => false,
                    'partial'           => 'widgets/service-teaser',
                    'posts_per_page'    => -1
                ];
                $services = new \Carawebs\Loops\Query;
                echo $services->set_loop_args($args)->custom_loop();
                ?>
            </div>
            <?php
            break;

            default:
            echo Display\Helpers::services_ul();
            break;
        }

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
        $type        = ! empty( $instance['type'] ) ? esc_attr( $instance['type'] ) : null;

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
        <p>Select how you want services to display:</p>
        <p><label for="<?= $this->get_field_id('type'); ?>"><?php _e('Type:'); ?></label></p>
        <p>
            <select name="<?php echo $this->get_field_name('type'); ?>" id="<?php echo $this->get_field_id('type'); ?>" class="widefat">
                <?php
                $options = ['list', 'blocks'];

                foreach ($options as $option) {
                    echo '<option value="' . $option . '" id="' . $option . '"', $type == $option ? ' selected="selected"' : '', '>', $option, '</option>';
                }
                ?>
            </select>
        </p>

        <!-- <?php
        // if($size == 'Full') {
        //      echo '<input type="radio" name="group1" value="small">Small<br />' . "\n";
        //      echo '<input type="radio" name="group1" value="full" checked> Full<br />' . "\n";
        //      //This will out put the radio buttons with Full chosen if the user selected it previously.
        // } else {
        //      echo '<input type="radio" name="group1" value="small" checked>Small<br />' . "\n";
        //      echo '<input type="radio" name="group1" value="full"> Full<br />' . "\n";
        //      //This will out put the radio buttons with Small selected as default/user selected.
        // }
        ?> -->
    </p>
    <?php wp_nonce_field('nonce', 'services_nonce');

}

/**
* Process widget options on save
*
* @param array $new_instance The new options
* @param array $old_instance The previous options
*/
public function update( $new_instance, $old_instance ) {

    $formNonce = $_POST['services_nonce'];

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
    $instance['type'] = strip_tags( $new_instance['type'] );

    return $instance;

}

}
