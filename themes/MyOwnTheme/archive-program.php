<?php

get_header();
pageBanner(
  array(
    'title' => 'All programs',
    'subtitle' => 'There is something for everyone'
  )

) ?>



<div class="container container--narrow page-section">
  <ul class="link-list min-list">
    <?php

    while (have_posts()) {
      the_post(); ?>
      <a href="<?php the_permalink(); ?>">
        <li>
          <?php the_title(); ?>
        </li>
      </a>
    <?php }
    echo paginate_links();
    ?>
  </ul>

</div>

<?php get_footer();

?>