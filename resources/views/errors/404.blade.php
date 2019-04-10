@extends('layouts.master')

@section('content')
    <!-- Main content -->
    <section class="content col s12 m6">
        <div class="error-page center">
            <div class="error-content">
                <h3 class="black-text">Oops! Page not found.</h3>
                <span class="icon-stack" style="font-size: 8rem;">
                    <i class="icon-link red-text"></i>
                    <i class="icon-ban-circle icon-stack-base black-text"></i>
                </span>
                <p class="black-text">
                    We could not find the page you were looking for.
                    Meanwhile, you may go @if(\Auth::check())
                                        <a href="{{ url(route('home')) }}">to home page
                                    @else
                                        <a href="{{ url(route('login')) }}">to login page
                                    @endif <i class="{{ \Auth::check() ? 'icon-home' : 'icon-signin' }}"></i></a>
                </p>
            </div>
            <!-- /.error-content -->
        </div>
        <!-- /.error-page -->
    </section>
@endsection