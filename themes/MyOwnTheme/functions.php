<?php
require get_theme_file_path('/include/custom_search_api.php');
require get_theme_file_path('/include/custom_like_api.php');
function pageBanner($args = NULL)
{

    if (!isset($args['title'])) {
        $args['title'] = get_the_title();
    }
    if (!isset($args['subtitle'])) {
        $args['subtitle'] = get_field('page_banner_subtitle');
    }

    if (!isset($args['photo'])) {
        if (get_field('page_banner_background_image')) {
            $args['photo'] = get_field('page_banner_background_image')['url'];
        } else {
            $args['photo'] = get_theme_file_uri('images/ocean.jpg');
        }
    }

?>

    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url(<?php echo $args['photo']
                                                                        ?>);"></div>
        <div class="page-banner__content container container--narrow">

            <h1 class="page-banner__title"><?php echo $args['title'] ?></h1>
            <div class="page-banner__intro">
                <p><?php echo $args['subtitle']; ?></p>
            </div>
        </div>
    </div>
<?php }
function university_file()
{
    wp_enqueue_style('fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font_awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');

    wp_enqueue_style('main_css_file', get_stylesheet_uri());
    wp_enqueue_script('main-university-js', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);
    wp_enqueue_script('main-js', get_theme_file_uri('/src/index.js'), array('jquery'));
    wp_enqueue_style('our-main-styles-vendor', get_theme_file_uri('/build/index.css'));
    // wp_enqueue_style('our-main-styles', get_theme_file_uri('/build/style-index.css'));

    wp_localize_script('main-university-js', 'universityData', array(
        'root_url' => get_site_url(),
        'nonce' => wp_create_nonce('wp_rest')
    ));
}
add_action('wp_enqueue_scripts', 'university_file');
function add_type_attribute($tag, $handle, $src)
{
    // if not your script, do nothing and return original $tag
    if ('main-js' !== $handle) {
        return $tag;
    }
    // change the script tag by adding type="module" and return it.
    $tag = '<script type="module" src="' . esc_url($src) . '"></script>';
    return $tag;
}
add_filter('script_loader_tag', 'add_type_attribute', 10, 3);

function features()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_image_size('pageBanner', 1500, 350, true);
}

add_action('after_setup_theme', 'features');

function university_adjust_queries($query)
{
    if (!is_admin() and is_post_type_archive('event') and $query->is_main_query()) {
        $today = date('Ymd');
        $query->set('meta_key', 'event_date');
        $query->set('orderby', 'meta_value_num');
        $query->set('order', 'ASC');
        $query->set('meta_query', array(
            array(
                'key' => 'event_date',
                'compare' => '>=',
                'value' => $today,
                'type' => 'numeric'
            )
        ));
    }

    if (!is_admin() and is_post_type_archive('program') and $query->is_main_query()) {
        $query->set('orderby', 'title');
        $query->set('order', 'ASC');
        $query->set('post_per_page', -1);
    }
}
add_action('pre_get_posts', 'university_adjust_queries');

function universityMapKey($api)
{
    $api['key'] = 'AIzaSyCPQwBiWsMW7TeK58DXvgneN5RE48-8gbg';
    return $api;
}
add_filter('acf/fields/google_map/api', 'universityMapKey');

function university_custom_rest()
{
    register_rest_field('post', 'authorName', array(
        'get_callback' => function () {
            return get_the_author();
        }
    ));

    register_rest_field('note', 'countNote', array(
        'get_callback' => function () {
            return count_user_posts(get_current_user_id(),'note');
        }
    ));
}
add_action('rest_api_init', 'university_custom_rest');


//Redireect user

add_action('admin_init', 'redirectUser');

function redirectUser()
{
    $auth_user = wp_get_current_user();
    if (count($auth_user->roles) == 1 and $auth_user->roles[0] == 'subscriber') {
        wp_redirect(site_url('/'));
        exit;
    }
}


add_action('wp_loaded', 'hideBar');

function hideBar()
{
    $auth_user = wp_get_current_user();
    if (count($auth_user->roles) == 1 and $auth_user->roles[0] == 'subscriber') {
        show_admin_bar(false);
    }
}

//Customise login screen
add_filter('login_headerurl', 'ourHeaderUrl');

function ourHeaderUrl()
{
    return esc_url(site_url('/'));
}

add_action('login_enqueue_scripts', 'loginCSS');

function loginCSS()
{
    // wp_enqueue_style('fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('main_css_file', get_stylesheet_uri());
}

add_filter('login_headertitle', 'loginTitle');

function loginTitle()
{
    return get_bloginfo('name');
}

//force notes to be private
add_filter('wp_insert_post_data', 'makeNotePrivate',10,2);

function makeNotePrivate($data, $postarr)
{
    if ($data['post_type'] == 'note') {
        if(count_user_posts(get_current_user_id(), 'note') > 4 AND !$postarr['ID']){
            die("limit exceeded");
        }
        $data['post_content'] = sanitize_textarea_field($data['post_content']);
        $data['post_title'] = sanitize_text_field($data['post_title']);
    }
    if ($data['post_type'] == 'note' and $data['post_status'] != 'trash') {
        $data['post_status'] = 'private';
    }
    return $data;
}
