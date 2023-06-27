function mfn_field_text_shadow(field) {
	let horizontal = '';
	let vertical = '';
	let blur = '';
	let color = '';
	let value = [];

	if( _.has(edited_item['attr'], field.id) && edited_item['attr'][field.id].length ){
		value = edited_item['attr'][field.id].split(' ');
	}

	if( value.length ){ 
		horizontal = value[0];
		vertical = value[1];
		blur = value[2];
		color = value[3];
	}
	
	let html = `<div class="form-content"><div class="form-group multiple-inputs pseudo equal-full-inputs">
		<div class="form-control">
			<input class="pseudo-field mfn-field-value mfn-form-control" type="hidden" name="${field.id}" value="${_.has(edited_item['attr'], field.id) && edited_item['attr'][field.id].length ? edited_item['attr'][field.id] : ''}" autocomplete="off"/>

			<div class="field numeral" data-key="horizontal">
				<input type="text" class="mfn-form-control mfn-form-input numeral mfn-group-field-horizontal" data-key="horizontal" value="${horizontal}" autocomplete="off" />
			</div>

			<div class="field numeral" data-key="vertical">
				<input type="text" class="mfn-form-control mfn-form-input numeral mfn-group-field-vertical" data-key="vertical" value="${vertical}" autocomplete="off" />
			</div>

			<div class="field numeral" data-key="blur">
				<input type="text" class="mfn-form-control mfn-form-input numeral mfn-group-field-blur" data-key="blur" value="${blur}" autocomplete="off" />
			</div>

		</div>

		${mfn_field_color(color)}

	</div></div>`;

	return html;
}