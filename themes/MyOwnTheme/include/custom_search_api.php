<?php
add_action('rest_api_init', 'universityRegisterSearch');

function universityRegisterSearch()
{
    register_rest_route('university/v1', 'search', array(
        'methods' => WP_REST_SERVER::READABLE,
        'callback' => 'universitySearchResults'
    ));
}

function universitySearchResults($data)
{
    $mainQuery = new WP_Query(array(
        'post_type' => array(
            'post',
            'page',
            'professor',
            'program',
            'event'
        ),
        's' => sanitize_text_field($data['term'])
    ));

    $mainQueryResults = array(
        'generalInfo' => array(),
        'professor' => array(),
        'programs' => array(),
        'events' => array()
    );

    while ($mainQuery->have_posts()) {
        $mainQuery->the_post();

        if (get_post_type() == 'post' or get_post_type() == 'page') {
            array_push($mainQueryResults['generalInfo'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'post_type' => get_post_type(),
                'authorName' => get_the_author()
            ));
        }

        if (get_post_type() == 'professor') {
            array_push($mainQueryResults['professor'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink()
            ));
        }

        if (get_post_type() == 'event') {
            $eventDate = new DateTime(get_field('event_date'));
            $description =  null;
            if (has_excerpt()) {
                $description = get_the_excerpt();
            } else {
                $description = wp_trim_words(get_the_content(), 10);
            }
            array_push($mainQueryResults['events'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'month' => $eventDate->format('M'),
                'day' => $eventDate->format('d'),
                'description' => $description
            ));
        }

        if (get_post_type() == 'program') {



            array_push($mainQueryResults['programs'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'id' => get_the_id()

            ));
        }

        $metaQuery = array('relation' => 'OR');


        if($mainQueryResults['programs']){
            foreach ($mainQueryResults['programs'] as $item) {
                array_push($metaQuery, array(
                    'key' => 'related_programs',
                    'compare' => 'LIKE',
                    'value' => '"' . $item['id'] . '"'
                ));
            }
    
            $realtionshipQuery = new WP_Query(array(
                'post_type' => 'professor',
                'meta_query' => $metaQuery
            ));
    
            while ($realtionshipQuery->have_posts()) {
                $realtionshipQuery->the_post();
    
                if (get_post_type() == 'professor') {
                    array_push($mainQueryResults['professor'], array(
                        'title' => get_the_title(),
                        'permalink' => get_the_permalink()
                    ));
                }
    
                $mainQueryResults['professor'] = array_values(array_unique($mainQueryResults['professor'], SORT_REGULAR));
            }
        }

        return $mainQueryResults;
    }
}
