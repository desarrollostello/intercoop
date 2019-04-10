@if($messages&&$messages!=null)

        @foreach($messages as $key => $message)
            @if($message->user_from == Auth::user()->id)
                <li id="item-chat" class="item-chat right-align right-element" data-created="{{ strtotime($message->created) }}">
                    <div class="item-chat-content mpadding @if(Auth::user()->sex=='f') pink @else blue @endif lighten-1 margin-r" style="display: inline-block;vertical-align: middle;border-radius: 5px;border-bottom-right-radius: 0;">
                        <span class="white-text">{{ $message->message }}</span>
                        <small class="d-block grey-text text-lighten-1 create-at">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$message->created)->diffForHumans() }}</small>
                    </div>
                    <div style="display: inline-block;vertical-align: middle">
                        <img src="{{ asset( Auth::user()->profile->avatar->small ) }}" class="circle img-responsive" width="40" alt="">
                    </div>
                </li>
            @else
                <li id="item-chat" class="item-chat left-align left-item" data-created="{{ strtotime($message->created) }}">
                    <div style="display: inline-block;vertical-align: baseline">
                        <img src="{{ asset( Pheaks\User::find($message->user_from)->profile->avatar->small ) }}" class="circle img-responsive" width="40" alt="">
                    </div>
                    <div class="item-chat-content mpadding grey lighten-1 margin-l" style="display: inline-block;vertical-align: baseline;border-radius: 5px;border-bottom-left-radius: 0;">
                        <span class="white-text">{{ $message->message }}</span>
                        <small class="d-block grey-text text-darken-1 create-at">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$message->created)->diffForHumans() }}</small>
                    </div>
                </li>
            @endif
        @endforeach

@endif