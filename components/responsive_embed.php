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
        } elseif (strncmp($media, '<a', 2) === 0) {
            // if an iframe fails to generate $media is passed as a link tag
            // in that case, try to show a basic iframe with the link’s source
            // as the iframe’s source
            preg_match('/href="(.+?)"/', $media, $href_matches);
            if (isset($href_matches[1])) {
                $src = $href_matches[1];
                $media = '<iframe class="lozad" scrolling="no" frameborder="no" data-src="' . $src . '"></iframe>';
            }
        }
        $html = '<span class="embed-container">';
        $html .= $media;
        $html .= '</span>';
        return $html;
    }
}
