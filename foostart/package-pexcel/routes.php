<?php

use Illuminate\Session\TokenMismatchException;

/**
 * FRONT
 */
Route::get('pexcel', [
    'as' => 'pexcel',
    'uses' => 'Foostart\Pexcel\Controllers\Front\PexcelFrontController@index'
]);


/**
 * ADMINISTRATOR
 */
Route::group(['middleware' => ['web']], function () {

    Route::group(['middleware' => ['admin_logged', 'can_see', 'in_context'],
                  'namespace' => 'Foostart\Pexcel\Controllers\Admin',
        ], function () {

        /*
          |-----------------------------------------------------------------------
          | Manage pexcel
          |-----------------------------------------------------------------------
          | 1. List of pexcels
          | 2. Edit pexcel
          | 3. Delete pexcel
          | 4. Add new pexcel
          | 5. Manage configurations
          | 6. Manage languages
          |
        */

        /**
         * list
         */
         Route::get('admin/pexcel', [
            'as' => 'pexcel.list',
            'uses' => 'PexcelAdminController@index'
        ]);

        /**
         * view
         */
        Route::get('admin/pexcel/view', [
            'as' => 'pexcel.view',
            'uses' => 'PexcelAdminController@view'
        ]);

        /**
         * download
         */
        Route::get('admin/pexcel/download', [
            'as' => 'pexcel.download',
            'uses' => 'PexcelAdminController@download'
        ]);

        /**
         * save
         */
        Route::post('admin/pexcel/save', [
            'as' => 'pexcel.save',
            'uses' => 'PexcelAdminController@save'
        ]);

        /**
         * edit-add
         */
        Route::get('admin/pexcel/edit', [
            'as' => 'pexcel.edit',
            'uses' => 'PexcelAdminController@edit'
        ]);

        /**
         * copy
         */
        Route::get('admin/pexcel/copy', [
            'as' => 'pexcel.copy',
            'uses' => 'PexcelAdminController@copy'
        ]);

        /**
         * post
         */
        Route::post('admin/pexcel/edit', [
            'as' => 'pexcel.post',
            'uses' => 'PexcelAdminController@post'
        ]);

        /**
         * delete
         */
        Route::get('admin/pexcel/delete', [
            'as' => 'pexcel.delete',
            'uses' => 'PexcelAdminController@delete'
        ]);
        /**
         * restore
         */
        Route::get('admin/pexcel/restore', [
            'as' => 'pexcel.restore',
            'uses' => 'PexcelAdminController@restore'
        ]);

        /**
         * raw
         */
        Route::get('admin/pexcel/raw', [
            'as' => 'pexcel.raw',
            'uses' => 'PexcelAdminController@raw'
        ]);

        /**
         * trash
         */
         Route::get('admin/pexcel/trash', [
            'as' => 'pexcel.trash',
            'uses' => 'PexcelAdminController@trash'
        ]);

        /**
         * configs
        */
        Route::get('admin/pexcel/config', [
            'as' => 'pexcel.config',
            'uses' => 'PexcelAdminController@config'
        ]);

        Route::post('admin/pexcel/config', [
            'as' => 'pexcel.config',
            'uses' => 'PexcelAdminController@config'
        ]);

        /**
         * language
        */
        Route::get('admin/pexcel/lang', [
            'as' => 'pexcel.lang',
            'uses' => 'PexcelAdminController@lang'
        ]);

        Route::post('admin/pexcel/lang', [
            'as' => 'pexcel.lang',
            'uses' => 'PexcelAdminController@lang'
        ]);

    });
});
