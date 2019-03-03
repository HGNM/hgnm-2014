<?php
if (!function_exists('hgnm_concerts_where')) {
    // custom filter to replace '=' with 'LIKE'
    function hgnm_concerts_where($where)
    {
        return str_replace("meta_key = 'programme_$", "meta_key LIKE 'programme_%", $where);
    }
    add_filter('posts_where', 'hgnm_concerts_where');
}

if (!function_exists('event_query')) {
    /**
     * Get concerts, colloquia & miscevents that match custom query parameters
     * @param  array $opts Options array
     * @return array       Array of post objects that match the query
     */
    function event_query($opts)
    {
        $defaults = array(
            'maxposts' => -1,
            'order' => 'DSC',
            'post_type' => 'concert',
            'has_av' => false,
            'ft_composer' => null,
            'after' => null,
            'before' => null,
        );
        $opts = array_merge($defaults, $opts);

        $meta_queries = array();

        // add a meta query for posts which include embed links
        if ($opts['has_av']) {
            $meta_queries[] = array(
                'key' => 'programme_$_embed_link',
                'value' => 'http',
                'compare' => 'LIKE'
            );
        }

        // add a meta query for concerts & colloquia for specific composer
        if ($opts['ft_composer']) {
            $testID = $opts['ft_composer'];
            if ($opts['post_type'] === 'colloquium') {
                array_push(
                    $meta_queries,
                    array(
                        'key' => 'fname',
                        'value'  => $testID,
                    ),
                    array(
                        'key' => 'colloquium_type',
                        'value'  => 'HGNM Member',
                    )
                );
            } else {
                $meta_queries[] = array(
                    'key' => 'programme_$_composer',
                    'value'  => $testID,
                );
            }
        }

        if ($opts['after']) {
            $date_query = $opts['after'];
            $meta_queries[] = array(
                'relation' => 'OR',
                array(
                    'key' => 'dtstart',
                    'value'  => $date_query,
                    'compare'  => '>='
                ),
                array(
                    'key' => 'dtend',
                    'value' => $date_query,
                    'compare' => '>='
                )
            );
        }

        if ($opts['before']) {
            $date_query = $opts['before'];
            $meta_queries[] = array(
                'key' => 'dtstart',
                'value'  => $date_query,
                'compare'  => '<'
            );
        }

        return get_posts(
            array(
                'suppress_filters' => false,
                'numberposts' => $opts['maxposts'],
                'post_type' => $opts['post_type'],
                'meta_key' => 'dtstart',
                'orderby' => 'dtstart',
                'order' => $opts['order'],
                'meta_query' => $meta_queries
            )
        );
    }
}
