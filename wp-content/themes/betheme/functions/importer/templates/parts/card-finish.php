<?php
	defined( 'ABSPATH' ) || exit;
?>

<!-- Finish -->

<div class="mfn-dashboard-card mfn-setup-card card-finish" data-step="finish">

  <div class="card-header">
    <span class="mfm-icon mfn-icon-yes-green"></span>
    <h2>Congratulations!</h2>
		<h5>You have successfully installed your&nbsp;website.</h5>
  </div>

  <div class="congratulations mfn-row">

    <div class="row-column row-column-6 row-column-center">

			<p>Regenerate thumbnail sizes for all images that have been uploaded to your media library with demo content.</p>
			<p>You can do it later in <a target="_blank" href="admin.php?page=be-tools">Betheme > Tools</a></p>
      <a class="mfn-btn btn-large mfn-regenerate-thumbnails" href="#">Regenerate thumbnails</a>

      <a target="_blank" class="mfn-btn mfn-btn-blue btn-large" href="<?php echo esc_url( get_home_url() ); ?>">Check your website</a>

		</div>

    <div class="row-column row-column-6">
      <h5>Here’s what to do next:</h5>
      <ul class="useful-links">
        <li><span class="mfn-icon mfn-icon-be"></span> <a href="admin.php?page=betheme">Go to Dashboard</a></li>
        <li><span class="mfn-icon mfn-icon-support"></span> <a target="_blank" href="https://support.muffingroup.com/documentation/">Check our documentation</a></li>
        <li><span class="mfn-icon mfn-icon-video-tutorials"></span> <a target="_blank" href="https://support.muffingroup.com/video-tutorials/">See our video tutorials</a></li>
        <li><span class="mfn-icon mfn-icon-support-faq"></span> <a target="_blank" href="https://support.muffingroup.com/faq/">Frequently Asked Questions</a></li>
        <li><span class="mfn-icon mfn-icon-community"></span> Join our Community<a class="mfn-social-fb" target="_blank" href="https://www.facebook.com/groups/betheme/"><i class="icon-facebook"></i></a><a class="mfn-social-tw" target="_blank" href="https://www.youtube.com/user/MuffinGroup"><i class="icon-youtube"></i></a></li>
      </ul>
    </div>

  </div>

  <h5>How much did you like it?</h5>
  <ul class="mfn-rating">
    <li class="star" data-rating="1"><a href="#"><span class="mfn-icon mfn-icon-rating-1"></span>Terrible</a></li>
    <li class="star" data-rating="2"><a href="#"><span class="mfn-icon mfn-icon-rating-2"></span>Bad</a></li>
    <li class="star" data-rating="3"><a href="#"><span class="mfn-icon mfn-icon-rating-3"></span>Ok</a></li>
    <li class="star" data-rating="4"><a href="#"><span class="mfn-icon mfn-icon-rating-4"></span>Good</a></li>
    <li class="star" data-rating="5"><a href="#"><span class="mfn-icon mfn-icon-rating-5"></span>Great</a></li>
  </ul>

	<h5 class="rating-thanks">Thank you for sharing your experience with us.</h5>

</div>
