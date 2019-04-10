<script>
    /* Comment Post */
    $(document).on('submit','.comment-state-form',function (e) {
        var element = $(this);
        $.ajax({
            url: '{{ route("commentstate") }}',
            type: 'POST',
            data: element.serialize(),
            beforeSend: function(){

            },
            success: function (data) {
                if(typeof data == 'object'){
                    if(data.status=='success'){
                        element.find('textarea').val('');
                        var $toastContent = $('<div class="green lighten-1">'+data.message+'</div>');
                    }else{
                        var $toastContent = $('<div class="red lighten-1">'+data.message+'</div>');
                    }
                    Materialize.toast($toastContent, 4000);
                }
            }
        }).statusCode(statusCodes());
        e.preventDefault();
    });

    /* Like Post */
    $(document).on('click','.like-state-button',function(e){
        var element = $(this);
        var count_likes = element.children('span');
        var num_likes = parseInt(count_likes.text());
        $.ajax({
            url: '{{route("likestate")}}',
            type: 'POST',
            data: {_token:$('#application-token').data('token'),state:element.data('state')},
            beforeSend: function(){

            },
            success: function (data) {
                console.log(data);

                if(typeof data=='object'){
                    if(data.status=='success') {
                        count_likes.text(num_likes+1);
                        if (element.hasClass('grey-text')) {
                            element.removeClass('grey-text').addClass('blue-text');
                            element.removeClass('like-state-button').addClass('dislike-state-button');
                        } else {
                            element.removeClass('blue-blue').addClass('grey-text');
                        }
                    }else{
                        var $toastContent = $('<div class="red lighten-1">'+data.message+'</div>');
                    }
                }
                Materialize.toast($toastContent, 4000);
            }
        }).statusCode(statusCodes());
        e.preventDefault();
    });

    /* Dislike Post */
    $(document).on('click','.dislike-state-button',function (e) {
        var element = $(this);
        var count_likes = element.children('span');
        var num_likes = parseInt(count_likes.text());
        $.ajax({
            url: '{{ route("likestate") }}',
            type: 'POST',
            data: {_token:$('#application-token').data('token'),state:element.data('state')},
            beforeSend: function () {

            },
            success: function (data) {
                console.log(data);
                if(typeof data=='object'){
                    if(data.status=='success') {
                        if(num_likes>0){
                            count_likes.text(num_likes-1);
                        }
                        if (element.hasClass('blue-text')) {
                            element.removeClass('blue-text').addClass('grey-text');
                            element.removeClass('dislike-state-button').addClass('like-state-button');
                        } else {
                            element.removeClass('grey-text').addClass('blue-text');
                        }
                    }else{
                        var $toastContent = $('<div class="red lighten-1">'+data.message+'</div>');
                    }
                }
                Materialize.toast($toastContent, 4000);
            }
        }).statusCode(statusCodes());
        e.preventDefault();
    });

    /* Comment Photo */
    $(document).on('submit','.comment-photo-form',function (e) {
        var element = $(this);
        $.ajax({
            url: element.attr('action'),
            type: 'POST',
            data: element.serialize(),
            beforeSend: function () {

            },
            success: function (data) {
                if(typeof data == 'object'){
                    if(data.status=='success'){
                        var $toastContent = $('<div class="green lighten-1">'+data.message+'</div>');
                        $(document.getElementById('modal-show-comments')).append('<div class="mpadding-b">'+
                            '<div class="card-content">'+
                                '<div class="row valign-wrapper no-margin">'+
                                    '<div class="col s2 no-padding" style="height: 3rem">'+
                                        '<a href="{{ route('accound', Auth::user()->id) }}">'+
                                            '<img src="{{ asset(Auth::user()->profile->avatar->small) }}" alt="avatar" width="40" class="circle profile-image" />&nbsp;'+
                                        '</a>'+
                                    '</div>'+
                                    '<div class="col s10 no-padding mpadding-l">'+
                                        '<a href="{{ route('accound', encrypt(Auth::user()->id)) }}">'+
                                            '<span class="truncate blue-text text-lighten-1">{{ Auth::user()->user_name }}</span>'+
                                        '</a>'+
                                        '<small class="grey-text"></small>'+
                                    '</div>'+
                                '</div>'+
                                '<p class="no-margin margin-tb">'+
                                element.find('textarea').val()+
                                '</p>'+
                            '</div>'+
                        '</div>');
                        element.find('textarea').val('');
                    }else{
                        var $toastContent = $('<div class="red lighten-1">'+data.message+'</div>');
                    }
                    Materialize.toast($toastContent, 4000);
                }
            }
        }).statusCode(statusCodes());
        e.preventDefault();
    });

    /* Like Photo */
    $(document).on('click','.like-photo-button',function (e) {
        var element = $(this);
        var count_likes = element.children('span');
        var num_likes = parseInt(count_likes.text());
        $.ajax({
            url: '{{ route("likephoto") }}',
            type: 'POST',
            data: {_token:$('#application-token').data('token'),photo:element.data('photo')},
            beforeSend: function(){

            },
            success: function (data) {
                console.log(data);

                if(typeof data=='object'){
                    if(data.status=='success') {
                        count_likes.text(num_likes+1);
                        if (element.hasClass('grey-text')) {
                            element.removeClass('grey-text').addClass('blue-text');
                            element.removeClass('like-photo-button').addClass('dislike-photo-button');
                        } else {
                            element.removeClass('blue-blue').addClass('grey-text');
                        }
                    }else{
                        var $toastContent = $('<div class="red lighten-1">'+data.message+'</div>');
                    }
                }
                Materialize.toast($toastContent, 4000);
            }
        }).statusCode(statusCodes());
        e.preventDefault();
    });

    /* Dislike Photo */
    $(document).on('click','.dislike-photo-button',function (e) {
        var element = $(this);
        var count_likes = element.children('span');
        var num_likes = parseInt(count_likes.text());
        $.ajax({
            url: '{{ route("likephoto") }}',
            type: 'POST',
            data: {_token:$('#application-token').data('token'),photo:element.data('photo')},
            beforeSend: function () {

            },
            success: function (data) {
                console.log(data);
                if(typeof data=='object'){
                    if(data.status=='success') {
                        if(num_likes>0){
                            count_likes.text(num_likes-1);
                        }
                        if (element.hasClass('blue-text')) {
                            element.removeClass('blue-text').addClass('grey-text');
                            element.removeClass('dislike-photo-button').addClass('like-photo-button');
                        } else {
                            element.removeClass('grey-text').addClass('blue-text');
                        }
                    }else{
                        var $toastContent = $('<div class="red lighten-1">'+data.message+'</div>');
                    }
                }
                Materialize.toast($toastContent, 4000);
            }
        }).statusCode(statusCodes());
        e.preventDefault();
    });

    /* Show form for report a user */
    $('.report-user-from-feed').click(function (e) {
        $.ajax({
            url: '',
            type: 'GET',
            beforeSend: function () {

            },
            success: function (data) {

            }
        }).statusCode(statusCodes());
        e.preventDefault();
    });

    /* Show hidden form form comment */
    $('.icon-comment-button').click(function(e){
        var data_form = $(this).data('form');
        var form = $('#'+data_form);
        form.toggle();
        e.preventDefault();
    });
</script>