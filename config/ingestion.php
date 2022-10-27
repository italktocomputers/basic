<?php

$config = array(
    'db_mapping' => [
        'title' => [
            'table' => 'Job',
            'field_name' => 'Job_Title'
        ],
        'company_name' => [
            'table' => 'Company',
            'field_name' => 'Company_Name'
        ],
        'description' => [
            'table' => 'Job',
            'field_name' => 'Job_Description'
        ],
        'creation_date' => [
            'table' => 'Job',
            'field_name' => 'Job_Created'
        ],
    ],
    'validator' => [
        'title' => [
            'type' => 'String',
            'min_length' => 6,
            'max_length' => 50,
        ],
        'company_name' => [
            'type' => 'String',
            'min_length' => 1,
            'max_length' => 50,
        ],
        'description' => [
            'type' => 'String',
            'min_length' => 100,
            'max_length' => 500,
        ],
        'creation_date' => [
            'type' => 'Date',
        ],
        'hiring_team' => [
            'email' => [
                'type' => 'Email',
            ],
            'role' => [
                'type' => 'String',
                'values' => [
                    'regular',
                    'admin'
                ]
            ],
        ]
    ]
);