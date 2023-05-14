<?php

use Illuminate\Session\TokenMismatchException;

/**
 * FRONT
 */
Route::get('english', [
    'as' => 'english',
    'uses' => 'Foostart\English\Controllers\Front\EnglishFrontController@index'
]);


/**
 * ADMINISTRATOR
 */
Route::group(['middleware' => ['web']], function () {

    Route::group(['middleware' => ['admin_logged', 'can_see', 'in_context'],
        'namespace' => 'Foostart\English\Controllers\Admin',
    ], function () {

        /*
          |-----------------------------------------------------------------------
          | Manage english
          |-----------------------------------------------------------------------
          | 1. List of english
          | 2. Edit english
          | 3. Delete english
          | 4. Add new english
          | 5. Manage configurations
          | 6. Manage languages
          |
        */

        /**
         * list
         */
        Route::get('admin/word_english', [
            'as' => 'word_english.list',
            'uses' => 'WordEnglishAdminController@index'
        ]);

        /**
         * edit-add
         */
        Route::get('admin/word_english/edit', [
            'as' => 'word_english.edit',
            'uses' => 'WordEnglishAdminController@edit'
        ]);

        /**
         * copy
         */
        Route::get('admin/word_english/copy', [
            'as' => 'word_english.copy',
            'uses' => 'WordEnglishAdminController@copy'
        ]);

        /**
         * english
         */
        Route::post('admin/word_english/edit', [
            'as' => 'word_english.english',
            'uses' => 'WordEnglishAdminController@english'
        ]);

        /**
         * delete
         */
        Route::get('admin/word_english/delete', [
            'as' => 'word_english.delete',
            'uses' => 'WordEnglishAdminController@delete'
        ]);

        /**
         * trash
         */
        Route::get('admin/word_english/trash', [
            'as' => 'word_english.trash',
            'uses' => 'WordEnglishAdminController@trash'
        ]);

        /**
         * install
         */
        Route::get('admin/word_english/install', [
            'as' => 'word_english.install',
            'uses' => 'WordEnglishAdminController@install'
        ]);

        Route::post('admin/word_english/config', [
            'as' => 'word_english.config',
            'uses' => 'WordEnglishAdminController@config'
        ]);

        /**
         * configs
         */
        Route::get('admin/word_english/config', [
            'as' => 'word_english.config',
            'uses' => 'WordEnglishAdminController@config'
        ]);

        Route::post('admin/word_english/config', [
            'as' => 'word_english.config',
            'uses' => 'WordEnglishAdminController@config'
        ]);

        /**
         * language
         */
        Route::get('admin/word_english/lang', [
            'as' => 'word_english.lang',
            'uses' => 'WordEnglishAdminController@lang'
        ]);

        Route::post('admin/word_english/lang', [
            'as' => 'word_english.lang',
            'uses' => 'WordEnglishAdminController@lang'
        ]);

        Route::get('admin/word_english/update_info', [
            'as' => 'word_english.update_info',
            'uses' => 'WordEnglishAdminController@updateInfo'
        ]);

    });
});
