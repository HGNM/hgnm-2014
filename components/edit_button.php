<?php
if (!function_exists('edit_button')) {
  /**
   * Display an edit button if the user has the right permissions
   */
  function edit_button()
  {
    if (current_user_can('edit_posts')) {
      echo '<a href="' . get_edit_post_link() . '" class="edit-button">Edit</a>';
    }
  }
}

edit_button()
?>
