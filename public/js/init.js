/**
 * Created by ma3xcodes on 13/08/16.
 */
var base_url = window.location.origin + "/";
$(function(){
    var _token = $('#application-token').data('token');

    var timelineBlocks = $('.cd-timeline-block'),
        offset = 0.8;

    //hide timeline blocks which are outside the viewport
    hideBlocks(timelineBlocks, offset);

    //on scolling, show/animate timeline blocks when enter the viewport
    $(window).on('scroll', function(){
        (!window.requestAnimationFrame)
            ? setTimeout(function(){ showBlocks(timelineBlocks, offset); }, 100)
            : window.requestAnimationFrame(function(){ showBlocks(timelineBlocks, offset); });
    });

    function hideBlocks(blocks, offset) {
        blocks.each(function(){
            ( $(this).offset().top > $(window).scrollTop()+$(window).height()*offset ) && $(this).find('.cd-timeline-img, .cd-timeline-content').addClass('is-hidden');
        });
    }

    function showBlocks(blocks, offset) {
        blocks.each(function(){
            ( $(this).offset().top <= $(window).scrollTop()+$(window).height()*offset && $(this).find('.cd-timeline-img').hasClass('is-hidden') ) && $(this).find('.cd-timeline-img, .cd-timeline-content').removeClass('is-hidden').addClass('animated bounceIn');
        });
    }

    $('.slider').slider({full_width: true, height: 200});
    //$('.recomended-users > p').pushpin({ top: $('.container.row').offset().top });
	$('.button-collapse').sideNav({
      menuWidth: 300, // Default is 240
      edge: 'left', // Choose the horizontal origin
      closeOnClick: true // Closes side-nav on <a> clicks, useful for Angular/Meteor
    });
    $('#birthday').datepicker({
       // selectMonths: true, // Creates a dropdown to control month
       // selectYears: 15 // Creates a dropdown of 15 years to control year
        format: 'yyyy-mm-dd'
    });
    $('.collapsible').collapsible({
        accordion : false // A setting that changes the collapsible behavior to expandable instead of the default accordion style
    });
    $('.tooltipped').tooltip({delay:50,html:true});
    $(document).on('click', '.dropdown-button', function(e){
        var element = $(this);
        element.dropdown();
        e.preventDefault();
    });
    $('.show-messages, .show-notifies').dropdown({
        constrain_width: false,
        belowOrigin: false
    });
    $('select').material_select();
    $('select').change(function(){
        $(this).parent('.select-wrapper').children('.select-dropdown').addClass('add-text-black-color');
    });
    
    $(document).on('change','.birth_month, .birth_year',function(){
        setSelectDays(null);
        console.log('Birth changed');
    });

    $('.show-login-form').click(function(){
    	var element = $('form.form-signup');
    	element.fadeOut().next().delay(450).fadeIn();
    	$('.button-collapse').sideNav('hide');
    	return false;
    });
    $('.show-signup-form').click(function(){
    	var element = $('form.form-login');
    	element.fadeOut().prev().delay(450).fadeIn();
    	$('.button-collapse').sideNav('hide');
    	return false;
    });
    $('.change-lang').click(function(){
        $.ajax({
            url:    base_url + "getajax/change-lang",
            type:   "GET"
        })
        .done(function(data){
            $('#main-modal').html(data).openModal();
        })
        .statusCode(statusCodes());
    });
    $('.forgot-password').click(function(e){
        $.ajax({
            url:    base_url + "getajax/recovery-passwod",
            type:   "GET",
            data:   {}
        })
        .done(function(data){
            $('#main-modal').html(data).openModal();
        })
        .statusCode(statusCodes());
        e.preventDefault();
    });

    var setSelectDays = function(value){
        var year_element = $('select.birth_year option:selected');
        var month_element = $('select.birth_month option:selected');
        var day_element = $('select.birth_day');
        var month_days = daysOfMonth(month_element.val(), year_element.val());

        day_element.empty();
        for(var i=1;i<=month_days;i++){
            day_element.append('<option value="'+i+'">'+i+'</option>');
        }
        day_element.material_select();
    };
    var daysOfMonth = function(month, year){
        //return new Date(year, month, 0).getDate();
        var y = year;
        var m = month;
        var days = new Date(y,m,1,-1).getDate();
        return days; 
    };
    $('select.birth_month option').each(function() {
        if($(this).is(':selected')){
            setSelectDays(null);
        }
    });

    //Show ajax modal of photos
    $(document).on('click','.show-photo',function(){
        var modal = $('#main-modal');
        var element = $(this);
        $.ajax({
            url: element.attr('href'),
            type: 'GET',
            data: {_phot_id:element.data('photo-id')},
            beforeSend: function(){
                $('.spinner-icon-hidden').removeClass('hidden-block');
            },
            success: function(data){
                modal.addClass('full-modal');
                if(modal.is(':visible')){
                    modal.closeModal();
                    setTimeout(function(){
                        $('.spinner-icon-hidden').addClass('hidden-block');
                        modal.html(data).openModal({
                            complete: function(){ modal.removeClass('full-modal') }
                        });
                    },1000);
                }else{
                    $('.spinner-icon-hidden').addClass('hidden-block');
                    modal.html(data).openModal({
                        complete: function(){ modal.removeClass('full-modal') }
                    });
                }
            }
        }).statusCode(statusCodes());

        return false;
    });

    //Show modal for create a post
    $(document).on('click','.menu-item-new-post',function(){
        var modal = $('#main-modal');
        var element = $(this);
        $.ajax({
            url: element.attr('href'),
            type: 'GET',
            data: {},
            beforeSend: function(){
                $('.spinner-icon-hidden').removeClass('hidden-block');
            },
            success: function(data){
                $('.spinner-icon-hidden').addClass('hidden-block');
                $('.change-nav').removeClass('navbar-fixed');
                modal.html(data).openModal({
                    starting_top: '40%',
                    ready: function(){
                        //
                        $(document).on('click','.post-dropdown-button', function(){
                            element = $(this);
                            element.dropdown({
                                gutter: 40,
                                beloworigin: true
                            });
                        });
                    },
                    complete: function() { $('.change-nav').addClass('navbar-fixed'); }
                });
            }
        }).statusCode(statusCodes());
        return false;
    });

    $(document).on('submit','.new-state',function(e){
        var element = $(this);
        $.ajax({
            url: element.attr('action'),
            type: 'POST',
            data: element.serialize(),
            beforeSend: function(){
                $('.spinner-icon-hidden').removeClass('hidden-block');
            },
            success: function(data){
                $('.spinner-icon-hidden').addClass('hidden-block');
                if(typeof data == 'object'){
                    if(data.status=='success'){
                        $('#new-post').val('');
                        $('#main-modal').closeModal();
                        var $toastContent = $('<div class="green lighten-1">'+data.message+'</div>');
                    }else{
                        var $toastContent = $('<div class="red lighten-1">'+data.message+'</div>');
                    }
                }
                Materialize.toast($toastContent, 4000);
            }
        }).statusCode(statusCodes());
        e.preventDefault();
    });
    $(document).on('click','.add-photos', function(){
        var modal = $('#main-modal');
        var element = $(this);
        $.ajax({
            url: base_url + "getajax/newphoto",
            beforeSend: function(){
                $('.spinner-icon-hidden').removeClass('hidden-block');
            },
            success: function(data){
                $('.spinner-icon-hidden').addClass('hidden-block');
                $('.change-nav').removeClass('navbar-fixed');
                modal.html(data).openModal({
                    starting_top: '40%',
                    ready: function(){
                        //
                        $(document).on('click','.post-dropdown-button', function(){
                            element = $(this);
                            element.dropdown({
                                gutter: 40,
                                beloworigin: true
                            });
                        });
                    },
                    complete: function() { $('.change-nav').addClass('navbar-fixed'); }
                });
            }
        }).statusCode(statusCodes());
    });
    $(document).on('submit','.new-photo',function(e){
        var element = $(this);

        var file_data = $('#photo-upload').prop('files')[0];
        var form_data = new FormData();
        form_data.append('file_name', file_data);
        form_data.append('privacy', element.find('input[name="privacy"]:checked').val());
        console.log(form_data);
        console.log(element.find('input[name="privacy"]:checked').val());
        $.ajax({
            url: element.attr('action'),
            type: 'POST',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            headers:  {
                "X-CSRF-TOKEN": $('#application-token').data('token')
            },
            beforeSend: function(){
                $('.spinner-icon-hidden').removeClass('hidden-block');
            },
            success: function(data){
                $('.spinner-icon-hidden').addClass('hidden-block');
                if(typeof data == 'object'){
                    if(data.status=='success'){
                        $('#new-post').val('');
                        $('#main-modal').closeModal();
                        var $toastContent = $('<div class="green lighten-1"><!--<img src="'+data.small+'" width="200">--> <span class="white-text">Your photo is uploadded</span></div>');
                    }else{
                        var $toastContent = $('<div class="red lighten-1">'+data.message+'</div>');
                    }
                }
                Materialize.toast($toastContent, 4000);
            }
        }).statusCode(statusCodes());
        e.preventDefault();
    });
    $(document).on('click','.button-delete-profile-button',function(e){
        var element = $(this);
        var data = {
            _token: $('#application-token').data('token'),
            photo: element.data('photo')
        };
        console.log(data);
        $.ajax({
            url: base_url + 'postajax/deletephoto',
            type: 'POST',
            data: data,
            beforeSend: function(){
                $('.spinner-icon-hidden').removeClass('hidden-block');
            },
            success: function(data){
                $('.spinner-icon-hidden').addClass('hidden-block');
                if(typeof data == 'object'){
                    if(data.status=='success'){
                        var $toastContent = $('<div class="green lighten-1">'+data.message+'</div>');
                        var parent = element.parent('div');
                        parent.addClass('bounceOut');
                        setTimeout(function(){
                            parent.remove();
                        },750);
                    }else{
                        var $toastContent = $('<div class="red lighten-1">'+data.message+'</div>');
                    }
                    Materialize.toast($toastContent, 4000);
                }else{
                    console.log(data);
                }
            }
        }).statusCode(statusCodes());
        e.preventDefault();
    });
    $(document).on('change',"#photo-upload", function () {

        if (typeof (FileReader) != "undefined") {
            var image_holder = $(".image-holder");
            image_holder.empty();

            var reader = new FileReader();
            reader.onload = function (e) {
                $("<img />", {
                    "src": e.target.result,
                    "class": "thumb-image",
                    "style":'max-width:240px;height:auto;'
                }).appendTo(image_holder);
                console.log(e);
            };
            image_holder.show();
            reader.readAsDataURL($(this)[0].files[0]);
        } else {
            var $toastContent = $('<div class="red lighten-1">This browser does not support.</div>');
            Materialize.toast($toastContent, 4000);
        }
    });
    $(document).on('submit','.profile-form-decription', function(e){
       var element = $(this);
       $.ajax({
            url: element.attr('action'),
           method: element.attr('method'),
            data: element.serialize(),
            beforeSend: function(){
              element.find('button[type="submit"]').addClass('disabled');
            },
            success: function(data) {
                if(typeof data == 'object'){
                    if(data.status=='success'){
                        var $toastContent = $('<div class="green lighten-1">'+data.message+'</div>');
                    }else{
                        var $toastContent = $('<div class="red lighten-1">'+data.message+'</div>');
                    }
                    Materialize.toast($toastContent, 4000);
                }
                element.find('button[type="submit"]').removeClass('disabled');
            }
       });
       e.preventDefault();
    });

    $('.content-notifies-notifies').bind('scroll',function() {
        var element = $(this);
        var last_item = $('ul.list-notifies.notifies > li').last().data('last');

        if(element.scrollTop() + element.innerHeight() >= $(this)[0].scrollHeight) {
            $.ajax({
                url: base_url + "getajax/morenotifies",
                data: {last:last_item},
                beforeSend: function(){
                    $('.spinner-icon-hidden').removeClass('hidden-block');
                },
                success: function (data) {
                    $('.spinner-icon-hidden').addClass('hidden-block');
                    $('.list-notifies.notifies').append(data);
                    console.log(data);
                }
            })
        }
    });

    $(document).bind('scroll',function () {
        if($('#timeline-content').length > 0) {
            var doc = $(this);

            var dTop = doc.scrollTop();
            var wHeight = $(window).height() - 616;
            var content_articles = $('#timeline-content');
            if (dTop >= wHeight) {
                data = {
                    last: content_articles.find('article').last().data('article')
                };
                $.ajax({
                    url: base_url + 'getajax/morefeeds',
                    data: data,
                    beforeSend: function () {
                        $('body').css('overflow','hidden');
                        $('#feed-content-spinner').toggle();
                    },
                    success: function (data) {
                        if(typeof data == 'object'){
                            if(data.status=='success'){
                                var $toastContent = $('<div class="green lighten-1">'+data.message+'</div>');
                            }else{
                                var $toastContent = $('<div class="red lighten-1">'+data.message+'</div>');
                            }
                            Materialize.toast($toastContent, 4000);
                        }else{
                            $('#my-timeline').append(data);
                            $('.aside-left-menu > div').pushpin({
                                top: 64,
                                bottom: $('.container.row').height() - $('.page-footer').height(),
                                offset: 64
                            });
                        }
                        $('#feed-content-spinner').toggle();
                        $('body').removeAttr('style');
                    }
                }).statusCode(statusCodes());
            }
        }
    });

    $('.list-item-notification > a.element-of-message').click(function(e){
        var element = $(this);
        var insert_content = element.siblings();
        if($('.content-notifies-messages').is(':hidden')){
            console.log('Hidden');
            return false;
        }
        $.ajax({
            url: base_url + 'getajax/firstmessages',
            type: 'GET',
            beforeSend: function () {

            },
            success: function (data) {
                insert_content.children('ul').html(data);
                $('.icon-message-count-notifications').text('');
            }
        }).statusCode(statusCodes());
        e.preventDefault();
    });
    $('.list-item-notification > a.element-of-notification').click(function(e){
        var element = $(this);
        var insert_content = element.siblings();
        if(insert_content.is(':hidden')){
            console.log('Hidden');
            return false;
        }
        $.ajax({
            url: base_url + 'getajax/firstnotifies',
            type: 'GET',
            beforeSend: function () {

            },
            success: function (data) {
                insert_content.children('ul').html(data);
                $('.icon-count-notifies').text('');
                /*var last_ele = $('.value-notif');
                $.each(last_ele, function(i, v){
                    console.log(v);

                    //$clamp(v, {clamp: 2, useNativeClamp: false});
                });
                $clamp(insert_content.children('ul').children('li'), {clamp: 2, useNativeClamp: false});*/
            }
        }).statusCode(statusCodes());

        e.preventDefault();
    });

    $('.morefeedcomments').click(function(e){
        var element = $(this);
        var content = element.data('comments');
        var last_comment = $('.'+content+' > .comment-last').last();
        data = {
            last:last_comment.data('last'),
            type:element.data('type'),
            object:element.data('object')
        };
        console.log(data);

        $.ajax({
            url: base_url + 'getajax/morefeedcomments',
            data: data,
            beforeSend: function(){
                
            },
            success: function(data){
                //console.log(data);
                if(typeof data == "object"){
                    if(data.status=='success') {
                        var $toastContent = $('<div class="orange lighten-1">' + data.message + '</div>');
                    }else{
                        var $toastContent = $('<div class="red lighten-1">' + data.message + '</div>');
                    }
                    Materialize.toast($toastContent, 4000);
                    element.toggle();
                }else {
                    $('.' + content).append(data);
                }
            }
        }).statusCode(statusCodes());
        e.preventDefault();
    });
    $('.aside-left-menu > div').pushpin({
        bottom: $('.container.row').height() - $('.page-footer').height(),
        offset: 64
    });
    //Set and get checkbox sound state
    $('#chat-sound-control').change(function () {
        var element = $(this);
        if(element.is(':checked')){
            window.localStorage.setItem('chat-sound-control', 'checked');
        }else{
            window.localStorage.setItem('chat-sound-control', '');
        }
        console.log(element.val());
    });
    if(window.localStorage.getItem('chat-sound-control')!=''&&window.localStorage.getItem('chat-sound-control')!=undefined){
        $('#chat-sound-control').attr( 'checked', window.localStorage.getItem('chat-sound-control') )
    }
});
statusCodes = function(){
    return {
        404: function(){
            console.log("Error 404");
            var $toastContent = $('<div class="orange lighten-1">Page not found</div>');
            Materialize.toast($toastContent, 4000);
        },
        405: function(){
            console.log("Error 405");
            var $toastContent = $('<div class="red lighten-1">Method Not Allowed</div>');
            Materialize.toast($toastContent, 4000);
        },
        401: function(){
            console.log("Error 401");
            var $toastContent = $('<div class="orange lighten-1">Unautorized</div>');
            Materialize.toast($toastContent, 4000);
        },
        402: function(){
            console.log('Error 402');
            var $toastContent = $('<div class="orange lighten-1">Please first login.</div>');
            Materialize.toast($toastContent, 4000);
            setTimeout(function(){
                window.location.reload();
            },4001);
        },
        1000: function(){
            //Personalizes arror
            alert('First sigin please.');
        },
        500: function(){
            console.log("Error 500");
            var $toastContent = $('<div class="red lighten-1">Internal server error.</div>');
            Materialize.toast($toastContent, 4000);
        },
        503: function(){
            console.log("Error 503");
        }
    }
};