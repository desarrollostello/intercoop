@extends('layouts.master')

@section('content')
	<div class="container row">
		<div class="col l4 hide-on-med-and-down aside-left-menu no-padding padding-r">
            <div class="collection white">
                <!-- Aside menu left -->
                @include('includes.aside-menu-left')
                <!-- End aside menu left -->
            </div>
        </div>
        <div class="col l8 no-padding mmargin-t">
        	<div class="col s12 white border-thin">
        		<div class="col s12 no-padding">
					<h5 class="left">Visitors</h5>
					<!--<div class="right mmargin-t">
					  	<select class="browser-default">
					    	<option value="1">Visit you</option>
					    	<option value="2">You visited</option>
					  	</select>
					</div>-->
				</div>
        		<div class="col s12 no-padding" style="min-height: 20rem">
					@if($likes->count()>0)
						<div class="collection">
						@foreach($likes as $key => $user)
							@if($user->from->id==Auth::user()->id)
								<a href="{{ route('accound', encrypt($user->to()->first()->id)) }}" class="collection-item blue-text text-lighten-1 avatar valign-wrapper" style="min-height: 4.5rem;">
									<div class="col s10 valign">
										@if(File::exists($user->to()->first()->profile->avatar->small))
											<img src="{{ asset($user->to()->first()->profile->avatar->small) }}" alt="" class="responsive-img circle">
										@else
											<img src="{{ asset('img/default_avatar.png') }}" alt="image-not-found" class="responsive-img circle">&nbsp;
										@endif
										<span class="title">
											<p class="no-margin">{{ $user->to()->first()->user_name }}</p>
											<p class="no-margin"><small>{{ $user->updated_at->diffForHumans() }}</small></p>
										</span>
									</div>
									<div class="col s2 valign">
										<span class="badge">He likes you</span>
									</div>
								</a>
							@else
								<a href="{{ route('accound', encrypt($user->from()->first()->id)) }}" class="collection-item blue-text text-lighten-1 avatar valign-wrapper" style="min-height: 4.5rem;">
									<div class="col s10 valign">
										@if(File::exists($user->from()->first()->profile->avatar->small))
											<img src="{{ asset($user->from()->first()->profile->avatar->small) }}" alt="" class="responsive-img circle">
										@else
											<img src="{{ asset('img/default_avatar.png') }}" alt="image-not-found" class="responsive-img circle">&nbsp;
										@endif
										<span class="title">
										<p class="no-margin">{{ $user->from()->first()->user_name }}</p>
										<p class="no-margin"><small>{{ $user->updated_at->diffForHumans() }}</small></p>
									</span>
									</div>
									<div class="col s2 valign">
										<span class="badge">you like</span>
									</div>
								</a>
							@endif
						@endforeach
						</div>
					@else
						<h2 class="padding-lr center">Nothing to show</h2>
						<div class="center padding-b">
							<a href="{{ url(route('search')) }}"class="btn waves-effect waves-block blue">Find people</a>
						</div>
					@endif
        		</div>
        	</div>
    	</div>
	</div>
@endsection