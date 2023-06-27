<?php
class MFN_Options_custom extends Mfn_Options_field
{

	/**
	 * Render
	 */

	public function render($meta = false)
	{
		$action = isset( $this->field['action'] ) ? $this->field['action'] : '';

		echo '<div class="desc-group">';

			if ( 'wpml' == $action ) {

				echo '<span class="description">';

					echo '<p>Betheme is <a href="https://wpml.org/theme/betheme/?aid=29349&affiliate_key=aCEsSE0ka33p" target="_blank">fully compatible with WPML</a> - the WordPress Multilingual Plugin. WPML lets you add languages to your existing sites and includes advanced translation management.</p>';

					echo '<p>WPML makes it easy to build multilingual sites and run them. It’s powerful enough for corporate sites, yet simple for blogs.</p>';

				echo '</span>';

				echo '<div class="wpml-how-to">';
					echo '<a class="lightbox" href="https://www.youtube.com/watch?v=jSJ7aUCHc9M"><img src="'. get_theme_file_uri( 'muffin-options/img/wpml.webp' ) .'" alt="Translate Betheme website"></a>';
				echo '</div>';

				echo '<a class="mfn-btn mfn-btn-blue" href="https://wpml.org/purchase/?aid=29349&affiliate_key=aCEsSE0ka33p" target="_blank"><span class="btn-wrapper">'. __('Buy and download', 'mfn-opts') .'</span></a>';
				echo '<a class="mfn-btn" href="https://wpml.org/features/?aid=29349&affiliate_key=aCEsSE0ka33p" target="_blank"><span class="btn-wrapper">'. __('WPML features', 'mfn-opts') .'</span></a>';

			} elseif ( 'description' == $action ) {

				echo wp_kses( $this->field['desc'], mfn_allowed_html('desc') );

			} elseif ( 'performance' == $action ) {

				echo '<span class="description">';
					echo '<p><b>One click settings are recommended for most users.</b></p>';
					echo '<p>Plese check your site after enabling this option and adjust settings below if necessery. Please remember that there are many server settings and plugins that may be incompatible with some options.</p>';
				echo '</span>';

				echo '<span class="description">';
					echo '<a class="mfn-btn mfn-btn-blue performance-apply-enable" href=""><span class="btn-wrapper">'. __('Apply recommended settings', 'mfn-opts') .'</span></a>';
					echo '<a class="mfn-btn performance-apply-disable" href=""><span class="btn-wrapper">'. __('Disable all', 'mfn-opts') .'</span></a>';
				echo '</span>';

			} else {

				// default

				echo '<p>This is "field_custom" and requires "action" parameter</p>';
			}

		echo '</div>';

	}
}
