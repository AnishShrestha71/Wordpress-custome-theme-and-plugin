<!DOCTYPE html>
<html lang="en">

<head>
  <?php wp_head() ?>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title></title>
</head>

<body>
  <header class="site-header">
    <div class="container">
      <h1 class="school-logo-text float-left">
        <a href="#"><strong>Fictional</strong> University</a>
      </h1>

      <span class="js-search-trigger site-header__search-trigger"><i class="fa fa-search" aria-hidden="true"></i></span>
      <i class="site-header__menu-trigger fa fa-bars" aria-hidden="true"></i>
      <div class="site-header__menu group">
        <nav class="main-navigation">
          <ul>
            <li><a href="<?php echo site_url('/about'); ?>">About Us</a></li>
            <li><a href="<?php echo get_post_type_archive_link('program'); ?>">Programs</a></li>
            <li><a href="<?php echo get_post_type_archive_link('event'); ?>">Events</a></li>
            <li><a href="#">Campuses</a></li>
            <li><a href="#">Blog</a></li>
          </ul>
        </nav>
        <div class="site-header__util">
          <?php if (is_user_logged_in()) { ?>
            <span class="site-header__avatar"><?php echo get_avatar(get_current_user_id(),60) ?></span>
            <a href="<?php echo wp_logout_url(); ?>" class="btn btn--small btn--dark-orange float-left">Log Out</a>
          <?php  } else { ?>

            <a href="<?php echo wp_login_url() ?>" class="btn btn--small btn--orange float-left push-right">Login</a>
            <a href="<?php echo Wp_registration_url() ?>" class="btn btn--small btn--dark-orange float-left">Sign Up</a>

          <?php }
          ?>

          <span class="search-trigger js-search-trigger"><i class="fa fa-search" aria-hidden="true"></i></span>
        </div>
      </div>
    </div>
  </header>