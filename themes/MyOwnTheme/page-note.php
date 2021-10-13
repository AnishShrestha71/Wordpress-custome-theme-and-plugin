<?php
if(!is_user_logged_in())
{
  wp_redirect(site_url('/')); 
  exit;
}
get_header(); 


while(have_posts()){
  the_post();
  pageBanner();
}?>

<!-- <div class="page-banner">
  <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg') ?>);"></div>
  <div class="page-banner__content container container--narrow">
    <h1 class="page-banner__title">Notes</h1>
    <div class="page-banner__intro">
      
    </div>
  </div>
</div> -->

<div class="container container--narrow page-section">
  <div class="create-note">
    <h2 class="headline headline--medium">Create new note</h2>
    <input type="text" class="new-note-title" placeholder="title">
    <textarea name="" id="" cols="30" rows="10" class="new-note-body" placeholder="your note here"></textarea>
    <span class="submit-note">Create Note</span>
    <span class="note-limit-message">limit exceeded. Delete to old ones add new</span>
  </div>
<ul class="min-list link-list" id="my-notes">
<?php 

  $userNotes = new WP_Query(
    array(
      'post_type' =>'note',
      'post_per_page' => -1,
      'author' => get_current_user_id()
    )
    );

    while($userNotes->have_posts()){
      $userNotes->the_post();
      ?>
        <li data-id="<?php  the_ID() ?>">
          <input readonly type="text" class="note-title-field" value="<?php echo str_replace('Private: ','',esc_attr(get_the_title()));?>">
          <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true">Edit</i></span>
          <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true">Delete</i></span>
          
          
          <textarea readonly name="" id="" class="note-body-field" cols="30" rows="10"><?php echo esc_attr(wp_strip_all_tags(get_the_content())) ?> </textarea>
          <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true">Save</i></span>
        </li>
      <?php
    }
?>
</ul>
  
</div>

<?php get_footer();

?>