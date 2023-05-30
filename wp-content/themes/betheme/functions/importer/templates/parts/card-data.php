<?php
	defined( 'ABSPATH' ) || exit;
?>

<!-- Demo data -->

<div class="mfn-dashboard-card mfn-setup-card card-data" data-step="data">

  <div class="card-header">
    <h2>Pre-built content</h2>
    <p>Choose if you want to import complete website or selected data only.</p>
    <h2 class="inner-navigation prev">Pre-built websites</h2>
  </div>

  <ul class="choose choose-big import-options">

    <li data-type="complete" class="active">
      <h4>Complete website</h4>
      <p>Import all data, including images, videos, etc. Recreates complete website 1:1</p>
      <div class="select-inner">
        <span data-type="attachments" class="active">Import media (images, videos, etc.)</span>
        <span data-type="sliders" class="active">Import Revolution Slider demo</span>
      </div>
    </li>

    <li data-type="selected">
      <h4>Selected data only</h4>
      <p>Import the data you need. Best choice if you need a single thing from specific demo.</p>
      <div class="select-inner">
        <span data-type="content" class="radio active">Content</span>
        <span data-type="options"class="radio">Theme Options</span>
        <span data-type="sliders" class="radio">Revolution Slider demo</span>
      </div>
    </li>

  </ul>

</div>
