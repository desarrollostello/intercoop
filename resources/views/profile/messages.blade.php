@extends('layouts.master')

@section('content')
	<div class="container row">
		<div class="col l4 hide-on-med-and-down aside-left-menu no-padding padding-r">
			<div class="collection">
				<!-- Aside menu left -->
			@include('includes.aside-menu-left')
			<!-- End aside menu left -->
			</div>
		</div>
		<div class="col s12 l8 no-padding mmargin-t">
			<div class="col s12 white no-padding border-thin" style="min-height: 20rem;">
				<div class="col s12 no-padding">
					<div class="col s12 no-padding">
						<ul class="chat-tabs tabs">
							<li class="tab col s3">
								<a href="#received" class="blue-text text-lighten-1">Messages</a>
							</li>
							<li class="tab col s3 disabled" style="border-left: thin solid #29b6f6;"></li>
						</ul>
					</div>
					<div id="received" class="col s12">
						<div class="collection">
							@if(isset($messages))
							@foreach($messages as $key => $message)
							<!-- Aside menu left -->
								<div class="collection-item">
									<a href="{{ route('messages-user',$message->last()->user_to == Auth::user()->id ? encrypt($message->last()->user_from) : encrypt($message->last()->user_to)) }}" class="show-user" data-userid="{{ $message->last()->user_to == Auth::user()->id ? encrypt($message->last()->user_from) : encrypt($message->last()->user_to) }}">
										<div class="d-inline-block v-align-middle valign-wrapper">
											<img src="{{ asset(Pheaks\User::find($message->last()->last_user)->profile->avatar->small) }}" class="valign responsive-img circle" alt="" width="40">
										</div>
										<div class="d-inline-block v-align-middle" style="width: 75%">
											<p class="value-notif truncate no-margin"><b>{{ $message->last()->user_name }}</b> <small class="">{{ $message->last()->message }}</small></p>
											<p class="no-margin"><span class="user-name">{{Pheaks\User::find($message->last()->last_user)->user_name}}</span><small class="grey-text right">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$message->last()->created_at)->diffForHumans() }}</small></p>
										</div>
									</a>
								</div>
								<!-- End aside menu left -->
							@endforeach
							@endif
						</div>
					</div>
					<div id="chat" class="col s12 no-padding" style="display: none">

					</div>
				</div>
			</div>
		</div>
	</div>
	<style>
		#chat > ul.list-chat, #received > div{
			max-height: 60vh;
			overflow: hidden;
			overflow-y: scroll;
		}
		li.item-chat{
			margin-bottom: 7.5px;
		}
		li.item-chat > .item-chat-content{
			position: relative;
			max-width: 80%;
		}
		li.item-chat.right-align > .item-chat-content:after{
			right: -10px;
		}
		li.item-chat.right-align > .item-chat-content.blue:after{
			border-bottom-color: #42A5F5;
		}
		li.item-chat.right-align > .item-chat-content.pink:after{
			border-bottom-color: #ec407a;
		}
		li.item-chat.left-align > .item-chat-content:after{
			border-bottom-color: #bdbdbd;
			left: -10px;
		}
		li.item-chat > .item-chat-content:after{
			position: absolute;
			bottom: 0;
			width: 0;
			height: 0;
			content: '';
			border: 10px solid transparent;
		}
		.indicator{
			background-color: #29b6f6 !important;
		}
			.btn{
				padding: 0 1rem;
			}
	</style>
@endsection