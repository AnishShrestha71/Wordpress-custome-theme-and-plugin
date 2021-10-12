<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>

<body>
    <?php get_header() ?>
    <div>
        <?php
        while (have_posts()) {
            the_post(); ?>
            <h2><?php the_title() ?></h2>
            <p><?php the_content(); ?></p>
            <hr>
        <?php }
        ?>
    </div>
    <?php get_footer() ?>
</body>

</html>