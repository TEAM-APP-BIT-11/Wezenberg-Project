<?php

function divAnchor($uri = '', $title = '', $attributes = '')
{
    return "<div>" . anchor($uri, $title, $attributes) . "</div>\n";
}

function smallDivAnchor($uri = '', $title = '', $attributes = '')
{
    return "<div style='margin-top: 4px'>" .
        anchor($uri, $title, $attributes) . "</div>\n";
}


function activeAnchor($uri = '', $title = '', $attributes = '')
{
    $segmenten = explode('/', $uri);
    $CI =& get_instance();
    $active = false;

    if (count($segmenten) >= 3) {
        if ($segmenten[0] == $CI->uri->segment(1) && $segmenten[1] == $CI->uri->segment(2) && $segmenten[2] == $CI->uri->segment(3)) {
            $active = true;
        }
    } elseif ($segmenten[0] == $CI->uri->segment(1) && $segmenten[1] == $CI->uri->segment(2)) {
        $active = true;
    } else {
        $active = false;
    }

    return '<li ' . ($active == true ? 'class="active"' : '') . '>' . anchor($uri, $title, $attributes) . "</li>";

}

?>
