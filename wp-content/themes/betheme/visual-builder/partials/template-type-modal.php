<div class="mfn-modal has-footer modal-template-type show">

	<div class="mfn-modalbox mfn-form mfn-form-verical mfn-shadow-1">

		<div class="modalbox-header">

			<div class="options-group">
				<div class="modalbox-title-group">
					<span class="modalbox-icon mfn-icon-settings"></span>
					<div class="modalbox-desc">
						<h4 class="modalbox-title">New template</h4>
					</div>
				</div>
			</div>

			<div class="options-group">
				<a class="mfn-option-btn mfn-option-blank btn-large btn-modal-close" title="Close" href="edit.php?post_type=template">
					<span class="mfn-icon mfn-icon-close"></span>
				</a>
			</div>

		</div>

		<div class="modalbox-content">
			<h3>Templates Will Make Your Work Smarter</h3>
			<p>Create various pieces of your site, and then combine them with one click to build the final layout. It’s that simple.</p>

			<div class="template-type-form">
				<h4>Choose Type Of Template</h4>

				<?php
					$type = $this->getReferer();
				?>

				<!-- input 1 -->
				<label class="form-label">Select the type of template you would like to create</label>
				<select class="mfn-form-control select-template-type df-input">
					<option value="header" <?php selected( $type, 'header' ); ?> >Header</option>
					<option value="footer" <?php selected( $type, 'footer' ); ?> >Footer</option>
					<option value="popup" <?php selected( $type, 'popup' ); ?> >Popup</option>
					<option value="megamenu" <?php selected( $type, 'megamenu' ); ?> >Mega menu</option>
					<?php if(function_exists('is_woocommerce')){ ?>
						<option value="single-product" <?php selected( $type, 'single-product' ); ?> >Single product</option>
						<option value="shop-archive" <?php selected( $type, 'shop-archive' ); ?> >Shop archive</option>
					<?php } ?>
					<option value="default" <?php selected( $type, 'default' ); ?> >Page template</option>
					<option value="section" <?php selected( $type, 'section' ); ?> >Global Section</option>
					<option value="wrap" <?php selected( $type, 'wrap' ); ?> >Global Wrap</option>
				</select>

				<!-- input 2 -->
				<label class="form-label">Name your template</label>
				<input type="text" class="mfn-form-control input-template-type-name df-input" placeholder="Name">

			</div>
		</div>

		<div class="modalbox-footer">
			<div class="options-group right">
				<a class="mfn-btn mfn-btn-blue btn-modal-save btn-save-template-type" data-builder="<?php echo apply_filters('betheme_slug', 'mfn'); ?>" href="#"><span class="btn-wrapper">Create template</span></a>
				<a class="mfn-btn btn-modal-close" href="edit.php?post_type=template"><span class="btn-wrapper">Cancel</span></a>
			</div>
		</div>

	</div>

</div>
