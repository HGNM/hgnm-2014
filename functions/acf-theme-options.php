<?php
function hgnm_theme_options()
{
    // Add an options page with hgnm-2014 theme settings
    if (function_exists('acf_add_options_page')) {
        acf_add_options_page(array(
            'page_title' => 'HGNM Theme Options',
            'menu_title' => 'HGNM Options',
            'menu_slug'  => 'theme-options',
            'capability' => 'edit_theme_options',
            'redirect'   => false,
            'position'   => '59.5'
        ));
    }

    // Register custom fields group for options page
    if (function_exists('acf_add_local_field_group')) {
        acf_add_local_field_group(array(
            'key' => 'group_5c7196bbe61a4',
            'title' => 'Theme Options',
            'fields' => array(
                array(
                    'key' => 'field_5c7196ea902e8',
                    'label' => 'Colloquium Location (short)',
                    'name' => 'colloquium_location_short',
                    'type' => 'text',
                    'instructions' => 'This will be display the colloquium location on upcoming colloquia pages, e.g. “Room 6”',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => 'Davison Room',
                    'placeholder' => 'Davison Room',
                    'prepend' => '',
                    'append' => ', Harvard University Music Building',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'field_5c71972c902e9',
                    'label' => 'Colloquium Time & Location (long)',
                    'name' => 'colloquium_location_long',
                    'type' => 'text',
                    'instructions' => 'This will display colloquium information below the upcoming colloquia list on the home page and on the events page, e.g. “All colloquia are at 12pm in Room 6”',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => 'All colloquia are at 12pm in the Davison Room',
                    'placeholder' => 'All colloquia are at 12pm in the Davison Room',
                    'prepend' => '',
                    'append' => ', Harvard University Music Building',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'field_5c719a8d6ef4c',
                    'label' => 'Front Page Facebook Link Text',
                    'name' => 'front_page_facebook_link_text',
                    'type' => 'text',
                    'instructions' => 'This is the text that will be shown on the link to the HGNM Facebook page on the home page. It will be followed by a Facebook logo icon.',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => 'Join us on Facebook',
                    'placeholder' => 'Join us on Facebook',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
                array(
                    'key' => 'field_5c7199e7c0ce0',
                    'label' => 'Front Page Archive Link Text',
                    'name' => 'front_page_archive_link_text',
                    'type' => 'text',
                    'instructions' => 'This text will be displayed on the large archive link at the bottom of the home page, e.g. “Dive into an archive of HGNM’s past events, members, audio and video.”',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => 'Dive into an archive of HGNM’s past events, members, audio and video.',
                    'placeholder' => 'Dive into an archive of HGNM’s past events, members, audio and video.',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'options_page',
                        'operator' => '==',
                        'value' => 'theme-options',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'seamless',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => 1,
            'description' => 'These options allow users to configure site-wide content and vocabulary',
        ));
    }
}
add_action('acf/init', 'hgnm_theme_options');
