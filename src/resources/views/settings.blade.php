@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Display Contents</div>
                    <div class="card-body">
                        @if (isset($isSucceed))
                            @if ($isSucceed)
                                <div class="alert alert-success" role="alert">
                                    @lang('display_contents.succeed_save')
                                </div>
                            @else
                                <div class="alert alert-danger" role="alert">
                                    @lang('display_contents.failed_save')
                                </div>
                            @endif
                        @endif
                        <form action="{{ url('settings/save') }}" method="POST">
                            @csrf
                            <div class="row justify-content-center">
                                <div class="card" style="width: 12rem;">
                                    <ul class="list-group list-group-flush">
                                        @foreach ($displayContents as $key => $content)
                                            <li class="list-group-item">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="{{ $key }}"
                                                           name="{{ $key }}"
                                                           value="true" {{ $content['isDisplayed'] ? "checked=checked" : "" }} >
                                                    <label class="custom-control-label"
                                                           for="{{ $key }}">{{ $content['title'] }}</label>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <br>
                            <div class="row justify-content-center">
                                <input class="btn btn-primary" type="submit" value="Submit">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
