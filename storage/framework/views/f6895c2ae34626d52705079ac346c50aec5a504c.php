<script>
    $(document).ready(function(){
        $('#chat').show();
        var update = function () {
            //moment(datetime.attr('created'), "YYYYMMDD").fromNow(); // 4 years ago
            datetime = $('.item-chat');
            var all_items = $('.item-chat .create-at');
            datetime.each(function( index, elem ) {
                var created = $(elem).data('created');
                $(elem).find( ".create-at" ).html(moment.unix(created).fromNow());
            });
        };

        setInterval(update, 1000);
        $('.chat-tabs').tabs({
            onShow: autoScroll
        });

        $('#chat form').submit(function(){
            var element = $(this);
            if(element.find('button[type="submit"]').hasClass('disabled')){
                return false;
            }
            date = moment();

            var input_message = $('#textarea1');
            element.addClass('disabled').attr('disabled','disabled');

            $.ajax({
                url: '<?php echo e(route('sendmessage')); ?>',
                type: 'POST',
                data: {_token:$('#application-token').data('token'),_user:$('#list-chat').attr('data-user'),_message:input_message.val()},
                beforeSend: function(){

                },
                success: function(){
                    var tochat = $('<li id="item-chat" class="item-chat right-align right-element" data-created="'+Math.floor(Date.now() / 1000)+'">'+
                        '<div class="item-chat-content mpadding <?php if(Auth::user()->sex=='f'): ?> pink <?php else: ?> blue <?php endif; ?> lighten-1 margin-r" style="display: inline-block;vertical-align: middle;border-radius: 5px;border-bottom-right-radius: 0;">'+
                        '<span class="white-text">'+input_message.val()+'</span>'+
                        '<small class="d-block grey-text text-lighten-1 create-at"></small>'+
                        '</div>'+
                        '<div style="display: inline-block;vertical-align: middle">'+
                        '<img src="<?php echo e(asset( Auth::user()->profile->avatar->small )); ?>" class="circle img-responsive" width="40" alt="">'+
                        '</div>'+
                        '</li>');
                    $('#list-chat').append(tochat);
                    update();

                    input_message.val('');
                    autoScroll();
                    remove_class();
                },
                error: function(){
                    remove_class();
                }
            }).statusCode(statusCodes());

            var remove_class = function(){
                element.removeClass('disabled').removeAttr('disabled');
            };
            return false;
        });
    });

    var autoScroll = function(){
        var messageWindow = $("ul.list-chat");
        messageWindow.show();
        var scrollHeight = messageWindow.prop("scrollHeight");
        messageWindow.animate({scrollTop: scrollHeight}, 1000);
    };
</script>
