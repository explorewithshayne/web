<?php
	defined( 'ABSPATH' ) || exit;

  require_once( get_theme_file_path('/functions/importer/demos.php') );
  // print_r($demos);
?>

<?php if( ! WHITE_LABEL ): ?>

<div class="mfn-row">
  <div class="row-column row-column-12">

    <div class="mfn-card mfn-shadow-1" data-card="prebuilt-websites">
      <div class="card-header">
        <div class="card-title-group">
          <span class="card-icon mfn-icon-websites"></span>
          <div class="card-desc">
            <h4 class="card-title">Latest pre-built websites</h4>
          </div>
        </div>
        <div class="card-links-group">
          <a href="admin.php?page=be-websites">
            <span class="mfn-icon mfn-icon-layout-grid"></span> See all websites </a>
        </div>
      </div>
      <div class="card-content">
        <div class="mfn-row">

          <?php
            $loop = 0;

            foreach( $demos as $demo_key => $demo ){

              if( in_array( $demo_key, ['theme','bethemestore'] ) ){
                continue;
              }

              echo '<a href="admin.php?page=be-websites" class="row-column row-column-3 website-item">';
                echo '<img src="https://muffingroup.com/betheme/assets/images/demos/'. esc_attr($demo_key) .'.jpg" alt="" />';
                echo '<h5>'. esc_html($demo['name']) .'</h5>';
              echo '</a>';

              $loop++;

              if( $loop > 3 ){
                break;
              }

            }
          ?>

        </div>
      </div>
    </div>

  </div>
</div>

<?php endif; ?>
