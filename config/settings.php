<?php

return [
    'theme'               => env('THEME', 'default'),
    'slider_path'         => 'slider-cycle',//путь к папке изображения slider-cycle/image.jpg
    'home_port_count'     => 5,//колличечтво отображаемых элементов портфолио на главной странице
    'home_articles_count' => 3,//колличечтво отображаемых элементов в сайтбаре на главной странице
    'paginate'            => 2,//колличечтво отображаемых элементов(статей) на странице
    'recent_comments' => 3,
    'recent_portfolios' => 3,
    'other_portfolios' => 8,

    'articles_img' => [
        'max' => ['width'=>816,'height'=>282],
        'mini' => ['width'=>55,'height'=>55]
    ],
// параметр path - хранение полного изображения
    'image' => [
        'width'=>1024,
        'height'=>768
    ],

];