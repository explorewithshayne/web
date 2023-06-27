<?php
if( ! defined( 'ABSPATH' ) ){
	exit; // Exit if accessed directly
}

$favs = json_decode(get_option( 'mfn_fav_items_'.get_current_user_id() ));

echo '<div class="panel panel-items" id="mfn-widgets-list">
    <div class="panel-search mfn-form">
        <input class="mfn-form-control mfn-form-input search mfn-search" type="text" placeholder="Search">
    </div>';

    if( !isset($this->template_type) || $this->template_type != 'header' ){
	    echo '<div class="mfn-fav-items-wrapper '.($favs && count($favs) > 0 ? 'isset-favs' : 'empty-favs').'">';
		 	echo '<h5>Favourite elements</h5>';

		 	echo '<div class="mfn-fav-items-content">';
		 	echo '<ul class="items-list fav-items-list clearfix">';
		 	if( $favs && count($favs) > 0 ){
		 		foreach( $favs as $fav ){
		 			if( $widgets[$fav]['cat'] !== 'header' )
		 				echo '<li class="mfn-item-'.$fav.' category-'.$widgets[$fav]['cat'].'" data-title="'.$widgets[$fav]['title'].'" data-type="'.$fav.'"><a href="#"><div class="mfn-icon card-icon"></div><span class="title">'.$widgets[$fav]['title'].'</span></a></li>';
		 		}
		 	}
		 	echo '</ul>';
		 	echo '<span class="empty-favs-info">Collect favourite elements in one place by<br /> <span class="mfn-icon mfn-icon-right-click"></span> &gt; <i>Add to favourites'. ( ! is_admin() ? ' (Unavailable in Demo)' : '' ) .'</i></span>';
		 echo '</div></div>';
	}

    echo '<ul class="items-list list clearfix">';

    foreach($widgets as $w=>$widget){
    	if( isset($this->template_type) && $this->template_type == 'header' ){
    		// if header
    		if($widget['cat'] == 'header' || in_array($w, array('column', 'button', 'heading', 'payment_methods', 'image', 'plain_text', 'header_language_switcher'))){
		    	echo '<li class="mfn-item-'.$w.' category-'.$widget['cat'].'" data-title="'.$widget['title'].'" data-type="'.$w.'"><a href="#"><div class="mfn-icon card-icon"></div><span class="title">'.$widget['title'].'</span></a></li>';
		    }
    	}elseif( isset($this->template_type) && $this->template_type == 'megamenu' ){
    		if($widget['cat'] == 'megamenu' || ( !in_array($widget['cat'], array('shop-archive', 'single-product', 'header', 'footer')) && !in_array($w, array('before_after', 'chart', 'content', 'offer', 'offer_thumb', 'our_team', 'our_team_list', 'sidebar_widget', 'slider_plugin', 'table_of_contents', 'testimonials_list', 'timeline')) ) ){
		    	echo '<li class="mfn-item-'.$w.' category-'.$widget['cat'].'" data-title="'.$widget['title'].'" data-type="'.$w.'"><a href="#"><div class="mfn-icon card-icon"></div><span class="title">'.$widget['title'].'</span></a></li>';
		    }
    	}elseif( isset($this->template_type) && $this->template_type == 'popup' ){
    		if($widget['cat'] == 'popup' || ( !in_array($widget['cat'], array('loops', 'shop-archive', 'single-product', 'header', 'footer', 'megamenu')) && !in_array($w, array('sidebar_widget', 'slider_plugin', 'table_of_contents', 'slider', )) ) ){
		    	echo '<li class="mfn-item-'.$w.' category-'.$widget['cat'].'" data-title="'.$widget['title'].'" data-type="'.$w.'"><a href="#"><div class="mfn-icon card-icon"></div><span class="title">'.$widget['title'].'</span></a></li>';
		    }
    	}elseif(
    		// rest
	    	( !in_array($widget['cat'], array('shop-archive', 'single-product', 'header', 'megamenu', 'footer', 'popup')) ) ||
			( isset($this->template_type) && $this->template_type == 'single-product' && $widget['cat'] == 'single-product' ) ||
			( isset($this->template_type) && $this->template_type == 'footer' && $widget['cat'] == 'footer' ) ||
			( isset($this->template_type) && $this->template_type == 'popup' && $widget['cat'] == 'popup' ) ||
			( isset($this->template_type) && $this->template_type == 'shop-archive' && $widget['cat'] == 'shop-archive' )
	    ){
	    	echo '<li class="mfn-item-'.$w.' category-'.$widget['cat'].'" data-title="'.$widget['title'].'" data-type="'.$w.'"><a href="#"><div class="mfn-icon card-icon"></div><span class="title">'.$widget['title'].'</span></a></li>';
	    }

	}
	echo '</ul>
</div>';
?>
