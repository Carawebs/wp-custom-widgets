<?php
/**
* A partial to display the Company Numbers.
*/
?>
<div class="company-details">
    <?php
    echo !empty($data['company_number']) ? "<span class='company-number' itemprop='name'>Company Number: {$data['company_number']}</span><br>" : NULL;
    echo !empty($data['VAT_number']) ? "<span class='VAT-number' itemprop='name'>VAT Number: {$data['VAT_number']}</span><br>" : NULL;
    echo !empty($data['company_number']) ? "<div class='company-descriptor' itemprop='name'>{$data['company_descriptor']}</div>" : NULL;
    ?>
</div>
