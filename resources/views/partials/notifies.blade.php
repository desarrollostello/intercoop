@if(count($notifies) > 0)
    @foreach($notifies as $key => $notify)
        @if($notify->from()->first()->status!='1')
            @continue
        @endif
        @if(!empty($notify))
            @switch( $notify->type )
                @case( 0 )
                {{-- Someone has accectp your request --}}
                    <li class="{{ $notify->viewed == 0 ? Auth::user()->sex=="f"? "pink": "blue" : null }} lighten-5" data-last="{{ \Hashids::encode($notify->id) }}">
                        <a href="{{ route('accound', encrypt(\Pheaks\User::find($notify->user_from)->id)) }}" class="notify-list-item element-of-message">
                            <div class="d-inline-block v-align-middle valign-wrapper">
                                <img src="{{ asset(\Pheaks\User::find($notify->user_from)->profile->avatar->small) }}" class="valign responsive-img circle" alt="" width="40">
                            </div>
                            <div class="d-inline-block v-align-middle">
                                <p class="value-notif truncate"><b>{{ \Pheaks\User::find($notify->user_from)->user_name }}</b> <small class="">accept your contact request.</small></p>
                                <p class="no-margin">
                                    <small class="mdc-text-grey">
                                        <i class="icon-time grey-text text-lighten-1" style="font-size: 1rem;line-height: normal;"></i>
                                        {{ $notify->created_at->diffForHumans() }}
                                        <i class="icon-plus-sign green-text text-lighten-1 right" style="font-size: 1rem;line-height: normal;height: initial;"></i>
                                    </small>
                                </p>
                            </div>
                        </a>
                    </li>
                    @breakswitch
                @case( 1 )
                {{-- Someone has added you --}}
                    <li class="{{ $notify->viewed == 0 ? Auth::user()->sex=="f"? "pink": "blue" : null }} lighten-5" data-last="{{ \Hashids::encode($notify->id) }}">
                        <a href="{{ route('accound', encrypt(\Pheaks\User::find($notify->user_from)->id)) }}" class="notify-list-item element-of-message blue lighten-5">
                            <div class="d-inline-block v-align-middle valign-wrapper">
                                <img src="{{ asset(\Pheaks\User::find($notify->user_from)->profile->avatar->small) }}" class="valign responsive-img circle" alt="" width="40">
                            </div>
                            <div class="d-inline-block v-align-middle">
                                <p class="value-notif truncate"><b>{{ \Pheaks\User::find($notify->user_from)->user_name }}</b> <small class="">has sent a request contact.</small></p>
                                <p class="no-margin">
                                    <small class="mdc-text-grey">
                                        <i class="icon-time grey-text text-lighten-1" style="font-size: 1rem;line-height: normal;"></i>
                                        {{ $notify->created_at->diffForHumans() }}
                                        <i class="icon-plus-sign green-text text-lighten-1 right" style="font-size: 1rem;line-height: normal;height: initial;"></i>
                                    </small>
                                </p>
                            </div>
                        </a>
                    </li>
                    @breakswitch
                @case( 3 )
                {{-- He likes someone --}}
                    <li class="{{ $notify->viewed == 0 ? Auth::user()->sex=="f"? "pink": "blue" : null }} lighten-5" data-last="{{ \Hashids::encode($notify->id) }}">
                        <a href="{{ route('accound', encrypt(\Pheaks\User::find($notify->user_from)->id)) }}" class="notify-list-item element-of-message">
                            <div class="d-inline-block v-align-middle valign-wrapper">
                                <img src="{{ asset(\Pheaks\User::find($notify->user_from)->profile->avatar->small) }}" class="valign responsive-img circle" alt="" width="40">
                            </div>
                            <div class="d-inline-block v-align-middle">
                                <p class="value-notif truncate">
                                    <b>{{ \Pheaks\User::find($notify->user_from)->user_name }}</b>
                                    <small class="">likes you.</small>
                                </p>
                                <p class="no-margin">
                                    <small class="mdc-text-grey">
                                        <i class="icon-time grey-text text-lighten-1" style="font-size: 1rem;line-height: normal;"></i>
                                        {{ $notify->created_at->diffForHumans() }}
                                        <i class="icon-heart {{Auth::user()->sex=='f'?'pink-text':'blue-text'}} text-lighten-1 right" style="font-size: 1rem;line-height: normal;height: initial;"></i>
                                    </small>
                                </p>
                            </div>
                        </a>
                    </li>
                    @breakswitch
                @case( 4 )
                {{-- Someone likes your photo --}}
                    <li class="{{ $notify->viewed == 0 ? Auth::user()->sex=="f"? "pink": "blue" : null }} lighten-5" data-last="{{ \Hashids::encode($notify->id) }}">
                        <a href="{{ url(route('show-photo')) }}" class="notify-list-item element-of-message show-photo" data-photo-id="{{ encrypt($notify->object) }}">
                            <div class="d-inline-block v-align-middle valign-wrapper">
                                <img src="{{ asset(\Pheaks\User::find($notify->user_from)->profile->avatar->small) }}" class="valign responsive-img circle" alt="" width="40">
                            </div>
                            <div class="d-inline-block v-align-middle">
                                <p class="value-notif truncate">
                                    <b>{{ \Pheaks\User::find($notify->user_from)->user_name }}</b>
                                    <small class="">like your photo.</small>
                                </p>
                                <p class="no-margin">
                                    <small class="mdc-text-grey">
                                        <i class="icon-time grey-text text-lighten-1" style="font-size: 1rem;line-height: normal;"></i>
                                        {{ $notify->created_at->diffForHumans() }}
                                        <i class="icon-heart {{Auth::user()->sex=='f'?'pink-text':'blue-text'}} text-lighten-1 right" style="font-size: 1rem;line-height: normal;height: initial;"></i>
                                    </small>
                                </p>
                            </div>
                        </a>
                    </li>
                    @breakswitch
                @case( 5 )
                {{-- Someone commented on your photo --}}
                    <li class="{{ $notify->viewed == 0 ? Auth::user()->sex=="f"? "pink": "blue" : null }} lighten-5" data-last="{{ \Hashids::encode($notify->id) }}">
                        <a href="{{ route('accound', encrypt(\Pheaks\User::find($notify->user_from)->id)) }}" class="notify-list-item element-of-message">
                            <div class="d-inline-block v-align-middle valign-wrapper">
                                <img src="{{ asset(\Pheaks\User::find($notify->user_from)->profile->avatar->small) }}" class="valign responsive-img circle" alt="" width="40">
                            </div>
                            <div class="d-inline-block v-align-middle">
                                <p class="value-notif truncate">
                                    <b>{{ \Pheaks\User::find($notify->user_from)->user_name }}</b>
                                    <small class="">comment your photo.</small>
                                    <small class="mdc-text-grey d-block">
                                        <i class="icon-time grey-text text-lighten-1" style="font-size: 1rem;line-height: normal;"></i>
                                        {{ $notify->created_at->diffForHumans() }}
                                        <i class="icon-comment green-text text-lighten-1 right" style="font-size: 1rem;line-height: normal;height: initial;"></i>
                                    </small>
                                </p>
                            </div>
                        </a>
                    </li class="{{ $notify->viewed == 0 ? "blue lighten-5" : null }}">
                    @breakswitch
                @case( 6 )
                {{-- Someone has commented on your state --}}
                    <li class="{{ $notify->viewed == 0 ? Auth::user()->sex=="f"? "pink": "blue" : null }} lighten-5" data-last="{{ \Hashids::encode($notify->id) }}">
                        <a href="{{ route('accound', encrypt(\Pheaks\User::find($notify->user_from)->id)) }}" class="notify-list-item element-of-message">
                            <div class="d-inline-block v-align-middle valign-wrapper">
                                <img src="{{ asset(\Pheaks\User::find($notify->user_from)->profile->avatar->small) }}" class="valign responsive-img circle" alt="" width="40">
                            </div>
                            <div class="d-inline-block v-align-middle">
                                <p class="value-notif truncate">
                                    <b>{{ \Pheaks\User::find($notify->user_from)->user_name }}</b>
                                    <small class="">comment your state.</small>
                                </p>
                                <p class="no-margin">
                                    <small class="mdc-text-grey">
                                        <i class="icon-time time-text text-lighten-1" style="font-size: 1rem;line-height: normal;"></i>
                                        {{ $notify->created_at->diffForHumans() }}
                                        <i class="icon-comment green-text text-lighten-1 right" style="font-size: 1rem;line-height: normal;height: initial;"></i>
                                    </small>
                                </p>
                            </div>
                        </a>
                    </li>
                    @breakswitch
                @case( 7 )
                {{-- Someone likes your state --}}
                    <li class="{{ $notify->viewed == 0 ? Auth::user()->sex=="f"? "pink": "blue" : null }} lighten-5" data-last="{{ \Hashids::encode($notify->id) }}">
                        <a href="{{ route('accound', encrypt(\Pheaks\User::find($notify->user_from)->id)) }}" class="notify-list-item element-of-message">
                            <div class="d-inline-block v-align-middle valign-wrapper">
                                <img src="{{ asset(\Pheaks\User::find($notify->user_from)->profile->avatar->small) }}" class="valign responsive-img circle" alt="" width="40">
                            </div>
                            <div class="d-inline-block v-align-middle">
                                <p class="value-notif truncate">
                                    <b>{{ \Pheaks\User::find($notify->user_from)->user_name }}</b>
                                    <small class="">like your state.</small>
                                </p>
                                <p class="no-margin">
                                    <small class="mdc-text-grey">
                                        <i class="icon-time grey-text text-lighten-1" style="font-size: 1rem;line-height: normal;"></i>
                                        {{ $notify->created_at->diffForHumans() }}
                                        <i class="icon-heart pink-text text-lighten-1 right" style="font-size: 1rem;line-height: normal;height: initial;"></i>
                                    </small>
                                </p>
                            </div>
                        </a>
                    </li>
                    @breakswitch
                @case( 8 )
                    {{-- Someone likes your state --}}
                    <li class="{{ $notify->viewed == 0 ? Auth::user()->sex=="f"? "pink": "blue" : null }} lighten-5" data-last="{{ \Hashids::encode($notify->id) }}">
                        <a href="{{ route('accound', encrypt(\Pheaks\User::find($notify->user_from)->id)) }}" class="notify-list-item element-of-message">
                            <div class="d-inline-block v-align-middle valign-wrapper">
                                <img src="{{ asset(\Pheaks\User::find($notify->user_from)->profile->avatar->small) }}" class="valign responsive-img circle" alt="" width="40">
                            </div>
                            <div class="d-inline-block v-align-middle">
                                <p class="value-notif truncate">
                                    <b>{{ \Pheaks\User::find($notify->user_from)->user_name }}</b>
                                    <small class="">visited your profile.</small>
                                </p>
                                <p class="no-margin">
                                    <small class="mdc-text-grey">
                                        <i class="icon-time grey-text text-lighten-1" style="font-size: 1rem;line-height: normal;"></i>
                                        {{ $notify->created_at->diffForHumans() }}
                                        <i class="icon-user blue-text text-lighten-1 right" style="font-size: 1rem;line-height: normal;height: initial;"></i>
                                    </small>
                                </p>
                            </div>
                        </a>
                    </li>
                    @breakswitch
                @default
                    <li>
                        <b>The type of notification is not recognized.</b>
                    </li>
                    @breakswitch
            @endswitch
        @endif
    @endforeach
@else
    <li>
        <a>
            <p class="no-margin">You not have notifications</p>
        </a>
    </li>
@endif