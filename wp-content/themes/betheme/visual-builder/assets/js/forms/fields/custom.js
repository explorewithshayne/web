function mfn_field_custom(field) {
	let action = '';
	let html = '<div class="desc-group">';

	if( _.has(field, 'action') ){
		action = field.action;
	}

	if ( 'wpml' == action ) {
		html += `
			<span class="description">
				<p>Betheme is <a href="https://wpml.org/theme/betheme/?aid=29349&affiliate_key=aCEsSE0ka33p" target="_blank">fully compatible with WPML</a> - the WordPress Multilingual Plugin. WPML lets you add languages to your existing sites and includes advanced translation management.</p>
				<p>WPML makes it easy to build multilingual sites and run them. It’s powerful enough for corporate sites, yet simple for blogs.</p>
			</span>

			<div class="wpml-how-to">
				<a class="lightbox" href="https://www.youtube.com/watch?v=jSJ7aUCHc9M"><img src="muffin-options/img/wpml.webp" alt="Translate Betheme website"></a>
			</div>

			<a class="mfn-btn mfn-btn-blue" href="https://wpml.org/purchase/?aid=29349&affiliate_key=aCEsSE0ka33p" target="_blank"><span class="btn-wrapper">Buy and download</span></a>
			<a class="mfn-btn" href="https://wpml.org/features/?aid=29349&affiliate_key=aCEsSE0ka33p" target="_blank"><span class="btn-wrapper">WPML features</span></a>
		`;
	}else if ( 'description' == action ) {
		html += field.desc;
	}else{
		html += `<p>This is "field_custom" and requires "action" parameter</p>`;
	}

	html += `</div>`;
	return html;
}