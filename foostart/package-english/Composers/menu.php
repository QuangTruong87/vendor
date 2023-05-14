<?php

use LaravelAcl\Authentication\Classes\Menu\SentryMenuFactory;
use Foostart\Category\Helpers\FooCategory;
use Foostart\Category\Helpers\SortTable;

/*
|-----------------------------------------------------------------------
| GLOBAL VARIABLES
|-----------------------------------------------------------------------
|   $sidebar_items
|   $sorting
|   $order_by
|   $plang_admin = 'english-admin'
|   $plang_front = 'english-front'
*/
View::composer([
    'package-english::admin.english-edit',
    'package-english::admin.english-form',
    'package-english::admin.english-items',
    'package-english::admin.english-item',
    'package-english::admin.english-search',
    'package-english::admin.english-config',
    'package-english::admin.english-lang',
    'package-english::admin.english-install',
], function ($view) {

    //Order by params
    $params = Request::all();

    /**
     * $plang-admin
     * $plang-front
     */

    $plang_admin = 'english-admin';
    $plang_front = 'english-front';

    $fooCategory = new FooCategory();
    $key = $fooCategory->getContextKeyByRef('admin/english');

    /**
     * $sidebar_items
     */
    $sidebar_items = [
        trans('english-admin.sidebar.add') => [
            'url' => URL::route('word_english.edit', []),
            'icon' => '<i class="fa fa-pencil-square-o" aria-hidden="true"></i>'
        ],
        trans('english-admin.sidebar.list') => [
            "url" => URL::route('word_english.list', []),
            'icon' => '<i class="fa fa-list-ul" aria-hidden="true"></i>'
        ],
        trans('english-admin.sidebar.install') => [
            'url' => URL::route('word_english.install'),
            'icon' => '<i class="fa fa-sitemap" aria-hidden="true"></i>'
        ],
        trans('english-admin.sidebar.category') => [
            'url' => URL::route('categories.list', ['_key=' . $key]),
            'icon' => '<i class="fa fa-sitemap" aria-hidden="true"></i>'
        ],
        trans('english-admin.sidebar.config') => [
            "url" => URL::route('word_english.config', []),
            'icon' => '<i class="fa fa-braille" aria-hidden="true"></i>'
        ],
        trans('english-admin.sidebar.lang') => [
            "url" => URL::route('word_english.lang', []),
            'icon' => '<i class="fa fa-language" aria-hidden="true"></i>'
        ],
    ];

    /**
     * $sorting
     * $order_by
     */
    $orders = [
        '' => trans($plang_admin . '.form.no-selected'),
        'id' => trans($plang_admin . '.fields.id'),
        'english_name' => trans($plang_admin . '.fields.name'),
        'status' => trans($plang_admin . '.columns.status'),
        'updated_at' => trans($plang_admin . '.fields.updated_at'),
    ];
    $sortTable = new SortTable();
    $sortTable->setOrders($orders);
    $sorting = $sortTable->linkOrders();


    //Order by
    $order_by = [
        'asc' => trans('category-admin.order.by-asc'),
        'desc' => trans('category-admin.order.by-des'),
    ];

    // assign to view
    $view->with('sidebar_items', $sidebar_items);
    $view->with('order_by', $order_by);
    $view->with('sorting', $sorting);
    $view->with('plang_admin', $plang_admin);
    $view->with('plang_front', $plang_front);
});
