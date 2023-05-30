<article id="websites">

  <?php
    // do NOT delete, isotope ajax loaded websites image height fix
    $placeholder = get_theme_file_uri( '/functions/admin/setup/assets/images/placeholder.png' );
    echo '<img style="visibility:hidden;height:1px;oveflow:hidden" src="'. esc_url($placeholder) .'" alt=""/>';
  ?>

  <div class="search-wrapper">
    <div class="input-wrapper">
      <i class="icon-search-line"></i>
      <!-- <i class="icon-cancel-fine"></i> -->
      <input class="search" type="text" placeholder="Search for a website" autocomplete="off">
      <!-- <span class="close"></span> -->
    </div>
  </div>

  <div class="websites-group clearfix">

    <aside class="filters">
      <div class="sidebar__inner">

        <div class="filters-group first">
          <h4>Layout</h4>
          <nav>
            <ul class="layout" data-filter-group="layout">
              <?php
                foreach ($this->layouts as $key_layout => $layout) {
                  echo '<li data-count="'. $this->count['layouts'][$key_layout] .'" data-filter=".'. $key_layout .'"><a href="#">'. $layout .'</a></li>';
                }
               ?>
            </ul>
          </nav>
        </div>

        <div class="filters-group second">
          <h4>Subject</h4>
          <nav>
            <ul class="subject" data-filter-group="subject">
              <?php
                foreach ($this->categories as $key_category => $category) {
                  echo '<li data-count="'. $this->count['categories'][$key_category] .'" data-filter=".'. $key_category .'"><a href="#">'. $category .'</a></li>';
                }
              ?>
            </ul>
          </nav>
        </div>

      </div>
    </aside>

    <section class="websites">

      <div class="results" data-count="<?php echo $this->count['all'];?>"><strong>All <?php echo $this->count['all'];?></strong> pre-built websites</div>

      <div class="websites-iso">
        <?php $this->the_websites( 0, $this->count['all'] ); ?>
      </div>

    </section>

  </div>

  <!-- <section class="show-all center mb-big">
    <a class="button" href="#"><span>Show all 650+ websites</span></a>
  </section> -->

</article>
