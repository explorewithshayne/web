<?php
if( ! defined( 'ABSPATH' ) ){
	exit; // Exit if accessed directly
}

$revisions = Mfn_Builder_Helper::get_revisions( $this->post_id );

$date_format = get_option('date_format');
if( in_array($date_format, ['F j, Y', 'Y-m-d', 'm/d/Y']) ){
  $get_date_from_gmt = true;
} else {
  $get_date_from_gmt = false;
}

if( empty(mfn_opts_get('builder-autosave')) ){
echo '<div class="panel panel-revision panel-revisions" style="display: none;">';
    echo '<ul class="revisions-list" data-type="autosave">';
        if( ! empty( $revisions['autosave'] ) ){
        foreach( $revisions['autosave'] as $rev_key => $rev_val ){
            echo '<li data-time="'. esc_attr( $rev_key ) .'">';
            echo '<span class="revision-icon mfn-icon-clock"></span>';
            echo '<div class="revision">';
						if( $get_date_from_gmt ){
              echo '<h6>'. esc_attr( get_date_from_gmt($rev_val) ) .'</h6>';
            } else {
              echo '<h6>'. $rev_val .'</h6>';
            }
            echo '<a class="mfn-option-btn mfn-option-text mfn-option-blue mfn-btn-restore revision-restore" href="#"><span class="text">Restore</span></a>';
            echo '</div>';
            echo '</li>';
        }
    }
    echo '</ul><p class="info">Saved automatically<br>every 5 minutes</p>';

echo '</div>';
}

echo '<div class="panel panel-revision panel-revisions-update" style="display: none;">';

    echo '<ul class="revisions-list" data-type="update">';
        if( ! empty( $revisions['update'] ) ){
        foreach( $revisions['update'] as $rev_key => $rev_val ){
            echo '<li data-time="'. esc_attr( $rev_key ) .'">';
            echo '<span class="revision-icon mfn-icon-clock"></span>';
            echo '<div class="revision">';
						if( $get_date_from_gmt ){
              echo '<h6>'. esc_attr( get_date_from_gmt($rev_val) ) .'</h6>';
            } else {
              echo '<h6>'. $rev_val .'</h6>';
            }
            echo '<a class="mfn-option-btn mfn-option-text mfn-option-blue mfn-btn-restore revision-restore" href="#"><span class="text">Restore</span></a>';
            echo '</div>';
            echo '</li>';
        }
        }
    echo '</ul><p class="info">Saved after<br>every post update</p>';

echo '</div>';

echo '<div class="panel panel-revision panel-revisions-revision" style="display: none;">';

    echo '<ul class="revisions-list" data-type="revision">';
        if( ! empty( $revisions['revision'] ) ){
        foreach( $revisions['revision'] as $rev_key => $rev_val ){
            echo '<li data-time="'. esc_attr( $rev_key ) .'">';
            echo '<span class="revision-icon mfn-icon-clock"></span>';
            echo '<div class="revision">';
						if( $get_date_from_gmt ){
              echo '<h6>'. esc_attr( get_date_from_gmt($rev_val) ) .'</h6>';
            } else {
              echo '<h6>'. $rev_val .'</h6>';
            }
            echo '<a class="mfn-option-btn mfn-option-text mfn-option-blue mfn-btn-restore revision-restore" href="#"><span class="text">Restore</span></a>';
            echo '</div>';
            echo '</li>';
        }
        }
    echo '</ul><p class="info">Saved using<br>Save revision button</p>';

    echo '<a class="mfn-btn mfn-btn-blue btn-revision mfn-save-revision" href="#"><span class="btn-wrapper">Save revision</span></a>';
echo '</div>';

echo '<div class="panel panel-revision panel-revisions-backup" style="display: none;">';

    echo '<ul class="revisions-list" data-type="backup">';
        if( ! empty( $revisions['backup'] ) ){
        foreach( $revisions['backup'] as $rev_key => $rev_val ){
            echo '<li data-time="'. esc_attr( $rev_key ) .'">';
            echo '<span class="revision-icon mfn-icon-clock"></span>';
            echo '<div class="revision">';
						if( $get_date_from_gmt ){
              echo '<h6>'. esc_attr( get_date_from_gmt($rev_val) ) .'</h6>';
            } else {
              echo '<h6>'. $rev_val .'</h6>';
            }
            echo '<a class="mfn-option-btn mfn-option-text mfn-option-blue mfn-btn-restore revision-restore" href="#"><span class="text">Restore</span></a>';
            echo '</div>';
            echo '</li>';
        }
        }
    echo '</ul><p class="info">Backups are being created<br> before restoring any revision</p>';

echo '</div>';
