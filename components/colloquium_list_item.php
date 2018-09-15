<?php
if (!function_exists('colloquium_list_item')) {
  /**
   * Get a list item for a colloquium
   * @param  [type] $ID The post ID of the colloquium to display
   */
  function colloquium_list_item($ID)
  {
    ?>
    <li class="vevent clearfix">
      <?php
      date_default_timezone_set('America/New_York');
      $dtstart = DateTime::createFromFormat('d/m/Y G:i', (get_field('dtstart', $ID) . ' 12:00')); ?>
      <h4 class="dtstart">
        <time class="value-title" datetime="<?php echo $dtstart->format('Y-m-d\TH:i:sO'); ?>" title="<?php echo $dtstart->format('Y-m-d\TH:i:sO'); ?>">
        <?php echo $dtstart->format('n/j'); ?>
        </time>
      </h4>
      <span class="summary">
        <?php $type = get_field('colloquium_type', $ID);
        if($type == 'HGNM Member') {
          $composerid = get_field('fname', $ID);
          echo '<a href="' . esc_url( get_permalink($composerid->ID) ) . '" class="url">' . get_the_title($ID) . '</a>';
        }
        elseif($type == 'Guest Speaker') {
          if(get_field('url', $ID)) {
            echo '<a href="' . esc_url( get_field('url', $ID) ) . '" class="url icon-link-ext" target="_blank">' . get_the_title($ID) . '</a>';
          }
          else {
            echo get_the_title($ID);
          }
        }
        elseif($type == 'Post-Concert Discussion') {
          echo $type . ': ' . get_the_title($ID);
        }
        else {
          // If none of the above types (shouldn’t happen, but who knows…)
          echo get_the_title($ID);
        } ?>
      </span>
      <span class="location vcard">
        <span class="fn org">
          <span class="value-title" title="Harvard University Department of Music">
        </span>
        <span class="adr">
          <span class="street-address">
            <span class="value-title" title="North Yard, Harvard University">
          </span>
          <span class="locality">
            <span class="value-title" title="Cambridge">
          </span>
          <span class="region">
            <span class="value-title" title="MA">
          </span>
          <span class="postal-code">
            <span class="value-title" title="02138">
          </span>
        </span>
        <span class="geo">
           <span class="latitude">
              <span class="value-title" title="42.377009" ></span>
           </span>
           <span class="longitude">
              <span class="value-title" title="-71.117042"></span>
           </span>
        </span>
      </span>
      <span class="category">
        <span class="value-title" title="Colloquium"></span>
      </span>
    </li>
    <?php
  }
}

colloquium_list_item($opts);
?>
