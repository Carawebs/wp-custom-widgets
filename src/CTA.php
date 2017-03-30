<?php
namespace Carawebs\Widgets;
use Carawebs\Display;

class CTA extends \WP_Widget {

    /**
    * Sets up the widgets name etc
    */
    public function __construct() {

        $widget_ops = array(
            'classname' => 'call-to-action',
            'description' => 'Call to Action',
        );
        parent::__construct( 'call-to-action', 'Carawebs Call to Action', $widget_ops );

    }

    /**
    * Outputs the content of the widget
    *
    * @param array $args
    * @param array $instance
    */
    public function widget( $widget_args, $instance ) {

        $types = $instance['type'];
        $button_classes = ['btn-secondary'];
        $display = $instance['display'] ?? 'buttons';
        $include = $this->include_data($types, $instance);

        $title = ! empty( $instance['title'] )
        ? '<h3>' . apply_filters( 'widget_title', $instance['title'] ) . '</h3>'
        : NULL;

        $args = [
            'btn_classes' => $button_classes,
            'include'     => $include
        ];

        echo $widget_args['before_widget'];
        echo $title;
        echo ! empty( $instance['intro'] ) ? "<p>{$instance['intro']}</p>" : NULL;

        if ( 'buttons' === $display ) {
            Display\ControllableCTA::buttons( $args );
        } elseif ( 'list' === $display ) {
            Display\ControllableCTA::list( $args );
        }

        echo $widget_args['after_widget'];

    }

    /**
     * Return an array of content methods to be added to the required output.
     * @see `Carawebs\Display\ControllableCTA.php` for an explanation of
     * the necessary array structure.
     *
     * @param array $types
     * @param array $instance
     */
    public function include_data($types, $instance) {

        $include = [];
        foreach ($types as $type) {
            $include[$this->classname( $type )] = $this->text_values( $type, $instance );
        }

        return $include;

    }

    /**
    * Set text values for different types of contact methods.
    *
    * Return example: `['text' => 'Call Office', 'prefix' => 'Office: ']`.
    *
    * @param  string $type 'landline'|'mobile'|'email'
    * @param  array  $instance
    * @return array        The prefix (desktop) and text (mobile) values to be used in element
    */
    public function text_values( $type, $instance ) {

        $desktop_text = $instance[$type . '_text_desktop'] ?? NULL;
        $mobile_text = $instance[$type . '_text_mobile'] ?? NULL;

        return [
            'desktop_text' => $instance[$type . '_text_desktop'] ?? NULL,
            'mobile_text' => $instance[$type . '_text_mobile'] ?? NULL
        ];

    }

    /**
    * Classnames for the methods to build contact elements.
    *
    * @param  string $type   'landline'|'mobile'|'email'
    * @return string         The classname
    */
    public function classname( $type ) {

        if ( $type == 'landline' ) {
            return 'ClickLandline';
        }
        if ( $type == 'mobile' ) {
            return 'ClickMobile';
        }
        if ( $type == 'email' ) {
            return 'EmailLink';
        }

    }

