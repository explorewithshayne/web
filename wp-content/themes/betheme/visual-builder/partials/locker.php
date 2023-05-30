<?php
if( ! defined( 'ABSPATH' ) ){
	exit; // Exit if accessed directly
}

$user = get_user_by('ID', $edit_lock);

echo '<div class="mfn-modal mfn-modal-locker modal-confirm show">
	<div class="mfn-modalbox mfn-form mfn-shadow-1">
		<div class="modalbox-content">
			<h3>This post is already being edited.</h3>
			<p>'.$user->user_login.' is currently working on this post, which means you cannot make changes, unless you take over.</p>

			<a href="'.wp_get_referer().'" class="mfn-btn mfn-btn-green btn-modal-confirm">Exit the Editor</a> 
			<a href="#" class="mfn-btn take-post-editing">Take Over</a>
		</div>
	</div>
</div>';