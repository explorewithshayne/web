function mfn_field_info(field) {
	return `<div class="alert-icon mfn-icon-information"></div>
		<div class="alert-content"><p>${field.title}</p></div>
		${  _.has(field, 'link') && _.has(field, 'label') ? '<div class="alert-options"><a target="_blank" href="'+field.link+'">'+field.label+'</a></div>' : '' }`;
}