<?php
namespace Carawebs\Widgets;

use Carawebs\Display;
use Carawebs\Fetch;

class Social extends \WP_Widget {

    /**
    * Sets up the widgets name etc
    */
    public function __construct(Controllers\Contact $data) {
        $this->data = $data;
        parent::__construct(
            'social_follow',
            __( 'Carawebs Social Follow', 'carawebs-widgets' ),
            ['description' => __( 'Social Media Links', 'carawebs-widgets' )]
        );
    }

    private function availableChannels()
    {
        $channels = $this->data->getSocialDetails();
        $availableChannels = [];
        foreach ($channels as $key => $value) {
            if(empty($value)) continue;
            $availableChannels[$key] = $value;
        }
        return $availableChannels;
    }

    /**
    * Outputs the content of the widget
    *
    * @param array $args
    * @param array $instance
    */
    public function widget( $args, $instance )
    {
        $data = $this->data->getSocialDetails();
        $include = $instance['included_channels'];
        $channels = [];
        foreach ($data as $key => $value) {
            if(!in_array($key, $include)) continue;
            if ('linkedin' === $key) {
                $key = 'LinkedIn';
            }
            $channels[$key] = $value;
        }
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
        echo $before_widget;
        echo "<h3>{$instance['title']}</h3>";
        echo ! empty( $instance['intro'] ) ? "<p>{$instance['intro']}</p>" : null;
        include dirname(__FILE__).'/partials/social.php';
        echo $args['after_widget'];
        echo $after_widget;
    }

    /**
    * Outputs the options form on widget admin
    *
    * @param array $instance The widget options
    */
    public function form($instance)
    {
        $title = !empty( $instance['title'] ) ? esc_attr( $instance['title'] ) : NULL;
        $intro = !empty( $instance['intro'] ) ? esc_attr( $instance['intro'] ) : NULL;
        $included_channels = isset( $instance['included_channels'] ) ? $instance['included_channels'] : [];
        $available = $this->availableChannels();

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
        <p>Which Social Channels do you want to include?</p>
        <p>
            <?php
            foreach ($available as $key => $value) {
                $selected = in_array($key, $included_channels) ? ' checked' : NULL;
                ?>
                <input id="<?= $key; ?>" type="checkbox" name="<?= $this->get_field_name('included_channels'); ?>[]" value="<?= $key; ?>"<?= $selected;?>>
                <label for="<?= $key; ?>"><?php echo ucfirst($key); ?></label>
                <br>
                <?php
            }
            ?>
        </p>
        <?php wp_nonce_field('nonce', 'social_nonce');
    }

    /**
    * Process widget options on save
    *
    * @param array $new_instance The new options
    * @param array $old_instance The previous options
    */
    public function update($new_instance, $old_instance)
    {

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
        $instance['included_channels'] = [];
        if (isset($new_instance['included_channels'])) {
            foreach ($new_instance['included_channels'] as $value)
            {
                if ( '' !== trim( $value ) )
                    $instance['included_channels'][] = $value;
            }
        }

        return $instance;
    }
}
