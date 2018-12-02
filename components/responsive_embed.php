<?php
if (!function_exists('responsive_embed')) {
    /**
     * Wrap an embedded iframe to make it responsive to browser size
     * @param  string $media The media to embed
     * @return string HTML string for the wrapped media embed
     */
    function responsive_embed($media)
    {
        $html = '<span class="embed-container">';
        $html .= $media;
        $html .= '</span>';
        return $html;
    }
}
