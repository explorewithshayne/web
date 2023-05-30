<?php
class MFN_Options_upload_icon extends Mfn_Options_field
{
	public $path_icons;

	public $icon_uploaded = false;
	public $error_message = '';

	/**
	 * Add prefix of the icon name
	 */

	public function add_prefix_on_upload( $path_unzip, $prefix )
	{
		$wp_filesystem = Mfn_Helper::filesystem();

		// get original css file content
		$data = $wp_filesystem->get_contents($path_unzip.'/style.css');

		// change icon prefix
		$data_prefix_added = preg_replace('/icon-/', $prefix .'-', $data);

		// delete original file
		$wp_filesystem->delete($path_unzip.'/style.css');

		// save file with prefixed content
		$wp_filesystem->put_contents($path_unzip.'/style.css', $data_prefix_added);
	}

	/**
	 * Parse name and prefix on upload
	 */

	public function parse_str_on_upload($name)
	{
		$white_space_regex = '[\s]';
		$no_letters_regex = '[\W]';

		return preg_replace( $white_space_regex, '_', preg_replace( $no_letters_regex, '', $name ) );
	}

	/**
	 * Prepare icon package from uploaded file
	 */

	public function upload_icons()
	{
		$post_id = get_the_id();

		$wp_filesystem = Mfn_Helper::filesystem();

		$upload_dir = wp_upload_dir();

		// find the icon from wp uploads

		$wp_upload_file = str_replace($upload_dir['url'], $upload_dir['path'], $this->value);

		// get values provided by user, first

		$font_name_provided  = $this->parse_str_on_upload(get_post_field( 'mfn-icon-name', $post_id ));
		$font_name_provided_noparse = get_post_field( 'mfn-icon-name', $post_id );

		$font_prefix_provided = $this->parse_str_on_upload(get_post_field( 'mfn-icon-prefix', $post_id ));

		$font_upload_url = get_post_field( 'mfn-icon-upload', $post_id );

		// do not upload anything when one of the fields (or file) is missing!

		if ( ! $font_name_provided || ! $font_prefix_provided || ! $font_upload_url ){
			return;
		}

		// rename and move to betheme icons upload dir

		$new_icon_path = $this->path_icons.'/' .$font_name_provided;
		$new_icon_url = wp_normalize_path( get_home_url() . '/wp-content/uploads/betheme/icons/' . $font_name_provided);
		$wp_filesystem->move($wp_upload_file, $new_icon_path.'.zip');

		// update post meta

		update_post_meta($post_id, 'mfn-icon-name', $font_name_provided_noparse);
		update_post_meta($post_id, 'mfn-icon-name-parsed', $font_name_provided);
		update_post_meta($post_id, 'mfn-icon-prefix', $font_prefix_provided);
		update_post_meta($post_id, 'mfn-icon-upload', $new_icon_path);

		// unzipping, WP FS

		$wp_filesystem = Mfn_Helper::filesystem();

		$path_zip = wp_normalize_path( $new_icon_path.'.zip' );
		$path_unzip = wp_normalize_path( $this->path_icons .'/'. $font_name_provided );

		$unzip = unzip_file( $path_zip, $new_icon_path );

		if( is_wp_error( $unzip ) ){
			return new WP_Error( 'error_unzip', __( 'The package could not be unziped.', 'mfn-opts' ) );
		}

		if( ! is_dir( $path_unzip ) ) {
			return new WP_Error( 'error_folder', sprintf( __( 'Demo data folder does not exist (%s).', 'mfn-opts' ), $path_unzip ) );
		}

		// if all ok, remove zip

		$wp_filesystem->delete($path_zip);

		// we need to add prefix to css classes to overwrite font-family!

		$this->add_prefix_on_upload($path_unzip, $font_prefix_provided);

		// set the link and icons names in database

		update_post_meta($post_id, 'mfn-icon-url', $new_icon_url);

		$this->set_icons_name($post_id, $new_icon_url);
	}

	/**
	 * Save icon names
	 */

	public function set_icons_name($post_id, $icon_path_location)
	{
		$wp_filesystem = Mfn_Helper::filesystem();

		$json_file = $wp_filesystem->get_contents( $icon_path_location . '/selection.json' );
		$json_decoded = json_decode( $json_file, true );

		// if pack wont be moonicon, then script wont get in there, its prevention just in case :)

		if( $json_decoded != null ) {

			$new_icon_bundle = array(
				// first two elements are important, for recognizing the name (no parsed) and prefix of icon bundle
				get_post_field( 'mfn-icon-name', $post_id ),
				get_post_field( 'mfn-icon-prefix', $post_id ),
			);

			foreach( $json_decoded['icons'] as $icon => $icon_value ){
				$new_icon_bundle[] = $icon_value['properties']['name']; // push icons name
			}

			update_post_meta($post_id, 'mfn-icon-titles-array', $new_icon_bundle);
		}
	}

