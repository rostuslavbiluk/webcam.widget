<?php
$APPLICATION->IncludeComponent(
    "vendor:webcam.widget",
    ".default",
    array(
        "UNIQUE_CODE" => "widget_120921",
        "WEBCAM_URL" => "http://cam.sokolniki.com:201/axis-cgi/mjpg/video.cgi?fps=4&resolution=800x600",
        "WEBCAM_POSTER_URL" => "",
        "VIDEO_HEIGHT" => "3",
        "VIDEO_WIDTH" => "4",
        "COMPONENT_TEMPLATE" => ".default"
    ),
    false
);
