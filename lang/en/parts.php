<?php

return [
    'fields' => [
        'brand' => 'Brand',
        'model' => 'Model',
        'start_production' => 'Start production',
        'end_production' => 'End production',
        'code' => 'Product code',
        'manufacturer' => 'Manufacturer',
        'material' => 'Material',
        'color' => 'Color',
        'location' => 'Location',
        'price' => 'Price',
        'details' => 'Details',
        'width' => 'Width',
        'height' => 'Height',
        'length' => 'Length',
        'engine' => [
            'code' => 'Engine code',
            'capacity' => 'Capacity',
            'power' => 'Power',
            'torque' => 'Torque',
            'injection' => 'Injection type',
            'cylinders' => 'Number of cylinders',
            'valves' => 'Number of valves',
            'fuel' => 'Fuel type',
            'consumption' => [
                'city' => 'City consumption',
                'highway' => 'Highway consumption',
                'combined' => 'Average consumption',
            ],
        ],
        'transmission' => [
            'type' => 'Type',
            'gears' => 'Number of gears',
            'drive' => 'Drive',
        ],
        'body' => [
            'weight' => 'Weight',
            'clearance' => 'Clearance',
            'type' => 'Body type',
        ],
        'interior' => [
            'trunk' => 'Trunk volume',
            'fuel_tank' => 'Fuel tank volume',
            'seats' => 'Number of seats',
            'doors' => 'Number of doors',
        ],
        'stock' => [
            'title' => 'Stock',
            'in_stock' => 'In stock',
            'items' => ':value pcs.',
            'out_of_stock' => 'Out of stock',
        ],
        'delivery' => 'Delivery date',
    ],
    'values' => [
        'engine' => [
            'capacity' => ':value cm<sup>3</sup> (:sub)',
            'power' => ':value hp',
            'torque' => ':value Nm',
            'cylinders' => ':value pcs.',
            'valves' => ':value pcs.',
            'injection' => [
                'mpfi' => 'Multi-point',
                'throttleBody' => 'Throttle body',
                'multiPointInjection' => 'Multi-point',
                'directInjection' => 'Direct',
                'portInjection' => 'Port',
                'sequentialInjection' => 'Sequential',
                'commonRailInjection' => 'Common rail',
                'dieselInjection' => 'Diesel',
                'hybridInjection' => 'Hybrid',
                'electricInjection' => 'Electric',
            ],
            'fuel' => [
                'petrol' => 'Petrol',
                'diesel' => 'Diesel',
                'gas' => 'Gas',
                'hybrid' => 'Hybrid',
                'electric' => 'Electric',
            ],
            'consumption' => [
                'city' => ':value l/100km',
                'highway' => ':value l/100km',
                'combined' => ':value l/100km',
            ],
        ],
        'transmission' => [
            'gears' => ':value gears',
            'type' => [
                'automatic' => 'Automatic',
                'manual' => 'Manual',
                'semiAutomatic' => 'Semi-automatic',
                'continuouslyVariable' => 'Continuously variable',
                'dualClutch' => 'Dual clutch',
                'robotic' => 'Robotic',
            ],
            'drive' => [
                'short' => [
                    'front' => 'Front',
                    'rear' => 'Rear',
                    'full' => 'All',
                ],
                'full' => [
                    'front' => 'Front drive',
                    'rear' => 'Rear drive',
                    'full' => 'All wheel drive',
                ],
            ],
        ],
        'body' => [
            'weight' => ':value kg',
            'clearance' => ':value mm',
        ],
        'interior' => [
            'trunk' => ':value l',
            'fuel_tank' => ':value l',
            'seats' => ':value seats',
            'doors' => ':value doors',
        ],
        'colors' => [
            'black' => 'Black',
            'white' => 'White',
            'silver' => 'Silver',
            'gray' => 'Gray',
            'red' => 'Red',
            'blue' => 'Blue',
            'green' => 'Green',
            'yellow' => 'Yellow',
            'brown' => 'Brown',
            'orange' => 'Orange',
            'purple' => 'Purple',
            'pink' => 'Pink',
            'gold' => 'Gold',
            'beige' => 'Beige',
            'other' => 'Other',
            'unknown' => 'Unknown',
        ],
        'location' => [
            'front' => 'Front',
            'back' => 'Rear',
            'left' => 'Left',
            'right' => 'Right',
            'top' => 'Top',
            'bottom' => 'Bottom',
            'both' => 'Both',
            'unknown' => 'Unknown',
        ],
        'width' => ':value mm',
        'height' => ':value mm',
        'length' => ':value mm',
        'material' => [
            'steel' => 'Steel',
            'aluminium' => 'Aluminium',
            'plastic' => 'Plastic',
            'glass' => 'Glass',
        ],
    ],
    'filters' => [
        'manufacturer' => [
            'title' => 'Manufacturer',
            'all' => 'All',
        ],
        'colors' => [
            'title' => 'Color',
            'all' => 'All',
        ],
        'location' => [
            'title' => 'Location',
            'all' => 'All',
        ],
        'sort_by' => [
            'title' => 'Sort by',
            'methods' => [
                'nameAsc' => 'Name ascending',
                'nameDesc' => 'Name descending',
                'priceAsc' => 'Price ascending',
                'priceDesc' => 'Price descending',
            ]
        ],
        'price' => [
            'title' => 'Price',
            'from' => 'From',
            'to' => 'To',
        ],
        'search' => 'Search',
        'reset' => 'Reset',
    ],
    'list' => [
        'result_count' => [
            'found' => 'Found',
            'count' => 'item|items',
        ]
    ],
    'categories' => [
        'title' => 'Other categories',
    ],
];
