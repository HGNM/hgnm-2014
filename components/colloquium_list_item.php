<?php
if (!function_exists('colloquium_list_item')) {
    /**
     * Get a list item for a colloquium
     * @param  [type] $ID The post ID of the colloquium to display
     * @return string HTML string for an <li> describing a colloquium
     */
    function colloquium_list_item($ID)
    {
        $html = '<li class="vevent clearfix">';

        date_default_timezone_set('America/New_York');
        $dtstart = DateTime::createFromFormat('d/m/Y G:i', (get_field('dtstart', $ID) . ' 12:00'));

        $html .=  '<h4 class="dtstart">' .
                    '<time class="value-title" ' .
                      'datetime="'. $dtstart->format('Y-m-d\TH:i:sO') . '" ' .
                      'title="' . $dtstart->format('Y-m-d\TH:i:sO') . '">' .
                      $dtstart->format('n/j') .
                    '</time>' .
                  '</h4>' .
                  '<span class="summary">';

        $type = get_field('colloquium_type', $ID);
        if ($type == 'HGNM Member') {
            $composerid = get_field('fname', $ID);

            $html .= '<a href="' . esc_url(get_permalink($composerid->ID)) . '" class="url">' .
                      get_the_title($ID) .
                    '</a>';
        } elseif ($type == 'Guest Speaker') {
            if (get_field('url', $ID)) {
                $html .= '<a href="' . esc_url(get_field('url', $ID)) . '" class="url" target="_blank">' .
                      get_the_title($ID) .
                      component('icon', array(
                        'type' => 'link-ext',
                        'color' => 'light'
                      )) .
                    '</a>';
            } else {
                $html .= get_the_title($ID);
            }
        } elseif ($type == 'Post-Concert Discussion') {
            $html .= $type . ': ' . get_the_title($ID);
        } else {
            // If none of the above types (shouldn’t happen, but who knows…)
            $html .= get_the_title($ID);
        }
        $html .=  '</span>' .
                  '<span class="location vcard">' .
                    '<span class="fn org">' .
                      '<span class="value-title" title="Harvard University Department of Music"></span>' .
                    '</span>' .
                    '<span class="adr">' .
                      '<span class="street-address">' .
                        '<span class="value-title" title="North Yard, Harvard University"></span>' .
                      '</span>' .
                      '<span class="locality">' .
                        '<span class="value-title" title="Cambridge"></span>' .
                      '</span>' .
                      '<span class="region">' .
                        '<span class="value-title" title="MA"></span>' .
                      '</span>' .
                      '<span class="postal-code">' .
                        '<span class="value-title" title="02138"></span>' .
                      '</span>' .
                    '</span>' .
                    '<span class="geo">' .
                       '<span class="latitude">' .
                          '<span class="value-title" title="42.377009" ></span>' .
                       '</span>' .
                       '<span class="longitude">' .
                          '<span class="value-title" title="-71.117042"></span>' .
                       '</span>' .
                    '</span><!-- .geo -->' .
                  '</span><!-- .location.vcard -->' .
                  '<span class="category">' .
                    '<span class="value-title" title="Colloquium"></span>' .
                  '</span>' .
                '</li>';

        return $html;
    }
}
