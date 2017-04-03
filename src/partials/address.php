<?php
/**
* A partial to display the address.
*/
?>
<div itemscope="" itemtype="http://schema.org/LocalBusiness">
    <div class="carawebs-address" itemprop="address" itemscope="" itemtype="http://schema.org/PostalAddress">
        <?php
        echo !empty($data['company']) ? "<span class='business-name' itemprop='name'>{$data['company']}</span>" : NULL;
        echo !empty($data['line_1']) ? "<span class='street-address' itemprop='streetAddress'>{$data['line_1']}</span><br>" : NULL;
        echo !empty($data['line_2']) ? "<span class='street-address' itemprop='streetAddress'>{$data['line_2']}</span><br>" : NULL;
        echo !empty($data['town']) ? "<span class='town' itemprop='addressLocality'>{$data['town']}</span><br>" : NULL;
        echo !empty($data['county']) ? "<span class='county' itemprop='addressLocality'>{$data['county']}</span><br>" : NULL;
        echo !empty($data['postcode']) ? "<span class='postcode' itemprop='postalCode'>{$data['postcode']}</span><br>" : NULL;
        echo !empty($data['country']) ? "<span class='country' itemprop='addressCountry'>{$data['country']}</span><br>" : NULL;
        ?>
    </div>
    <?php if(!empty($data['physical_location'])): ?>
        <span itemprop="geo" itemscope itemtype="http://schema.org/GeoCoordinates">
            <meta itemprop="latitude" content="<?= ${data['physical_location']['latitude']}; ?>" />
            <meta itemprop="longitude" content="<?= ${data['physical_location']['latitude']}; ?>" />
        </span>
    <?php endif; ?>
</div>
