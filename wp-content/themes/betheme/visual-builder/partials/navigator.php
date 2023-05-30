<div class="mfn-modalbox mfn-navigator mfn-shadow-1">
	<div class="modalbox-header">
		<div class="options-group">
			<div class="modalbox-title-group">
				<span class="modalbox-icon mfn-icon-navigator"></span>
				<div class="modalbox-desc">
					<h4 class="modalbox-title">Layer Navigator</h4>
				</div>
			</div>
		</div>
		<div class="options-group">
			<a class="mfn-option-btn mfn-option-blank btn-large btn-modal-close btn-navigator-switcher" title="Close" href="#"><span class="mfn-icon mfn-icon-close"></span></a>
		</div>
	</div>
	<div class="modalbox-content" id="mfn-navigator-items">
		<ul class="navigator-tree">
			<?php $navigator = self::getNavigatorTree($this->post_id); if(!empty($navigator)) echo $navigator; ?>
		</ul>
        <div class="navigator-search mfn-form">
            <input class="mfn-form-control mfn-form-input mfn-navigator-search-input" type="text" placeholder="Search">
        </div>
	</div>
</div>