<?php
if (!function_exists('responsive_embed')) {
    /**
     * Wrap an embedded iframe to make it responsive to browser size
     * @param  string $media The media to embed
     * @return string HTML string for the wrapped media embed
     */
    function responsive_embed($media)
    {
        // find iframe src
        preg_match('/src="(.+?)"/', $media, $matches);
        if (isset($matches[1])) {
            $src = $matches[1];
            // remove original src attribute
            $media = str_replace($src, '', $media);
            // add data-src and lozad class for lazy loading
            $attrs = 'data-src="' . $src . '" class="lozad"';
            $media = str_replace('></iframe>', ' ' . $attrs . '></iframe>', $media);
        }
        $html = '<span class="embed-container">';
        $html .= $media;
        $html .= '</span>';
        return $html;
    }
}
