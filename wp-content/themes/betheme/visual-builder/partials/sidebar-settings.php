<?php
if( ! defined( 'ABSPATH' ) ){
	exit; // Exit if accessed directly
}

echo '<div class="panel panel-settings" style="display: none;">
	<div class="mfn-form">';

	if( ! class_exists('Be_custom') ){

		echo '<div class="mfn-form-row mfn-row">
	    <div class="row-column row-column-12">
	      <div class="form-content form-content-full-width">
	        <div class="form-group segmented-options settings">

	          <span class="mfn-icon mfn-icon-intro-slider"></span>

	          <div class="setting-label">
	            <h5>Introduction guide</h5>
	            <p>See what`s new in BeBuilder</p>
	          </div>

	          <div class="form-control">
	            <a href="#" class="introduction-reopen">Reopen</a>
	          </div>

	        </div>
	      </div>
	    </div>
	  </div>';

	}

	echo '<div class="mfn-form-row mfn-row">
    <div class="row-column row-column-12">
      <div class="form-content form-content-full-width">
        <div class="form-group segmented-options settings">

          <span class="mfn-icon mfn-icon-shortcuts"></span>

          <div class="setting-label">
            <h5>Keyboard shortcuts</h5>
            <p>List of available shortcuts</p>
          </div>

          <div class="form-control">
            <a href="#" class="shortcutsinfo-open">Open</a>
          </div>

        </div>
      </div>
    </div>
  </div>';

	echo '<div class="mfn-form-row mfn-row">
	  <div class="row-column row-column-12">
			<div class="form-content form-content-full-width">
			  <div class="form-group segmented-options settings">

					<span class="mfn-icon mfn-icon-dynamic-data"></span>

					<div class="setting-label">
					  <h5>Dynamic data</h5>
					  <p>List of dynamic data tags</p>
					</div>

					<div class="form-control">
					  <a href="#" class="dynamicdatainfo-open">Open</a>
				</div>

			  </div>
			</div>
	  </div>
	</div>';

	echo '<div class="mfn-form-row mfn-row">
	  <div class="row-column row-column-12">
	    <div class="form-content form-content-full-width">
	      <div class="form-group segmented-options single-segmented-option settings">

	        <span class="mfn-icon mfn-icon-navigation"></span>

	        <div class="setting-label">
	          <h5>Navigation</h5>
	        </div>

	        <div class="form-control" data-option="mfn-modern-nav">
	          <ul>
	            <li class="active" data-value="1"><a href="#"><span class="text">Modern</span></a></li>
	            <li data-value="0"><a href="#"><span class="text">Classic</span></a></li>
	          </ul>
	        </div>

	      </div>
	    </div>
	  </div>
	</div>';

	echo '<div class="mfn-form-row mfn-row">
	  <div class="row-column row-column-12">
	    <div class="form-content form-content-full-width">
	      <div class="form-group segmented-options single-segmented-option settings">

	        <span class="mfn-icon mfn-icon-column"></span>

	        <div class="setting-label">
	          <h5>Column text editor</h5>
	          <p>CodeMirror or TinyMCE</p>
	          <a class="settings-info" title="Important info" data-tooltip="A page reload is required. Please save your content." href="#">Important info</a>
	        </div>

	        <div class="form-control" data-option="column-visual">
	          <ul>
	            <li class="active" data-value="0"><a href="#"><span class="text">Code</span></a></li>
	            <li data-value="1"><a href="#"><span class="text">Visual</span></a></li>
	          </ul>
	        </div>

	      </div>
	    </div>
	  </div>
	</div>';


	echo '<div class="mfn-form-row mfn-row">
	  <div class="row-column row-column-12">
	    <div class="form-content form-content-full-width">
	      <div class="form-group segmented-options single-segmented-option settings">

	        <span class="mfn-icon mfn-icon-dark-mode"></span>

	        <div class="setting-label">
	          <h5>UI Mode</h5>
	        </div>

	        <div class="form-control" data-option="ui-theme">
	          <ul>
	            <li class="active" data-value="mfn-ui-auto"><a href="#"><span class="text">Auto</span></a></li>
	            <li data-value="mfn-ui-light"><a href="#"><span class="text">Light</span></a></li>
	            <li data-value="mfn-ui-dark"><a href="#"><span class="text">Dark</span></a></li>
	          </ul>
	        </div>

	      </div>
	    </div>
	  </div>
	</div>';

echo '</div>
</div>';
