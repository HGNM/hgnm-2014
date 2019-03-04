<?php
if (!function_exists('responsive_card_list')) {
    /**
     * Format an array of items as a grid of cards that collapse to a
     * horizontally scrolling widget on mobile
     * @param  array $opts          Options array
     * @param  array $opts['cards'] Array of HTML strings to wrap
     * @return string HTML string for the responsive card list component
     */
    function responsive_card_list($opts)
    {
        $cards = isset($opts['cards']) ? $opts['cards'] : array();
        if (!is_array($cards)) return '';
        $classes = array('responsive-cards');
        if (count($cards) === 1) $classes[] = 'responsive-cards--single';
        $html = '<div class="' . implode(' ', $classes) . '"><ul class="responsive-cards__list">';
        foreach ($cards as $card) {
            $html .= '<li class="responsive-cards__item">' . $card . '</li>';
        }
        $html .= '</ul></div>';
        return $html;
    }
}
?>
