<?php

function memoriam_image_uploader() {
	$image_ids = get_option( 'candle_images' );
	?>
    <label> <span class='customize-control-title'>Candle Images</span> </label>
    <div>
        <ul class='candle-images'></ul>
    </div>
    <div class='actions'>
        <a class="button-secondary upload" style="margin-top: 10px;">Select Images</a>
    </div>

    <input name="candle_images" id="images-input" type="hidden" value="<?php echo $image_ids ?>">
<?php }