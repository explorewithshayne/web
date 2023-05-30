<?php
  $translate['livesearch-noresults'] = mfn_opts_get('translate') ? mfn_opts_get('translate-livesearch-noresults','Not found text') : __('Not found text','betheme');
  $translate['livesearch-button'] = mfn_opts_get('translate') ? mfn_opts_get('translate-livesearch-button','See all results') : __('See all results','betheme');
?>

<div class="mfn-live-search-box" style="display:none">

  <ul class="mfn-live-search-list">
    <li class="mfn-live-search-list-categories"><ul></ul></li>
    <li class="mfn-live-search-list-shop"><ul></ul></li>
    <li class="mfn-live-search-list-blog"><ul></ul></li>
    <li class="mfn-live-search-list-pages"><ul></ul></li>
    <li class="mfn-live-search-list-portfolio"><ul></ul></li>
  </ul>

	<span class="mfn-live-search-noresults"><?php esc_html_e($translate['livesearch-noresults']) ?></span>

	<a class="button button_theme hidden"><?php esc_html_e($translate['livesearch-button']) ?></a>

</div>
