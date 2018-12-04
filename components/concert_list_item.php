<?php
if (!function_exists('concert_list_item')) {
    /**
     * Get a concert link component with date, performer name & venue
     * @param  array  $opts Options array with keys id and el
     * @return string       HTML string for the component
     */
    function concert_list_item(array $opts)
    {
        $ID = $opts['id'];
        $EL = array_key_exists('el', $opts) ? $opts['el'] : 'li';

        $html = '<' . $EL . ' class="vevent concert-list__item clearfix">' .
                  '<a href="' . get_permalink($ID) . '" class="url">';

        // SET START TIME VARIABLE
        if (get_field('start_time')) {
            $start_time = get_field('start_time', $ID);
        }
        // SET TIMEZONE
        date_default_timezone_set('America/New_York');

        // SET START DATE VARIABLE
        if (!empty($start_time)) {
            $dtstart = DateTime::createFromFormat('d/m/Y G:i', (get_field('dtstart', $ID) . ' ' . $start_time));
        } else {
            $dtstart = DateTime::createFromFormat('d/m/Y G:i', (get_field('dtstart', $ID) . ' 20:00'));
        }

        $html .=    '<h4 class="dtstart">' .
                      '<time class="value-title" ' .
                      'datetime="' . $dtstart->format('Y-m-d\TH:i:sO') . '" ' .
                      'title="' . $dtstart->format('Y-m-d\TH:i:sO') . '">' .
                        '<span class="month">' .
                          $dtstart->format('M') .
                        '</span> ' .
                        '<span class="day">' .
                          $dtstart->format('j') .
                        '</span>' .
                      '</time>' .
                    '</h4>' .
                    '<div class="details">' .
                      '<p class="summary">' .
                        get_the_title($ID) .
                      '</p>' .
                      '<p class="location vcard">' .
                        get_field('location', $ID) .
                        '<span class="fn org" aria-hidden="true">' .
                          '<span class="value-title" title="Paine Hall, Harvard University Department of Music"></span>' .
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
                            '<span class="geo">' .
                              '<span class="latitude">' .
                                '<span class="value-title" title="42.377009" ></span>' .
                              '</span>' .
                              '<span class="longitude">' .
                                '<span class="value-title" title="-71.117042"></span>' .
                              '</span>' .
                            '</span>' .
                          '</span>' .
                        '</span>' .
                      '</p>' .
                    '</div>' .
                  '</a>' .
                  '<span class="category" aria-hidden="true">' .
                    '<span class="value-title" title="Concert"></span>' .
                  '</span>' .
                "</$EL>";
        return $html;
    }
}
