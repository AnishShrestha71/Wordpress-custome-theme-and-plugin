<?php get_header();

while (have_posts()) {
    the_post();
    pageBanner(); ?>

   

    <div class="container container--narrow page-section">
        <?php if(wp_get_post_parent_id(get_the_id())){?>

        
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p>
                <a class="metabox__blog-home-link" href="<?php echo get_permalink(wp_get_post_parent_id(get_the_id()))?>"><i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo get_the_title(wp_get_post_parent_id(get_the_id()))?> </a> <span class="metabox__main"><?php the_title()?></span>
            </p>
        </div>
    <?php } ?>  
    <?php 
        $testArray = get_pages(array(
            'child_of' => get_the_ID()
        ));
    if(wp_get_post_parent_id(get_the_id()) or $testArray){
        ?>
   
        <div class="page-links">
            <h2 class="page-links__title"><a href="#">About Us</a></h2>
            <ul class="min-list">
                <?php if(wp_get_post_parent_id(get_the_id()))
                {
                    $childof = wp_get_post_parent_id(get_the_id());
                }else{
                    $childof = get_the_ID();
                }
                
                ?>
               <?php wp_list_pages(array(
                    'title_li' => NULL,
                    'child_of' => $childof
                ));?>
                
            </ul>
        </div>
            <?php } ?>
        <div class="generic-content">
            <p><?php the_content();  ?></p>

        </div>
    </div>


<?php }
get_footer() ?>