@extends('layouts.default')
@section('title', $user->name)

@section('content')
    <div class="row">
        <div class="offset-md-2 col-md-8">
            <div class="col-md-12">
                <div class="offset-md-2 col-md-8">
                    <section class="user_info">
                        @include('shared._user_info', ['user' => $user])
                    </section>
                    <section class="stats mt-2">
                        @include('shared._stats', ['user' => $user])
                    </section>
                    <section class="status">
                       @include('shared._feed')
                    </section>
                </div>
            </div>
        </div>
    </div>
@stop
