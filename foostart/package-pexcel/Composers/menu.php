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
  |   $plang_admin = 'pexcel-admin'
  |   $plang_front = 'pexcel-front'
 */
View::composer([
    'package-pexcel::admin.pexcel-edit',
    'package-pexcel::admin.pexcel-form',
    'package-pexcel::admin.pexcel-items',
    'package-pexcel::admin.pexcel-item',
    'package-pexcel::admin.pexcel-search',
    'package-pexcel::admin.pexcel-config',
    'package-pexcel::admin.pexcel-lang',
    'package-pexcel::admin.pexcel-view',
    'package-pexcel::admin.pexcel-view-item',
        ], function ($view) {

    /**
     * $plang-admin
     * $plang-front
     */
    $plang_admin = 'pexcel-admin';
    $plang_front = 'pexcel-front';

    $view->with('plang_admin', $plang_admin);
    $view->with('plang_front', $plang_front);

    $fooCategory = new FooCategory();
    $key = $fooCategory->getContextKeyByRef('admin/pexcels');
    /**
     * $sidebar_items
     */
    $sidebar_items = [
        trans('pexcel-admin.sidebar.add') => [
            'url' => URL::route('pexcel.edit', []),
            'icon' => '<i class="fa fa-pencil-square-o" aria-hidden="true"></i>'
        ],
        trans('pexcel-admin.sidebar.list') => [
            "url" => URL::route('pexcel.list', []),
            'icon' => '<i class="fa fa-list-ul" aria-hidden="true"></i>'
        ],
        trans('pexcel-admin.sidebar.category') => [
            'url' => URL::route('categories.list', ['_key=' . $key]),
            'icon' => '<i class="fa fa-sitemap" aria-hidden="true"></i>'
        ],
        trans('pexcel-admin.sidebar.config') => [
            "url" => URL::route('pexcel.config', []),
            'icon' => '<i class="fa fa-braille" aria-hidden="true"></i>'
        ],
        trans('pexcel-admin.sidebar.lang') => [
            "url" => URL::route('pexcel.lang', []),
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
        'pexcel_name' => trans($plang_admin . '.fields.name'),
        'pexcel_status' => trans($plang_admin . '.fields.pexcel-status'),
        'updated_at' => trans($plang_admin . '.fields.updated_at'),
    ];

    $sortTable = new SortTable();
    $sortTable->setOrders($orders);
    $sorting = $sortTable->linkOrders();

    /**
     * $order_by
     */
    $order_by = [
        'asc' => trans('category-admin.order.by-asc'),
        'desc' => trans('category-admin.order.by-des'),
    ];

    /**
     * Send to view
     */
    $view->with('sidebar_items', $sidebar_items );
    $view->with('plang_admin', $plang_admin);
    $view->with('plang_front', $plang_front);
    $view->with('sorting', $sorting);
    $view->with('order_by', $order_by);
});
