<footer class="site-footer">

  <div class="site-footer__inner container container--narrow">

    <div class="group">

      <div class="site-footer__col-one">
        <h1 class="logo-text logo-text--alt-color"><a href="<?php echo site_url() ?>">Some <strong>Hospital</strong></a></h1>
        <p><a class="site-footer__link" href="#">888.888.8888</a></p>
      </div>

      <div class="site-footer__col-two-three-group">
        <div class="site-footer__col-two">
          <h3 class="headline headline--small">Explore</h3>
          <nav class="nav-list">
            <ul>
              <li><a href="<?php echo site_url('/about-us') ?>">About Us</a></li>
              <li><a href="<?php echo get_post_type_archive_link('specialty') ?>">Specialties</a></li>
              <li><a href="<?php echo get_post_type_archive_link('event'); ?>">Events</a></li>
              <li><a href="<?php echo get_post_type_archive_link('location'); ?>">Locations</a></li>
            </ul>
          </nav>
        </div>

        <div class="site-footer__col-three">
          <h3 class="headline headline--small">Learn</h3>
          <nav class="nav-list">
            <ul>
              <li><a href="#">Legal</a></li>
              <li><a href="<?php echo site_url('/privacy-policy') ?>">Privacy</a></li>
              <li><a href="#">Careers</a></li>
            </ul>
          </nav>
        </div>
      </div>

      <div class="site-footer__col-four">
        <h3 class="headline headline--small">Connect With Us</h3>
        <nav>
          <ul class="min-list social-icons-list group">
            <li><a href="#" class="social-color-facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
            <li><a href="#" class="social-color-twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
            <li><a href="#" class="social-color-youtube"><i class="fa fa-youtube" aria-hidden="true"></i></a></li>
            <li><a href="#" class="social-color-linkedin"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
            <li><a href="#" class="social-color-instagram"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
          </ul>
        </nav>
      </div>
    </div>

  </div>
</footer>

<?php wp_footer(); ?>
</body>

</html>