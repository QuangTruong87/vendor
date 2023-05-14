<?php
return [

    //Number of worlds
    'length' => [
        'english_name' => [
            'min' => 10,
            'max' => 255,
        ],
        'english_overview' => [
            'min' => 10,
            'max' => 255,
        ],
        'english_description' => [
            'min' => 255,
            'max' => 0,//unlimit
        ],
    ],
    'per_page' => 1,

    /*
    |-----------------------------------------------------------------------
    | ENVIRONMENT
    |-----------------------------------------------------------------------
    | 0: Development
    | 1: Production
    |
    */
    'env' => 0,
    'load_from' => 'package-english::',

    /*
    |-----------------------------------------------------------------------
    | LANGUAGES
    |-----------------------------------------------------------------------
    | vi
    | en
    |
    */
    'langs' => [
        'en' => 'English',
        'vi' => 'Vietnam'
    ],


    /*
    |-----------------------------------------------------------------------
    | Permissions
    |-----------------------------------------------------------------------
    | List
    | Edit
    | Add
    | Select
    |
    */
    'permissions' => [
        'list_all' => ['_superadmin', '_user-editor'],
        'list_by_context' => [],
        'edit' => ['_superadmin', '_user-editor'],
        'add' => ['_superadmin', '_user-editor'],
        'delete' => ['_superadmin', '_user-editor'],
    ],


    /*
    |-----------------------------------------------------------------------
    | Resources
    |-----------------------------------------------------------------------
    | Name
    | Line
    | Word
    | Link
    |
    */
    'resources' => [
//        [
//            'name' => '',
//            'line' => '',
//            'word' => '',
//            'link' => '',
//            'model' => '',
//        ],
        [
            'name' => 'dwyl',
            'file' => 'word.txt',
            'line' => '466550',
            'word' => '466550',
            'link' => 'https://github.com/dwyl/english-words',
            'model' => 'WordResourceDwy',
        ]
    ]
];