<?php 
if($view == true){
    $readonly = 'readonly';
    $disable = "disabled";
}
?>

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Festival Message<small>Sent</small></h2>
       
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    
                    <p>Dear ,</p>

                    <p>Warm greetings on your special day! May this <strong><?php echo esc($storedData['name']); ?></strong> be filled with joy, blessings, and prosperity.</p>

                    <p>As you celebrate another year of life/devotion, may the divine light guide your path, bringing you happiness, peace, and fulfillment.</p>

                    <p>On behalf of the [Temple Name] community, we extend our heartfelt wishes for a wonderful and joyous celebration. May your day be surrounded by loved ones, laughter, and the divine grace that our temple offers.</p>

                    <p>Wishing you a year ahead filled with auspicious moments and spiritual growth. May your journey be illuminated by the divine presence, and may you continue to inspire those around you with your devotion.</p>

                    <p>Happy <strong><?php echo esc($storedData['name']); ?></strong>!</p>

                    <p>Best regards, Temple Management</p>
                </div>
            </div>
        </div>
    </div>
</section>


