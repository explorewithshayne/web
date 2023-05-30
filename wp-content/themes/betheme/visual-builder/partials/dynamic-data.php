<?php

$arr = [
  [
    'name' => 'Postmeta',
    'code' => '{postmeta:meta_key}',
    'desc' => 'Display post meta value by key',
  ],
  [
    'name' => 'Permalink',
    'code' => '{permalink}',
    'desc' => 'Display permalink of queried post',
  ],
  [
    'name' => 'Permalink',
    'code' => '{permalink:id}',
    'desc' => 'Display permalink of certain post',
  ],
  [
    'name' => 'Date',
    'code' => '{date}',
    'desc' => 'Show publish date of queried post',
  ],
  [
    'name' => 'Date',
    'code' => '{date:id}',
    'desc' => 'Show publish date of certain post',
  ],
  [
    'name' => 'Date Modified',
    'code' => '{date:modified}',
    'desc' => 'Show modified date of queried post',
  ],
  [
    'name' => 'Featured Image',
    'code' => '{featured_image}',
    'desc' => 'Show featured image link of queried post',
  ],
  [
    'name' => 'Featured Image Tag',
    'code' => '{featured_image:tag}',
    'desc' => 'Show featured image of queried post',
  ],
  [
    'name' => 'Categories',
    'code' => '{categories}',
    'desc' => 'Show categories of queried post',
  ],
  [
    'name' => 'Categories',
    'code' => '{categories:id}',
    'desc' => 'Show categories of certain post',
  ],
  [
    'name' => 'Price',
    'code' => '{price}',
    'desc' => 'Show publish price of queried product',
  ],
  [
    'name' => 'Price',
    'code' => '{price:id}',
    'desc' => 'Show price of certain product',
  ],
  [
    'name' => 'Title',
    'code' => '{title}',
    'desc' => 'Show title of queried post',
  ],
  [
    'name' => 'Title',
    'code' => '{title:id}',
    'desc' => 'Show title of post with certain ID',
  ],
  [
    'name' => 'Author',
    'code' => '{author}',
    'desc' => 'Show the author name of queried post',
  ],
  [
    'name' => 'Author',
    'code' => '{author:id}',
    'desc' => 'Show the author name with certain ID',
  ],
  [
    'name' => 'Content',
    'code' => '{content}',
    'desc' => 'Show the content of WP Editor queried post',
  ],
  [
    'name' => 'Content',
    'code' => '{content:id}',
    'desc' => 'Show the content of WP Editor certain post',
  ]
];

?>

<div class="mfn-modal modal-dynamic-data-info">
	<div class="mfn-modalbox mfn-form mfn-shadow-1">

		<div class="modalbox-header">
			<div class="options-group">
				<div class="modalbox-title-group">
					<span class="modalbox-icon mfn-icon-dynamic-data"></span>
					<div class="modalbox-desc">
						<h4 class="modalbox-title">Dynamic Data</h4>
					</div>
				</div>
			</div>
			<div class="options-group">
				<a class="mfn-option-btn mfn-option-blank btn-large btn-modal-close" title="Close" href="#">
					<span class="mfn-icon mfn-icon-close"></span>
				</a>
			</div>
		</div>

		<div class="modalbox-content">
	    <div class="modalbox-heading">
  			<h5>Meet all dynamic data in BeTheme</h5>
        <p>Click to copy to clipboard</p>
      </div>
      <div class="mfn-dd-notbg mfn-dd-type-wrapper mfn-dd-dynamic-set mfn-dd-type-wrapper-'.$d.'">
        <ul>
          <?php
            foreach ($arr as $value) {
              echo '<li><a href="#" data-type="title"><h5>'. $value['name'] .'</h5><span class="mfn-dd-label">'. $value['code'] .'</span><span class="mfn-dd-code">'. $value['desc'] .'</span></a></li>';
            }
          ?>
        </ul>
      </div>
    </div>

	</div>
</div>
