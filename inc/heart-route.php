<?php

add_action('rest_api_init', 'LikeRoutes');

function LikeRoutes()
{
    register_rest_route('heart/v1', 'manageLike', array(
        'methods' => 'POST',
        'callback' => 'addLike'
    ));

    register_rest_route('heart/v1', 'manageLike', array(
        'methods' => 'DELETE',
        'callback' => 'removeLike'
    ));
}

function addLike($data)
{
    if (is_user_logged_in()) {
        $doctor = sanitize_text_field($data['doctorId']);

        $existQuery = new WP_Query(array(
            'author' => get_current_user_id(),
            'post_type' => 'like',
            'meta_query' => array(
                array(
                    'key' => 'liked_id',
                    'compare' => '=',
                    'value' => $doctor
                )
            )
        ));

        if ($existQuery->found_posts == 0 and get_post_type($doctor) == 'doctor') {
            return wp_insert_post(array(
                'post_type' => 'like',
                'post_status' => 'publish',
                'post_title' => '2nd PHP Test',
                'meta_input' => array(
                    'liked_id' => $doctor
                )
            ));
        } else {
            die("Invalid doctor id");
        }
    } else {
        die("Only logged in users can create a like.");
    }
}

function removeLike($data)
{
    $likeId = sanitize_text_field($data['like']);
    if (get_current_user_id() == get_post_field('post_author', $likeId) and get_post_type($likeId) == 'like') {
        wp_delete_post($likeId, true);
        return 'Congrats, like deleted.';
    } else {
        die("You do not have permission to delete that.");
    }
}
