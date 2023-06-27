<?php
/**
 * Social Icons
 *
 * @package Betheme
 * @author Muffin group
 * @link http://muffingroup.com
 */

// attributes

$attr = array();
$social_attr = mfn_opts_get('social-attr');

if (is_array($social_attr)) {
	if (isset($social_attr['blank'])) {
		$attr[] = 'target="_blank"';
	}
	if (isset($social_attr['nofollow'])) {
		$attr[] = 'rel="nofollow"';
	}
}

$attr = implode(' ', $attr);

// order

$social_links = mfn_opts_get('social-link');

// output -----

echo '<ul class="social" role="navigation" aria-label="'. __('social menu', 'betheme') .'">';

	if( ! empty( $social_links['order'] ) ){

		$social_links['order'] = explode( ',', $social_links['order'] );

		foreach( $social_links['order'] as $social ){


			if( false !== strpos($social, 'custom') ){

				if( 'custom' === $social ){
					$postfix = '';
				} else {
					$postfix = str_replace('custom-', '', $social);
					$postfix = '-'. $postfix;
				}

				if (mfn_opts_get('social-custom-icon'. $postfix) &&  mfn_opts_get('social-custom-link'. $postfix)) {
					$title = mfn_opts_get('social-custom-title'. $postfix);
					echo '<li class="custom"><a '. $attr .' href="'. esc_url(mfn_opts_get('social-custom-link'. $postfix)) .'" title="'. esc_attr($title) .'" aria-label="'. esc_attr($title) .' icon"><i class="'. esc_attr(mfn_opts_get('social-custom-icon'. $postfix)) .'"></i></a></li>';
				}

			} elseif( 'rss' == $social ) {

				if (mfn_opts_get('social-rss')) {
					echo '<li class="rss"><a '. $attr .' href="'. esc_url(get_bloginfo('rss2_url')) .'" title="RSS" aria-label="'. __('RSS icon', 'betheme') .'"><i class="icon-rss"></i></a></li>';
				}

			} else {

				$item = mfna_social($social);

				if( ! empty( $social_links[$social] ) ){

					// add missing https://
					$re = '/\/\/|#/';
					if( ! preg_match($re, $social_links[$social]) ){
						$social_links[$social] = 'https://'. $social_links[$social];
					}

					echo '<li class="'. esc_attr($social) .'"><a '. $attr .' href="'. esc_attr( $social_links[$social] ) .'" title="'. esc_html($item['title']) .'" aria-label="'. esc_html($item['title']) .' icon"><i class="'. esc_attr($item['icon']) .'"></i></a></li>';
				}

			}

		}

	}

echo '</ul>';
