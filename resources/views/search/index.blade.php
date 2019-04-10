
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
        <div class="col s12 l8 no-padding mmargin-t">
        	<div class="col s12 white border-thin">
        		<div class="col s12 no-padding margin-tb">
					{{--<ul class="collapsible" data-collapsible="accordion">
						<li>
							<div class="collapsible-header"><i class="icon-reorder"></i>Tipo de busqueda</div>
							<div class="collapsible-body">
								<form action="#">
									<p class="range-field">
										<span>0 Km</span>
										<input type="range" id="test5" min="0" max="100" />
										<span>100 Km</span>
									</p>
								</form>
							</div>
						</li>
					</ul>--}}
        			<div class="border-thin user-search-space">
						@if($user!=null||!empty($user))
							<div class="col s12 mpadding">
								<h5 class="truncate  d-inline-block v-align-middle">
									<a href="{{ url(route('accound',encrypt($user->user_id))) }}">{{ $user->user_name }}</a>
								</h5>
								<a class='dropdown-button user-search-button-extra-options blue-grey lighten-5 d-inline-block v-align-middle hoverable border-thin' href='#' data-activates='user-options'><i class="icon-angle-down"></i></a>
								<!-- Dropdown Structure -->
								<ul id='user-options' class='dropdown-content user-search-button-extra-options-list'>
									<li>
										<a href="#!" class="blue-text waves-effect">Reportar \ Bloquear <i class="icon-flag red-text lighten-1 right"></i></a>
									</li>
								</ul>
							</div>

							<div class="mpadding center user-search-space-avatar">
								<a href="{{ url(route('show-photo')) }}" class="show-photo" data-photo-id="{{ encrypt($user->profile->avatar->id) }}">
									@if(File::exists($user->profile->avatar->medium))
										<img class="responsive-img circle" src="{{ $user->profile->avatar->medium }}" width="200">
									@else
										<img class="responsive-img circle" src="{{ asset('img/default_avatar.png') }}" width="200">
									@endif
								</a>
							</div>
							<div class="col s12 center mmargin-b user-search-info">
								<div class="col s4">
									<div>Sex:</div>
									<div class="truncate">{{ $user->sex=='f' ? 'Female' : 'Male' }}</div>
								</div>
								<div class="col s4">
									<div>Age:</div>
									<div class="truncate">{{ \Carbon\Carbon::createFromDate(date('Y', strtotime($user->birthday)), date('m', strtotime($user->birthday)), date('d', strtotime($user->birthday)))->age }}</div>
								</div>
								<div class="col s4">
									<div>Height:</div>
									<div class="truncate">{{ $user->height ? $user->height : "Not defined" }}</div>
								</div>
							</div>
							<div class="card-content options-buttons mpadding-b">
								<div class="col s4 center">
									<button onclick="window.location='{{ url('/search?href=next') }}'" class="waves-effect white-text btn d-block red lighten-1 tooltipped mpadding-b" data-position="top" data-tooltip="Reject <i class='material-icons red-text lighteen-1'>clear</i>">
										<span class="hide-on-small-only">Reject </span> <i class="material-icons">clear</i>
									</button>
								</div>
								<div class="col s4 center">
									@if(Checks::is_liked('user',$user->id))
										<button class="waves-effect btn d-block tooltipped mpadding-b disabled" data-position="top" data-tooltip="Like <i class='icon-star yellow-text lighteen-1'></i>">
											<span class="hide-on-small-only text-lowercase">Like</span> <i class="icon-star"></i>
										</button>
									@else
										<button class="waves-effect btn d-block white-text tooltipped mpadding-b add-like-user yellow lighten-1" data-position="top" data-tooltip="Like <i class='icon-star yellow-text lighteen-1'></i>">
											<span class="hide-on-small-only text-lowercase">Like</span> <i class="icon-star"></i>
										</button>
									@endif
								</div>
								<div class="col s4 center">
									@if(Checks::contact_request_sended($user->id))
										<button class="waves-effect red waves-light btn d-block tooltipped cancel-contact-button" data-position="top" data-tooltip="Cancel Request <i class='icon-remove red-text text-lighteen-1'></i>">
											<span class="hide-on-small-only">Cancel</span> <i class="material-icons">remove</i>
										</button>
									@elseif(Checks::contact_is_request($user->id))
										<button class="waves-effect blue waves-light btn d-block tooltipped acept-contact-button" data-position="top" data-tooltip="Acept Request <i class='icon-ok blue-text text-lighteen-1'></i>">
											<span class="hide-on-small-only">Acept</span> <i class="material-icons">done</i>
										</button>
									@elseif(Checks::is_contact($user->id))
										<button class="waves-effect red waves-light btn d-block tooltipped delete-contact-button" data-position="top" data-tooltip="Delete Contact <i class='icon-minus red-text text-lighteen-1'></i>">
											<span class="hide-on-small-only">Delete</span> <i class="material-icons">remove</i>
										</button>
									@else
										<button class="waves-effect green waves-light btn d-block tooltipped add-contact-button" data-position="top" data-tooltip="Add Contact <i class='icon-plus green-text text-lighteen-1'></i>">
											<span class="hide-on-small-only">Add</span> <i class="material-icons">person add</i>
										</button>
									@endif
								</div>
							</div>
                        @else
                            <h2 class="center">Nothing to show</h2>
                            <div class="col s12">
                                <a href="{{ url(route('profile')) }}" class="btn waves-block waves-effect blue">Check your preferences</a>
                            </div>
                        @endif
  					</div>
        		</div>
        	</div>
    	</div>
	</div>
@endsection

@section('main-javascripts')
	@parent
	@if(isset($user) && $user != null)
		@include('javascripts.user-actions-buttons')
		@include('javascripts.content-interactivity')
	@endif
@endsection