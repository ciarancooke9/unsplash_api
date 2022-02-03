<?php

Unsplash\HttpClient::init([
    'applicationId'	=> 'JfslSx-D_qWAmT2v0GDJoHQCcPNopiXkusPGA6JeXyc',
    'secret'	=> 'hlSTew4nlgOJJK2keJ6sxBuERi4DE2L1Ww3IooyPnf0',
    'callbackUrl'	=> 'https://your-application.com/oauth/callback',
    'utmSource' => 'Ciarans_practice_api'
]);

$search = 'forest';
$page = 3;
$per_page = 15;
$orientation = 'landscape';

Unsplash\Search::photos($search, $page, $per_page, $orientation);
?>