@extends('package-acl::admin.layouts.base-2cols')

@section('title')
    {{ trans($plang_admin.'.pages.title-lang') }}
@stop

<?php
    $width = [
        'order' => '5%',
        'resource_name' => '15%',
        'model' => '15%',
        'line' => '10%',
        'word' => '10%',
        'action' => '15%',
        'resource_link' => '30%',
    ];
?>

@section('content')

    <div class="row">

            <!--LIST OF ITEMS-->
            <div class="col-md-9">

                <div class="panel panel-info">

                    <!--HEADING-->
                    <div class="panel-heading">
                        <h3 class="panel-title bariol-thin">
                            <i class="fa fa-language" aria-hidden="true"></i>
                            {!! trans($plang_admin.'.pages.title-lang') !!}
                        </h3>
                    </div>

                    <!--DESCRIPTION-->
                    <div class='panel-info panel-description'>
                        {!! trans($plang_admin.'.descriptions.lang') !!}
                    </div>
                    <!--/DESCRIPTION-->

                    <!--MESSAGE-->
                    <?php $message = Session::get('message'); ?>
                    @if( isset($message) )
                        <div class="panel-info alert alert-success flash-message">{!! $message !!}</div>
                    @endif
                    <!--/MESSAGE-->

                    <!--ERRORS-->
                    @if($errors && ! $errors->isEmpty() )
                        @foreach($errors->all() as $error)

                            <div class="alert alert-danger flash-message">{!! $error !!}</div>

                        @endforeach
                    @endif
                    <!--/ERRORS-->

                    <!--BODY-->
                    <div class="panel-body">

                        <a href="{{Url::route('word_english.install',['action' => 'truncate'])}}" class="btn btn-default search-reset">
                            {!! trans($plang_admin.'.title.truncate_table') !!}
                        </a>

                        <div class="tab-content table-responsive">

                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th scope="col" style="width: {{$width['order']}}">#</th>
                                    <th scope="col" style="width: {{$width['resource_name']}}">Resource name</th>
                                    <th scope="col" style="width: {{$width['model']}}">Model</th>
                                    <th scope="col" style="width: {{$width['line']}}">Line</th>
                                    <th scope="col" style="width: {{$width['word']}}">Word</th>
                                    <th scope="col" style="width: {{$width['action']}}">Action</th>
                                    <th scope="col" style="width: {{$width['resource_link']}}">Resource link</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>Link 1</td>
                                        <td>Link 1</td>
                                        <td>Link 1</td>
                                        <td>Link 1</td>
                                        <td>Link 1</td>
                                        <td>Link 1</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">2</th>
                                        <td>Link 2</td>
                                        <td>Link 2</td>
                                        <td>Link 2</td>
                                        <td>Link 2</td>
                                        <td>Link 2</td>
                                        <td>Link 2</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">3</th>
                                        <td>Link 3</td>
                                        <td>Link 3</td>
                                        <td>Link 3</td>
                                        <td>Link 3</td>
                                        <td>Link 3</td>
                                        <td>Link 3</td>
                                    </tr>
                                </tbody>
                            </table>


                        </div>


                    </div>
                    <!--/BODY-->

                </div>
            </div>
            <!--/LIST OF ITEMS-->

            <!--SEARCH-->
            <div class="col-md-3">
                @include('package-english::admin.english-search')
            </div>
            <!--/SEARCH-->

    </div>
@stop
