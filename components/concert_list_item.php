<?php
if (!function_exists('concert_list_item')) {
  function concert_list_item(array $opts)
  {
    $ID = $opts['id'];
    $EL = array_key_exists('el', $opts) ? $opts['el'] : 'li';
    ?>
    <<?php echo $EL ?> class="vevent clearfix">
      <a href="<?php echo get_permalink($ID) ?>" class="url">
        <?php
        // SET START TIME VARIABLE
        if (get_field('start_time')) {
          $start_time = get_field('start_time', $ID);
        }
        // SET TIMEZONE
        date_default_timezone_set('America/New_York');

        // SET START DATE VARIABLE
        if (!empty($start_time)) {
          $dtstart = DateTime::createFromFormat('d/m/Y G:i', (get_field('dtstart', $ID) . ' ' . $start_time));
        }
        else {
          $dtstart = DateTime::createFromFormat('d/m/Y G:i', (get_field('dtstart', $ID) . ' 20:00'));
        }
        ?>
        <h4 class="dtstart"><time class="value-title" datetime="<?php echo $dtstart->format('Y-m-d\TH:i:sO'); ?>" title="<?php echo $dtstart->format('Y-m-d\TH:i:sO'); ?>">
          <?php echo '<span class="month">' . $dtstart->format('M') . '</span> <span class="day">' . $dtstart->format('j'); ?>
        </time></h4>
        <div class="details">
          <?php echo '<p class="summary">' . get_the_title($ID) . '</p>'; ?>
          <p class="location vcard"><?php the_field('location', $ID); ?>
            <span class="fn org">
              <span class="value-title" title="Paine Hall, Harvard University Department of Music">
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
          </p>
        </div>
      </a>
      <span class="category">
        <span class="value-title" title="Concert"></span>
      </span>
    </<?php echo $EL ?>>
    <?php
  }
}

concert_list_item($opts)
?>
