<?php
if (!function_exists('edit_button')) {
    /**
     * Display an edit button if the user has the right permissions
     * @return string
     */
    function edit_button()
    {
        if (current_user_can('edit_posts')) {
            return '<a href="' . get_edit_post_link() . '" class="edit-button">Edit</a>';
        }
        return '';
    }
}

return edit_button();
