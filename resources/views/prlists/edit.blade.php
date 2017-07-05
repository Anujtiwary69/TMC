@extends('layouts.frontend')

@section('title', $list->name)

@section('page_script')
    <script type="text/javascript" src="{{ URL::asset('assets/js/plugins/forms/styling/uniform.min.js') }}"></script>

    <script type="text/javascript" src="{{ URL::asset('js/validate.js') }}"></script>
@endsection

@section('page_header')

    @include("prlists._header")

@endsection

@section('content')

    @include("prlists._menu")

    <form action="{{ action('PRListController@update', $list->uid) }}" method="POST" class="form-validate-jqueryz">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="PATCH">

        @include("prlists._form")
        <hr>
        <div class="text-left">
            <button class="btn bg-teal mr-10"><i class="icon-check"></i> {{ trans('messages.save') }}</button>
            <a href="{{ action('PRListController@index') }}" class="btn bg-grey-800"><i class="icon-cross2"></i> {{ trans('messages.cancel') }}</a>
        </div>
    </form>
@endsection
