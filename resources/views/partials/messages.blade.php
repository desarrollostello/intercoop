
@if($messages->count() > 0)
    @foreach($messages as $key => $message)
        @if($message->from()->first()->status!='1')
            @continue
        @endif
        @if(!empty($message))
            <li>
                <a href="{{ route('messages-user',$message->user_to == Auth::user()->id ? encrypt($message->user_from) : encrypt($message->user_to)) }}" class="element-of-message">
                    <div class="d-inline-block v-align-middle valign-wrapper">
                        <img src="{{ asset($message->user_to == Auth::user()->id ? $message->from()->first()->profile->avatar->small : $message->to()->first()->profile->avatar->small) }}" class="valign responsive-img circle" alt="" width="40">
                    </div>
                    <div class="d-inline-block v-align-middle">
                        <p class="value-notif truncate"><b>{{ $message->user_name }}</b> <small class="">{{ $message->message }}</small></p>
                        <p class="no-margin">
                            <i class="icon-time grey-text text-lighten-1" style="font-size: 1rem;line-height: normal;"></i>
                            <small class="mdc-text-grey">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$message->created_at)->diffForHumans() }}</small>
                        </p>
                    </div>
                </a>
            </li>
        @else
            <li>
                <a>
                    <p>Nothing to show</p>
                </a>
            </li>
        @endif
    @endforeach
@else
    <li>
        <a>
            <p class="no-margin">You not have messages</p>
        </a>
    </li>
@endif