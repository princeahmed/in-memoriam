<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

	<head>
		<title><?php echo sprintf('Candle Posted | ' . get_option('blogname')); ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

		<style type="text/css">

			body {
				font-family: Georgia, Tahoma, Arial, sans-serif;
				font-size: 13px;
				color: #666666;
				background: #E2DFD9;
			}

			h1 {
				font-size: 32px;
				text-align: center;
				font-style: italic;
				padding: 14px 0;
				color: #3a383d;
			}

			h2 {
				color: #3a383d;
				margin-bottom: -10px;
				padding-bottom: 0;
			}

			p {
				padding: 9px 0;
				line-height: 18px;
				font-size: 14px;
			}

			.excerpt p {
					padding: 4px 0;
			}

			p.button-parent {
					padding: 25px 0;
			}

			a, a:visited {
				color: #999999;
				text-decoration: none;
			}

			a.button {
				color: #ffffff;
				font-size: 14px;
				padding: 15px 20px;
				width: 125px;
				height: 45px;
				text-align: center;
				background: #9c8e71;
				border-radius: 5px;
				-webkit-border-radius: 5px;
				-o-border-radius: 5px;
				-moz-border-radius: 5px;
				transition: all 0.4s ease-in-out 0s;
			}

			a.button:hover {
				background: #af9a6f;
			}

			img {
				display: block;
			}

		</style>

	</head>

	<body>

		<table width="600" align="center" cellpadding="0" cellspacing="0">

			<tr id="content">
				<td colspan="100" valign="top" align="center" background="#ffffff" style="background:#ffffff">

					<table width="90%" align="center">
						<tr>
							<td align="left" valign="top">

								<h1>A Prayer Request</h1>

								<p>
                  Someone has made a request for prayers and lit a virtual
                  candle at the web site <?php get_bloginfo('name'); ?>
								</p>
                <p>
                  <?php echo home_url(); ?>
                </p>

								<div class="excerpt">
									<?php echo apply_filters( 'the_excerpt', $candle->post_content ); ?>
								</div>

								<p>
                  <?php echo $_POST['candle_prayer_name']; ?> asked that you be notified.
                </p>

								<p class="button-parent">
									<a href="<?php echo get_permalink($candle->ID); ?>" class="button">
										Click on this box to vew the Prayer Request on the Website
									</a>
								</p>

							</td>
						</tr>

						<tr>

						</tr>
					</table>

				</td>

			<tr class="spacer">
				<td colspan="100" height="50">&nbsp;</p>
			</tr>

		</table>

	</body>

</html>
