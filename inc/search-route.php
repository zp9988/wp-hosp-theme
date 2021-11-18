<?php

add_action('rest_api_init', 'uSearch');

function uSearch()
{
  register_rest_route('heart/v1', 'search', array(
    'methods' => WP_REST_SERVER::READABLE,
    'callback' => 'u_SearchResults'
  ));
}

function u_SearchResults($data)
{
  $mainQuery = new WP_Query(array(
    'post_type' => array('post', 'page', 'doctor', 'specialty', 'location', 'event'),
    's' => sanitize_text_field($data['term'])
  ));

  $results = array(
    'generalInfo' => array(),
    'doctors' => array(),
    'specialties' => array(),
    'events' => array(),
    'locations' => array()
  );

  while ($mainQuery->have_posts()) {
    $mainQuery->the_post();

    if (get_post_type() == 'post' or get_post_type() == 'page') {
      array_push($results['generalInfo'], array(
        'title' => get_the_title(),
        'permalink' => get_the_permalink(),
        'postType' => get_post_type(),
        'authorName' => get_the_author()
      ));
    }

    if (get_post_type() == 'doctor') {
      array_push($results['doctors'], array(
        'title' => get_the_title(),
        'permalink' => get_the_permalink(),
        'image' => get_the_post_thumbnail_url(0, 'professorLandscape')
      ));
    }

    if (get_post_type() == 'specialty') {
      $relatedSpecialtys = get_field('related_specialty');

      if ($relatedSpecialtys) {
        foreach ($relatedSpecialtys as $specialty) {
          array_push($results['specialties'], array(
            'title' => get_the_title($specialty),
            'permalink' => get_the_permalink($specialty)
          ));
        }
      }

      array_push($results['specialties'], array(
        'title' => get_the_title(),
        'permalink' => get_the_permalink(),
        'id' => get_the_id()
      ));
    }

    if (get_post_type() == 'location') {
      array_push($results['locations'], array(
        'title' => get_the_title(),
        'permalink' => get_the_permalink()
      ));
    }

    if (get_post_type() == 'event') {
      $eventDate = new DateTime(get_field('event_date'));
      $description = null;
      if (has_excerpt()) {
        $description = get_the_excerpt();
      } else {
        $description = wp_trim_words(get_the_content(), 18);
      }

      array_push($results['events'], array(
        'title' => get_the_title(),
        'permalink' => get_the_permalink(),
        'month' => $eventDate->format('M'),
        'day' => $eventDate->format('d'),
        'description' => $description
      ));
    }
  }

  if ($results['specialties']) {
    $specialtiesMetaQuery = array('relation' => 'OR');

    foreach ($results['specialties'] as $item) {
      array_push($specialtiesMetaQuery, array(
        'key' => 'related_programs',
        'compare' => 'LIKE',
        'value' => '"' . $item['id'] . '"'
      ));
    }

    $specialtyRelationshipQuery = new WP_Query(array(
      'post_type' => array('professor', 'event'),
      'meta_query' => $specialtiesMetaQuery
    ));

    while ($specialtyRelationshipQuery->have_posts()) {
      $specialtyRelationshipQuery->the_post();

      if (get_post_type() == 'event') {
        $eventDate = new DateTime(get_field('event_date'));
        $description = null;
        if (has_excerpt()) {
          $description = get_the_excerpt();
        } else {
          $description = wp_trim_words(get_the_content(), 18);
        }

        array_push($results['events'], array(
          'title' => get_the_title(),
          'permalink' => get_the_permalink(),
          'month' => $eventDate->format('M'),
          'day' => $eventDate->format('d'),
          'description' => $description
        ));
      }

      if (get_post_type() == 'doctor') {
        array_push($results['doctors'], array(
          'title' => get_the_title(),
          'permalink' => get_the_permalink(),
          'image' => get_the_post_thumbnail_url(0, 'professorLandscape')
        ));
      }
    }

    $results['doctors'] = array_values(array_unique($results['doctors'], SORT_REGULAR));
    $results['events'] = array_values(array_unique($results['events'], SORT_REGULAR));
  }


  return $results;
}
