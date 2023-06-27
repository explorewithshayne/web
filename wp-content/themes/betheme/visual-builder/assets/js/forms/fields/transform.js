function mfn_field_transform(field) {
	let html = '';
	let used_fields = [
		{
			'id': field.id,
			'type': 'sliderbar',
			'title': 'TranslateX',
			'key': 'translateX',
			'param': {
				'min': '-1040',
				'max': '1040',
				'step': '1',
				'unit': '%',
			}
		},
		{
			'id': field.id,
			'type': 'sliderbar',
			'title': 'TranslateY',
			'key': 'translateY',
			'param': {
				'min': '-1040',
				'max': '1040',
				'step': '1',
				'unit': '%',
			}
		},
		{
			'id': field.id,
			'type': 'sliderbar',
			'title': 'Rotate',
			'key': 'rotate',
			'param': {
				'min': '0',
				'max': '359',
				'step': '1',
				'unit': 'deg',
			}
		},
		{
			'id': field.id,
			'type': 'sliderbar',
			'title': 'ScaleX',
			'key': 'scaleX',
			'param': {
				'min': '0',
				'max': '3',
				'step': '0.05',
				'unit': '',
			}
		},
		{
			'id': field.id,
			'type': 'sliderbar',
			'title': 'ScaleY',
			'key': 'scaleY',
			'param': {
				'min': '0',
				'max': '3',
				'step': '0.05',
				'unit': '',
			}
		},
		{
			'id': field.id,
			'type': 'sliderbar',
			'title': 'SkewX',
			'key': 'skewX',
			'param': {
				'min': '-4',
				'max': '4',
				'step': '0.05',
				'unit': '',
			}
		},
		{
			'id': field.id,
			'type': 'sliderbar',
			'title': 'SkewY',
			'key': 'skewY',
			'param': {
				'min': '-4',
				'max': '4',
				'step': '0.05',
				'unit': '',
			}
		},
	];

	html += `<div class="form-group multiple-inputs multiple-inputs-with-color has-addons has-addons-append transform_field">`;
		html += `<input class="mfn-field-value mfn-pseudo-val" name="${field.id}" data-key="string" type="hidden">`;
		const mfn_form_transform = new MfnForm( used_fields );
	    html += mfn_form_transform.render();
    html += `</div>`;

	return html;
}