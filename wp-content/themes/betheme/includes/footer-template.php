<?php
echo '<footer id="mfn-footer-template" data-id="'.$args['id'].'" class="mfn-footer-tmpl mfn-footer">';
$mfn_footer_builder = new Mfn_Builder_Front($args['id']);
$mfn_footer_builder->show(false, $args['visual']);
echo '</footer>';
