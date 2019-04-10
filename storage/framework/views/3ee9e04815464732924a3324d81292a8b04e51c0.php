
<?php /***
 * Created by PhpStorm.
 * User: ma3xc
 * Date: 24/12/2016
 * Time: 11:52
 **/ ?>
<script>
    $(function(){
        var user = '<?php echo e(encrypt($user->id)); ?>';
        $('.add-contact-button').click(function(){
            var element = $(this);
            $.ajax({
                url: '<?php echo e(url(route("addcontact"))); ?>',
                type: 'POST',
                data: { _token:$('#application-token').data('token'),_user:user},
                beforeSend: function(){
                    $('.spinner-icon-hidden').removeClass('hidden-block');
                },
                success: function(data){
                    $('.spinner-icon-hidden').addClass('hidden-block');
                    var decoded = JSON.parse(data);
                    if(decoded.status=='success'){
                        element.removeClass('add-contact-button').addClass('cancel-contact-button');
                        element.removeClass('green').addClass('red');
                        element.attr('data-tooltip',"Cancel <i class='icon-remove red-text lighteen-1'></i>").tooltip({delay: 50,html:true});
                        element.children('span').text('Cancel');
                        element.find('i').removeClass('icon-plus').addClass('icon-remove');
                        var $toastContent = $('<div class="green lighten-1">'+decoded.message+'</div>');
                        Materialize.toast($toastContent, 4000);
                    }else if(decoded.status=='error'){
                        var $toastContent = $('<div class="red lighten-1">'+decoded.message+'</div>');
                        Materialize.toast($toastContent, 4000);
                    }
                },
                error: function(){
                    $('.spinner-icon-hidden').addClass('hidden-block');
                }
            }).statusCode(statusCodes());
        });
        $('.cancel-contact-button').click(function(){
            var element = $(this);
            $.ajax({
                url: '<?php echo e(url(route("cancelcontact"))); ?>',
                type: 'POST',
                data: { _token:$('#application-token').data('token'),_user:user},
                beforeSend: function(){
                    $('.spinner-icon-hidden').removeClass('hidden-block');
                },
                success: function(data){
                    $('.spinner-icon-hidden').addClass('hidden-block');
                    console.log(data);
                    /*var decoded = JSON.parse(data);
                     if(decoded.status=='success'){
                     element.removeClass('add-contact-button');
                     element.removeClass('green').addClass('red');
                     element.attr('data-tooltip',"Cancel <i class='icon-remove red-text lighteen-1'></i>").tooltip({delay: 50,html:true});
                     element.children('span').text('Cancel');
                     element.find('i').removeClass('icon-plus').addClass('icon-remove');
                     var $toastContent = $('<div class="green lighten-1">'+decoded.message+'</div>');
                     Materialize.toast($toastContent, 4000);
                     }else if(decoded.status=='error'){
                     var $toastContent = $('<div class="red lighten-1">'+decoded.message+'</div>');
                     Materialize.toast($toastContent, 4000);
                     }*/
                },
                error: function(){
                    $('.spinner-icon-hidden').addClass('hidden-block');
                }
            }).statusCode(statusCodes());
        });
        $('.delete-contact-button').click(function(){
            var element = $(this);
            mbox.confirm('Are you sure you want to delete <span style="text-decoration: underline;"><?php echo e($user->user_name); ?></span>?', function(yes) {
                if (yes) {
                    //mbox.alert('Oh noes! You cannot do that right now!');
                    $.ajax({
                        url: '<?php echo e(route('deletecontact')); ?>',
                        type: 'POST',
                        data: { _token:$('#application-token').data('token'),_user:user},
                        beforeSend: function(){
                            $('.spinner-icon-hidden').removeClass('hidden-block');
                        },
                        success: function(data){
                            $('.spinner-icon-hidden').addClass('hidden-block');
                            var decoded = JSON.parse(data);
                            if(decoded.status=='success'){
                                element.removeClass('add-contact-button');
                                element.removeClass('green').addClass('red');
                                element.attr('data-tooltip',"Cancel <i class='icon-remove red-text lighteen-1'></i>").tooltip({delay: 50,html:true});
                                element.children('span').text('Cancel');
                                element.find('i').removeClass('icon-plus').addClass('icon-remove');
                                var $toastContent = $('<div class="green lighten-1"><i class="icon-ok-sign"></i> '+decoded.message+'</div>');
                                Materialize.toast($toastContent, 4000);
                            }else if(decoded.status=='error'){
                                var $toastContent = $('<div class="red lighten-1">'+decoded.message+'</div>');
                                Materialize.toast($toastContent, 4000);
                            }
                        }
                    }).statusCode(statusCodes());
                }
            });
        });
        $('.acept-contact-button').click(function (e) {
            e.preventDefault();
            var element = $(this);
            $.ajax({
                url: '<?php echo e(route('aceptcontact')); ?>',
                type: 'POST',
                data: {_token:$('#application-token').data('token'),_user:user},
                beforeSend: function(){

                },
                success: function(data){
                    var response = JSON.parse(data);
                    if(response.status != 'unefined' && response.status == 'success'){
                        element.removeClass('acept-contact-button').addClass('delete-contact-button');
                        element.removeClass('blue').addClass('red');
                        element.attr('data-tooltip',"Delete <i class='icon-minus red-text lighteen-1'></i>").tooltip({delay: 50,html:true});
                        element.children('span').text('Delete');
                        element.find('i').removeClass('icon-ok').addClass('icon-minus');
                        var $toastContent = $('<div class="green lighten-1">'+response.message+'</div>');
                        Materialize.toast($toastContent, 4000);
                    }
                }
            }).statusCode(statusCodes());
        });
        $('.add-like-user').click(function(){
            var element = $(this);
            var user_name = $('title').text();
            $.ajax({
                url: '<?php echo e(url(route("userlike"))); ?>',
                type: 'POST',
                data: {_token:$('#application-token').data('token'),_user:user},
                beforeSend: function(){
                    $('.spinner-icon-hidden').removeClass('hidden-block');
                },
                success: function(data){
                    $('.spinner-icon-hidden').addClass('hidden-block');
                    var decoded = JSON.parse(data);
                    if(decoded.status=='success'){
                        element.addClass('disabled');
                        var $toastContent = $('<div class="green lighten-1">Now like you '+user_name+'</div>');
                        Materialize.toast($toastContent, 4000);
                    }else{
                        var $toastContent = $('<div class="red lighten-1">Now like you '+decoded.message+'</div>');
                        Materialize.toast($toastContent, 4000);
                    }
                }
            }).statusCode(statusCodes());
        });
        <?php if(Checks::is_contact($user->id)): ?>
            $('.button-to-submit-message').click(function(){
                var element = $(this);
                if(element.hasClass('disabled')){
                    return false;
                }

                var input_message = $('.message-to-contact');
                element.addClass('disabled').attr('disabled','disabled');

                $.ajax({
                    url: '<?php echo e(route('sendmessage')); ?>',
                    type: 'POST',
                    data: {_token:$('#application-token').data('token'),_user:'<?php echo e(encrypt($user->id)); ?>',_message:input_message.val()},
                    beforeSend: function(){

                    },
                    success: function(){
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
            $('.message-to-user.conter').characterCounter();
        <?php endif; ?>
    });
</script>