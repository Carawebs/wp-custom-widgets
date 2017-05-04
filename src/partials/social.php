<?php
/**
* A partial to display the address.
*/
?>
<ul class="carawebs-social">
    <?php
    foreach ($channels as $key => $value) {
        $socialLinkText = apply_filters('carawebs/wp-custom-widgets/social-link-text-' . $key, $instance['link_text'][$key]);
        echo "<li class='$key'><a href=$value>$socialLinkText</a></li>";
    }
    ?>
</ul>
