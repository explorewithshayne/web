function mfn_field_checkbox(field) {
	let classes = ['form-group', 'checkboxes'];
	let value = '';

	if( _.has(field, 'invert') ){
		classes.push('invert');
	}

	if( _.has(edited_item['attr'], field.id) && typeof edited_item['attr'][field.id] === 'string' ){
		// builder
		value = edited_item['attr'][field.id];
	}else if( (edited_item.jsclass == 'pageoption' || edited_item.jsclass == 'themeoption') && _.has(edited_item, field.id) && edited_item[field.id].length ){
		// themeoption
		value = edited_item[field.id];
	}

	let html = `<div class="form-content"><div class="${classes.join(' ')}">
			<div class="form-control">
				<ul>
				${ _.has(field, 'options') ? _.map(field.options, function(opt, o) {
					return `<li class="${ value.includes(o) ? 'active' : ''}">
							<input type="checkbox" class="mfn-form-checkbox" ${ value.includes(o) ? 'checked' : ''} data-key="${o}" name="${field.id}" value="${o}" />
							<span class="title">${opt}</span>
						</li>`;
				}).join('') : '' }
				</ul>
			</div>
		</div></div>`;

	return html;
}