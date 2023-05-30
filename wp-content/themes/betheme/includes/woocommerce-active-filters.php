<?php 
if($_GET){
echo '<div class="mfn-woo-list-active-filters">';
echo '<ul class="mfn-active-woo-filters">';
foreach($_GET as $f=>$filter){
	if(is_array($filter) && is_iterable($filter)){
		foreach($filter as $filtr){
			$term = get_term_by('slug', $filtr, str_replace('mfn_', '', $f));
			if(isset($term->term_id)){
				echo '<li><span data-id="mfn_attr_'.$term->term_id.'"><span class="label">'.$term->name.'</span><span class="del">&#10005;</span></span></li>';
			}
		}
	}else{
		$term = get_term_by('slug', $filter, str_replace('mfn_', '', $f));
		if(isset($term->term_id)){
			echo '<li><span data-id="mfn_attr_'.$term->term_id.'">'.$filter.'</span></li>';
		}
	}
}
echo '</ul>';
echo '</div>';
}