	/**
	 * Show list of SVG icons
	 */

	public function draw_icons_svg()
	{
		$post_id = get_the_id();
		$wp_filesystem = Mfn_Helper::filesystem();

		$cleared_link = str_replace( get_home_url($this->value).'/', '', $this->value );
		$uploaded_file_link = ABSPATH . $cleared_link;

		$uploaded_font_name = get_post_field( 'mfn-icon-name', get_the_id() ) ? get_post_field( 'mfn-icon-name', get_the_id() ) : '(no name)';
		$uploaded_font_prefix = get_post_field( 'mfn-icon-prefix', get_the_id() );

		$json_file = $wp_filesystem->get_contents($cleared_link.'/selection.json');
		$json_decoded = json_decode($json_file, true);

		foreach( $json_decoded['icons'] as $icon => $icon_a ){
			echo '<div class="mfn-custom-icon">';
				echo '<svg width="30" height="30" viewBox="-100 -100 1200 1200">';

				//multiple paths in icons!
				foreach( $icon_a["icon"]["paths"] as $path => $path_a ) {
					echo '<path d="'. $path_a .'" />';
				}
				echo '</svg>';

				echo '<p>'. $icon_a['properties']['name'] .'</p>';
				echo '<p class="code">'. $uploaded_font_prefix .'-'. $icon_a['properties']['name'] .'</p>';
			echo '</div>';
		}
	}

	/**
	 * Check if icon zip file is uploaded
	 */

	public function is_icon_uploaded()
	{
		$wp_filesystem = Mfn_Helper::filesystem();

		$link = str_replace( get_home_url( $this->value ).'/', '', $this->value );

		$json_file = $wp_filesystem->get_contents( $link .'/selection.json' );

		if( $json_file === FALSE && get_post_field( 'mfn-icon-upload', get_the_id() ) ){
			$this->error_message = __( 'This is not the Icomoon zip file. Please try again', 'mfn-opts' );
		} else if( $json_file === FALSE ) {
			return;
		}else {
			$this->icon_uploaded = true;
		}

	}

	/**
	 * Render
	 */

	public function render( $meta = false )
	{
		$upload_dir = wp_upload_dir();
		$path_be = wp_normalize_path( $upload_dir['basedir'] .'/betheme' );
		$this->path_icons = wp_normalize_path( $path_be .'/icons' );

		// check if icon file is uploaded

		$this->is_icon_uploaded();

		if ( ! empty( $_GET['message'] ) ) {

			// refresh after icon file parse

			$this->upload_icons();
			echo '<script>window.location.reload(true);</script>';

		}

		// output -----

		if( $this->icon_uploaded ){

			$uploaded_font_name = get_post_field( 'mfn-icon-name', get_the_id() ) ? get_post_field( 'mfn-icon-name', get_the_id() ) : '(no name)';
			$uploaded_font_prefix = get_post_field( 'mfn-icon-prefix', get_the_id() );

			echo '<div class="mfn-uploaded-custom-icons">';
				echo '<h5>'. esc_html( $uploaded_font_name ). '<span class="prefix">'. esc_html( $uploaded_font_prefix ). '-</span></h5>';
				$this->draw_icons_svg();
			echo '</div>';

		}else{
			echo '<div class="form-group browse-icon has-addons has-addons-append">';

				echo '<div class="form-control has-icon has-icon-right">';
					echo '<input class="mfn-form-control mfn-form-input" type="text" '. $this->get_name( $meta ) .' value="'. esc_attr( $this->value ) .'" data-type="file"/>';
					echo '<a class="mfn-option-btn mfn-button-delete" title="Delete" href="#"><span class="mfn-icon mfn-icon-delete"></span></a>';
				echo '</div>';

				echo '<div class="form-addon-append">';
					echo '<a href="#" class="mfn-button-upload"><span class="label">'. esc_html__( 'Browse', 'mfn-opts' ) .'</span></a>';
				echo '</div>';

			echo '</div>';

			if( $this->error_message ){
				echo '<div class="desc-group">';
					echo '<span class="description error">'. esc_html( $this->error_message ) .'</span>';
				echo '</div>';
			} else {
				echo $this->get_description();
			}

		}

		// enqueue
		$this->enqueue();
	}

	/**
	 * Enqueue
	 */

	public function enqueue()
	{
		wp_enqueue_media();
		wp_enqueue_script( 'mfn-opts-field-upload-icon', MFN_OPTIONS_URI .'fields/upload_icon/field_upload_icon.js', array( 'jquery' ), MFN_THEME_VERSION, true );
	}
}
