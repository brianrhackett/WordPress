<?php
/**
 * Template Name: Style Guide
 *
 * @package __secureset
 */

get_header(); ?>

<div id="primary" class="content-area custom-page-background" style="background-image:url( '<?php the_field( 'page-background-image' ) ?>' ); background-color:<? the_field( 'page-background-color' ); ?> " >
		<main id="main" class="site-main" role="main">
			<div class="container style-guide">

				<div class="style-guide__row">
					<div class="style-guide__element-label"><p>h1</p></div>

					<div class="style-guide__element-content"><h1>Lorem ipsum <br />dolor sit amet</h1></div>
				</div>

				<div class="style-guide__row">
					<div class="style-guide__element-label"><p>h2</p></div>

					<div class="style-guide__element-content"><h2>Lorem ipsum <br />dolor sit amet</h2></div>
				</div>

				<div class="style-guide__row">
					<div class="style-guide__element-label"><p>h3</p></div>

					<div class="style-guide__element-content"><h3>Sed posuere consectetur <br />est at lobortis.</h3></div>
				</div>

				<div class="style-guide__row">
					<div class="style-guide__element-label"><p>h4</p></div>

					<div class="style-guide__element-content"><h4>Sed posuere consectetur <br />est at lobortis.</h4></div>
				</div>

				<div class="style-guide__row">
					<div class="style-guide__element-label"><p>h5</p></div>

					<div class="style-guide__element-content"><h5>Lorem impsum <br />dolor sit amet</h5></div>
				</div>

				<div class="style-guide__row">
					<div class="style-guide__element-label"><p>p</p></div>

					<div class="style-guide__element-content"><p>Aenean lacinia bibendum nulla sed consectetur. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Vestibulum id ligula porta felis euismod semper. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Donec sed odio dui. Donec id elit non mi porta gravida at eget metus. Lorem ipsum dolor!</p></div>
				</div>

				<div class="style-guide__row">
					<div class="style-guide__element-label"><p>p.big</p></div>

					<div class="style-guide__element-content"><p class="big">Aenean lacinia bibendum nulla sed consectetur. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Vestibulum id ligula porta felis euismod semper.</p></div>
				</div>

				<div class="style-guide__row">
					<div class="style-guide__element-label"><p>p.big.bold</p></div>

					<div class="style-guide__element-content"><p class="big bold">Aenean lacinia bibendum nulla sed consectetur. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.</p></div>
				</div>

				<div class="style-guide__row">
					<div class="style-guide__element-label"><p>buttons large</p></div>

					<div class="style-guide__element-content">
						<button class="btn btn--large">Learn More</button>
						<button class="btn btn--large btn--light">Learn More</button>
					</div>
				</div>

				<div class="style-guide__row">
					<div class="style-guide__element-label"><p>buttons small</p></div>

					<div class="style-guide__element-content">
						<button class="btn">Learn More</button>
						<button class="btn btn--light">Learn More</button>
					</div>
				</div>

				<div class="style-guide__row">
					<div class="style-guide__element-label"><p>icon buttons</p></div>

					<div class="style-guide__element-content">
						<button class="btn btn--calendar">Learn More</button>
					</div>
				</div>

				<div class="style-guide__row">
					<div class="style-guide__element-label"><p>Blockquotes</p></div>

					<div class="style-guide__element-content">
						<blockquote>
							Aenean lacinia bibendum nulla sed consectetur. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Vestibulum id ligula porta felis euismod semper.
						</blockquote>
					</div>
				</div>

				<div class="style-guide__row">
					<div class="style-guide__element-label"><p>Blockquotes Medium</p></div>

					<div class="style-guide__element-content">
						<blockquote class="medium">
							Aenean lacinia bibendum nulla sed consectetur. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Vestibulum id ligula porta felis euismod semper.
						</blockquote>
					</div>
				</div>

				<div class="style-guide__row">
					<div class="style-guide__element-label"><p>Blockquotes Large</p></div>

					<div class="style-guide__element-content">
						<blockquote class="large">
							Aenean lacinia bibendum nulla sed consectetur. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Vestibulum id ligula porta felis euismod semper.
						</blockquote>
					</div>
				</div>

				<div class="style-guide__row">
					<div class="style-guide__element-label"><p>Global Icons</p></div>

					<div class="style-guide__element-content">

					</div>
				</div>

				<div class="style-guide__row  style-guide__row--light" style="margin-bottom: 0;">
					<div class="style-guide__element-label"><p>Brand Colors</p></div>

					<div class="style-guide__element-content">
						<div class="swatch swatch--dark-blue"></div>
						<div class="swatch swatch--blue"></div>
						<div class="swatch swatch--light-blue"></div>

						<div class="swatch swatch--dark-gray"></div>
						<div class="swatch swatch--gray"></div>
						<div class="swatch swatch--light-gray"></div>

						<div class="swatch swatch--green"></div>
						<div class="swatch swatch--red"></div>
						<div class="swatch swatch--orange"></div>
						<div class="swatch swatch--purple"></div>
					</div>
				</div>

				<hr />

				<div class="style-guide__row style-guide__row--light">
					<div class="style-guide__element-label"><p>Gradients</p></div>

					<div class="style-guide__element-content">
						<div class="swatch swatch--dark-blue-grad"></div>
						<div class="swatch swatch--blue-grad"></div>
						<div class="swatch swatch--light-blue-grad"></div>
						<div class="swatch swatch--white-grad"></div>
						<div class="swatch swatch--gray-grad"></div>
						<div class="swatch swatch--gray-grad-alt"></div>
						<div class="swatch swatch--gray-grad-alt-b"></div>
						<div class="swatch swatch--black-grad"></div>
					</div>
				</div>

				<div class="style-guide__row style-guide__row">
					<div class="style-guide__element-label"><p>Location Bar</p></div>

					<div class="style-guide__element-content">
						<?php echo get_component( 'location-dropdown' ); ?>
					</div>
				</div>

				<div class="style-guide__row style-guide__row">
					<div class="style-guide__element-label"><p>Dropdown Element</p></div>

					<div class="style-guide__element-content">
						<a class="dropdown-trigger" data-toggle="example-pane-id">Dropdown Trigger</a>

						<div id="example-pane-id" class="dropdown-pane light" data-dropdown data-position="bottom" data-v-offset="25" data-close-on-click="true">

							<ul class="location-select__list">
								<li><a href="#">one</a></li>
								<li><a href="#">two</a></li>
								<li><a href="#">three</a></li>
							</ul>
						</div>
					</div>
				</div>

				<div class="style-guide__row style-guide__row">
					<div class="style-guide__element-label"><p>Social Links</p></div>

					<div class="style-guide__element-content">
						<div class="social-links">
							<p><?php _e( 'Follow Us:', '__secureset' ); ?></p>
							<?php $option_fields = get_fields( 'options' ); ?>
							<ul>
								<?php if ( !empty( $option_fields['facebook_link'] ) ) : ?><li><a href="<?php echo esc_attr( $option_fields['facebook_link'] ); ?>"><span class="icon icon-facebook"></span></a></li><?php endif; ?>
								<?php if ( !empty( $option_fields['twitter_link'] ) ) : ?><li><a href="<?php echo esc_attr( $option_fields['twitter_link'] ); ?>"><span class="icon icon-twitter"></span></a></li><?php endif; ?>
								<?php if ( !empty( $option_fields['youtube_link'] ) ) : ?><li><a href="<?php echo esc_attr( $option_fields['youtube_link'] ); ?>"><span class="icon icon-youtube"></span></a></li><?php endif; ?>
								<?php if ( !empty( $option_fields['linkedin_link'] ) ) : ?><li><a href="<?php echo esc_attr( $option_fields['linkedin_link'] ); ?>"><span class="icon icon-linkedin"></span></a></li><?php endif; ?>
							</ul>
						</div>
					</div>
				</div>

				<div class="style-guide__row style-guide__row">
					<div class="style-guide__element-label"><p>Featured Comment Count</p></div>

					<div class="style-guide__element-content">
						<span class="news-featured-comments">12</span>
					</div>
				</div>

			</div>
		</main><!-- #main -->
	</div><!-- #primary -->
<?php get_footer(); ?>
