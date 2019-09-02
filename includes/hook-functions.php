<?php

defined( 'ABSPATH' ) || exit;


function memoriam_admin_styles() { ?>
    <style>
        .candle-images {
            display: flex;
            flex-wrap: wrap;
        }

        .image-list {
            width: 150px;
            margin: 5px 0 0 5px;
            height: 150px;
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            -webkit-box-shadow: inset 0 0 15px rgba(0, 0, 0, .1), inset 0 0 0 1px rgba(0, 0, 0, .05);
            box-shadow: inset 0 0 15px rgba(0, 0, 0, .1), inset 0 0 0 1px rgba(0, 0, 0, .05);
            background: #eee;
            cursor: pointer;
            vertical-align: middle;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            position: relative;
            margin-bottom: 0;
        }

        .image-list:before {
            content: 'x';
            color: red;
            font-size: 50px;
            background: rgba(1, 1, 1, .4);
            align-items: center;
            justify-content: center;
            position: absolute;
            display: none;
            top: 0;
            right: 0;
            left: 0;
            bottom: 0;
            box-shadow: inset 0 0 0 1px #fff, inset 0 0 0 3px red;
        }

        .image-list:hover:before {
            display: flex;
        }
    </style>
<?php }

add_action( 'admin_print_styles', 'memoriam_admin_styles' );

function memoriam_admin_scripts() { ?>
    <script>
        (function ($) {

            $(window).load(function () {

				<?php

				$image_ids = array_filter( (array) explode( ',', get_option( 'candle_images' ) ) );
				foreach ($image_ids as $image_id){
				?>

                $(".candle-images").append("<li class='image-list'><img src='<?php echo wp_get_attachment_image_url( $image_id, 'thumbnail' ); ?>' data-id='<?php echo $image_id ?>'></li>");

				<?php } ?>


                $(".button-secondary.upload").click(function () {

                    var custom_uploader = wp.media.frames.file_frame = wp.media({
                        multiple: true
                    });

                    custom_uploader.on('select', function () {
                        var selection = custom_uploader.state().get('selection');
                        var attachments = [];
                        selection.map(function (attachment) {
                            attachment = attachment.toJSON();
                            $(".candle-images").append("<li class='image-list'><img src='" + attachment.url + "'></li>");
                            attachments.push(attachment.id);
                        });

                        var attachment_string = attachments.join() + "," + $('#images-input').val();
                        $('#images-input').val(attachment_string).trigger('change');

                    });

                    custom_uploader.open();

                });

                $(".candle-images").click(function () {
                    var img_id = $(event.target).find("img").data('id');
                    $(event.target).closest("li").remove();
                    var attachment_string = $('#images-input').val();
                    attachment_string = attachment_string.replace(img_id + ",", "");
                    $('#images-input').val(attachment_string).trigger('change');
                });
            });

        })(jQuery);
    </script>
<?php }

add_action( 'admin_print_footer_scripts', 'memoriam_admin_scripts' );

function memoriam_save_settings() {
	if ( empty( $_REQUEST['candle_images'] ) ) {
		return;
	}

	update_option( 'candle_images', sanitize_text_field( $_REQUEST['candle_images'] ) );
}

add_action( 'admin_init', 'memoriam_save_settings' );

function submission_extra_fields() { ?>
    <label for="candle_image">Candle Image:</label><br/><select name="candle_image" id="candle_image">
		<?php
		$candle_images = array_filter( (array) explode( ',', get_option( 'candle_images' ) ) );

		if ( ! empty( $candle_images ) ) {
			$selected = true;
			foreach ( $candle_images as $image_id ) {
				$image = get_post( $image_id );
				if ( ! empty( $image ) ) {
					printf( '<option value="%1$s" data-imagesrc="%2$s" %3$s>%4$s</option>',
						$image->ID, wp_get_attachment_image_url( $image->ID, 'candle_select' ), $selected ? 'selected' : '', $image->post_title );
				}
				$selected = false;
			}
		}

		?>

    </select> <br><br>

<?php }

add_action( 'candle_extra_fields', 'submission_extra_fields' );

add_action( 'wp_print_footer_scripts', function () { ?>
    <style>
        .dd-options {
            margin: 0px !important;
            list-style: none !important;
            padding: 0px !important;
            background: #000 !important;
        }

        .dd-option-text, .dd-selected-text {
            line-height: 1.5 !important;
        }

        .dd-option-selected {
            background: #000 !important;
        }

        .dd-option:hover {
            background: #000 !important;
        }
    </style>
    <script>
        (function ($) {
            $("#candle_image").ddslick({
                background: 'transparent',
                onSelected: function (data) {
                    $('.dd-selected-value').attr('name', 'candle_image');
                }
            });
        })(jQuery);
    </script>
	<?php
} );