<?php
if (!function_exists('analytics')) {
    /**
     * Add Google Analytics tracking to a page
     * @param  string $tracking_code A Google Analytics ID, i.e. 'UA-XXXXXX-XX'
     * @return string HTML script tag that loads Google Analytics
     */
    function analytics($tracking_code)
    {
        if (!is_string($tracking_code)) {
            $tracking_code = "UA-515442-10";
        }
        return "<script>
window.ga=window.ga||function(){(ga.q=ga.q||[]).push(arguments)};ga.l=+new Date;
ga('create', '$tracking_code', 'auto');
ga('send', 'pageview');
</script>
<script async src='https://www.google-analytics.com/analytics.js'></script>";
    }
}