    /**
    * Outputs the options form on widget admin
    *
    * @param array $instance The widget options
    */
    public function form( $instance ) {

        $title = ! empty( $instance['title'] )   ? esc_attr( $instance['title'] ) : NULL;
        $intro = ! empty( $instance['intro'] )   ? esc_attr( $instance['intro'] ) : NULL;
        $type = ! empty( $instance['type'] )    ? $instance['type'] : [];
        $landline_text_desktop = ! empty( $instance['landline_text_desktop'] ) ? esc_attr( $instance['landline_text_desktop'] ) : NULL;
        $landline_text_mobile = ! empty( $instance['landline_text_mobile'] ) ? esc_attr( $instance['landline_text_mobile'] ) : NULL;
        $mobile_text_desktop = ! empty( $instance['mobile_text_desktop'] )   ? esc_attr( $instance['mobile_text_desktop'] ) : NULL;
        $mobile_text_mobile = ! empty( $instance['mobile_text_mobile'] )   ? esc_attr( $instance['mobile_text_mobile'] ) : NULL;
        $email_text_desktop = ! empty( $instance['email_text_desktop'] )    ? esc_attr( $instance['email_text_desktop'] ) : NULL;
        $email_text_mobile = ! empty( $instance['email_text_mobile'] )    ? esc_attr( $instance['email_text_mobile'] ) : NULL;
        $display = ! empty( $instance['display'] ) ? $instance['display'] : NULL;
        $options = ['landline', 'mobile', 'email'];

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
        <p>Select the type of Call to Action:</p>
        <p>
            <?php

            foreach ($options as $option) {

                $selected = in_array( $option, $type ) ? ' checked' : NULL;

                ?>
                <label>
                    <input type="checkbox"
                    name="<?php echo $this->get_field_name( 'type' ); ?>[]"
                    id="<?= $this->get_field_id('type'); ?>"
                    class="widefat"
                    value="<?= $option; ?>"
                    <?= $selected; ?>
                    >
                    <?= $option; ?>
                </label><br>
                <?php

            }
            ?>
        </select>
    </p>
    <p>Override the Text:</p>
    <p>
        <?php

        foreach ($options as $option) {

            $fieldname = $option . '_text';

            ?>
            <label>
                Set the <b>desktop</b> text for <?= $option; ?>:
                <input type="text" name="<?= $this->get_field_name( $fieldname . '_desktop' ); ?>" value="<?= ${$option . '_text_desktop'}; ?>" />
            </label><br>
            <label>
                Set the <b>mobile</b> text for <?= $option; ?>:
                <input type="text" name="<?= $this->get_field_name( $fieldname . '_mobile' ); ?>" value="<?= ${$option . '_text_mobile'}; ?>" />
            </label>
            <hr>

            <?php

        }
        ?>
    </select>
</p>
<fieldset>
    <legend>Display method</legend>
    <p>
        <input
        type="radio" name="<?= $this->get_field_name( 'display' ); ?>"
        id="<?= $this->get_field_id('display'); ?>-buttons"
        value="buttons"
        <?php checked( $display, 'buttons', true ); ?> />
        <label for="<?= $this->get_field_id('display'); ?>-buttons">Buttons</label>
    </p>
    <p>
        <input
        type="radio"
        name="<?= $this->get_field_name( 'display' ); ?>"
        id="<?= $this->get_field_id('display'); ?>-list"
        value="list"
        <?php checked( $display, 'list', true ); ?> />
        <label for="<?= $this->get_field_id('display'); ?>-list">List</label>
    </p>
</fieldset>
<?php wp_nonce_field('nonce', 'cta_nonce');

}

/**
* Process widget options on save
*
* @param array $new_instance The new options
* @param array $old_instance The previous options
*/
public function update( $new_instance, $old_instance ) {

    $formNonce = $_POST['cta_nonce'];

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
    $instance['display'] = strip_tags( $new_instance['display'] );
    $instance['landline_text_desktop'] = strip_tags( $new_instance['landline_text_desktop'] );
    $instance['landline_text_mobile'] = strip_tags( $new_instance['landline_text_mobile'] );
    $instance['mobile_text_desktop'] = strip_tags( $new_instance['mobile_text_desktop'] );
    $instance['mobile_text_mobile'] = strip_tags( $new_instance['mobile_text_mobile'] );
    $instance['email_text_desktop'] = strip_tags( $new_instance['email_text_desktop'] );
    $instance['email_text_mobile'] = strip_tags( $new_instance['email_text_mobile'] );
    $instance['type'] = [];

    if ( isset ( $new_instance['type'] ) ) {

        foreach ( $new_instance['type'] as $value ) {

            if ( '' !== trim( $value ) )
            $instance['type'][] = $value;

        }

    }

    return $instance;

    }

}
