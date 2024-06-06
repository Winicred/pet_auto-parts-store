<?php

return [
    "api" => [
        "search" => [
            'title' => 'We are sorry, but nothing was found :(',
            "models" => [
                'title' => 'We did not find models for the car ":car" with the query: ":query".',
            ],
            'parts' => [
                'title' => 'Nothing was found for the query ":query".',
                'with_filters' => 'We could not find parts with the specified filters. Try resetting the filters.',
            ]
        ],
        "global_search" => [
            'title' => 'We are sorry, but nothing was found :(',
            'description' => 'We could not find anything with the query: ":query".',
        ]
    ],
    "partCategories" => [
        'title' => 'Oops! Nothing was found :(',
        'description' => 'Unfortunately, we did not find any categories for <b>:car</b>.',
        'back' => 'Back to the list of cars :brand',
    ],
];
