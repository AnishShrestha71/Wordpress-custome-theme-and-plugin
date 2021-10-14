<?php
add_action('rest_api_init', 'likeRoutes');

function likeRoutes()
{
    register_rest_route('university/v1', 'manageLike', array(
        'methods' => 'POST',
        'callback' => 'createLike'
    ));

    register_rest_route('university/v1', 'manageLike', array(
        'methods' => 'DELETE',
        'callback' => 'deleteLike'
    ));
}

function createLike($data)
{
    if (is_user_logged_in()) {
        $professor = sanitize_text_field($data['professor_id']);

        $existQuery = new WP_Query(array(
            'author' => get_current_user_id(),
            'post_type' => 'like',
            'meta_query' => array(

                array(
                    'key' => 'like_professor_id',
                    'compare' => '=',
                    'value' => $professor
                )
            )
        ));

        if (!$existQuery->found_posts AND get_post_type($professor) == 'professor') {
            return wp_insert_post(array(
                'post_type' => 'like',
                'post_status' => 'publish',
                'post_title' => 'liked professor',
                'meta_input' => array(
                    'like_professor_id' => $professor
                )
            ));
        } else {
            die("invalid");
        }
    } else {
        die("You need to be logged in");
    }
}

function deleteLike($data)
{
    $likeID = sanitize_text_field($data['like']);

    if (get_current_user_id() == get_post_field('post_author', $likeID) and get_post_type($likeID) == 'like') {

        wp_delete_post($likeID, false);

        return 'succesfully deleted';
    }else{
        die('not granted permission');
    }
}
