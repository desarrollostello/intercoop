<?php $__env->startSection('content'); ?>
    <div class="container row">
        <div class="col l4 hide-on-med-and-down aside-left-menu no-padding padding-r">
            <div class="collection">
                <!-- Aside menu left -->
            <?php echo $__env->make('includes.aside-menu-left', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <!-- End aside menu left -->
            </div>
        </div>
        <div class="col s12 l8 no-padding mmargin-t">
            <div class="col s12 white border-thin">
                <div class="edit-basic-info">
                    <?php echo e(Form::open(['url'=>'','class'=>'form-basic-info'])); ?>

                        <div class="header">
                            <h5 class="truncate">Basic info</h5>
                        </div>
                        <div class="divider"></div>
                        <div class="input-field col s12">
                            <a href="#" class="prefix icon-edit edit-profile-username"></a>
                            <input type="text" id="user_name" name="user_name" value="<?php echo e(Auth::user()->user_name); ?>" disabled>
                            <label for="user_name">Username:</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="text" id="first_name" name="first_name" value="<?php echo e(Auth::user()->first_name); ?>">
                            <label for="first_name">Fisrt name:</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input type="text" id="last_name" name="last_name" value="<?php echo e(Auth::user()->last_name); ?>">
                            <label for="last_name">Last name:</label>
                        </div>
                        <div class="input-field col s12">
                            <a href="#" class="prefix icon-edit edit-profile-email"></a>
                            <input type="email" id="email" name="email" value="<?php echo e(Auth::user()->email); ?>" disabled>
                            <label for="email">Email:</label>
                        </div>
                        <div class="input-field col s12">
                            <?php if(\Pheaks\SocialConnect::select('register_used')->where('user_id', '=',Auth::user()->id)->first() ): ?>
                                <?php if(!\Pheaks\SocialConnect::select('register_used')->where('user_id', '=',Auth::user()->id)->first()->register_used): ?>
                                <a href="#" class="prefix icon-edit change-password"></a>
                                <?php endif; ?>
                            <?php else: ?>
                                <a href="#" class="prefix icon-edit change-password"></a>
                            <?php endif; ?>
                            <input type="password" id="password" value="********" name="password" disabled>
                            <label for="password">Password:</label>
                        </div>
                        <div class="input-field col s12">
                            <input type="text" id="birthday" name="birthday" class="datepicker" value="<?php echo e(Auth::user()->birthday); ?>">
                            <label for="birthday">Birthday:</label>
                        </div>
                        <div class="input-field col s12 margin-b">
                            <button type="submit" class="waves-effect btn blue">Update</button>
                        </div>
                    <?php echo e(Form::close()); ?>

                </div>
            </div>
            <div class="col s12 white border-thin margin-t">
                <div class="edit-personal-info">

                    <?php echo e(Form::open(['url'=>'','class'=>'form-personal-info'])); ?>

                        <div class="header">
                            <h5 class="truncate">Personal info</h5>
                        </div>
                        <div class="divider"></div>
                        <div class="input-field col s12">
                            <input type="text" id="sign" name="zodiac_sign" value="<?php echo e(Auth::user()->profile->zodiac_sign); ?>">
                            <label for="sign">Sign:</label>
                        </div>
                        <div class="input-field col s12">
                            <input type="text" id="height" name="height" value="<?php echo e(Auth::user()->profile->height); ?>">
                            <label for="height">Height:</label>
                        </div>
                        <div class="input-field col s12">
                            <select name="complexion" id="complexion">
                                <option value="">Undefined</option>
                                <option value="fat">Fat</option>
                                <option value="normal">Normal</option>
                                <option value="slim">Slim</option>
                            </select>
                            <label for="complexion">Complexion:</label>
                        </div>
                        <div class="input-field col s12">
                            <select name="civil_status" id="civil-status">
                                <option value="">Undefined</option>
                                <option value="married">Married</option>
                                <option value="single">Single</option>
                                <option value="other">Other</option>
                            </select>
                            <label for="civil-status">Civil status:</label>
                        </div>
                        <div class="input-field col s12">
                            <select name="children" id="children">
                                <option value="">Undefined</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                            <label for="children">Childrens:</label>
                        </div>
                        <div class="input-field col s12">
                            <!--<input type="text" id="sex" name="sex" value="<?php echo e(Auth::user()->sex == "f" ? "Female" : "Male"); ?>">-->
                            <?php echo e(Form::select('sex_preference', ['f'=>'Female','m'=>'Male','b'=>'Bisexual'], Auth::user()->profile->sex_preference)); ?>

                            <label for="sex">Prefences:</label>
                        </div>
                        <div class="input-field col s12">
                            <select name="language" id="language">
                                <option value="es">Spanish</option>
                                <option value="en">English</option>
                            </select>
                            <label for="language">Language:</label>
                        </div>
                        <div class="input-field col s12">
                            <select name="education" id="education">
                                <option value="">Undefined</option>
                                <option value="secundaria">Secundaria</option>
                                <option value="preparatoria">Preparatoria</option>
                                <option value="licenciatura">Licenciatura</option>
                                <option value="diplomado">Diplomado</option>
                            </select>
                            <label for="education">Education</label>
                        </div>
                        <div class="input-field col s12">
                            <?php echo e(Form::select('smoking', ['yes'=>'Yes','ocasionally'=>'Ocasionally','no'=>'No'], Auth::user()->profile->smoking)); ?>

                            <label for="smoking">Smoking</label>
                        </div>
                        <div class="col s12 no-padding">
                            <h5 class="truncate">Location</h5>
                        </div>
                        <div class="col s12 divider"></div>
                        <div class="input-field col s12">
                            <select name="country" id="country">
                                <?php foreach(Pheaks\Countries::all() as $key => $country): ?>
                                    <option value="<?php echo e($country->nicename); ?>" data-iso="<?php echo e($country->iso); ?>" <?php if(Auth::user()->profile->country == $country->nicename): ?> selected <?php endif; ?>><?php echo e($country->nicename); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <label for="country">Country:</label>
                        </div>
                        <div class="input-field col s12">
                            <select name="region" id="region">
                                <?php if(Auth::user()->profile->region): ?>
                                    <option value="<?php echo e(Auth::user()->profile->region); ?>"><?php echo e(Auth::user()->profile->region); ?></option>
                                <?php endif; ?>
                            </select>
                            <label for="region">Region:</label>
                        </div>

                        <div class="input-field col s12">
                            <select name="citie" id="citie">
                                <?php if(Auth::user()->profile->citie): ?>
                                    <option value="<?php echo e(Auth::user()->profile->region); ?>"><?php echo e(Auth::user()->profile->region); ?></option>
                                <?php endif; ?>
                            </select>
                            <label for="region">Region:</label>
                        </div>
                        <div class="input-field col s12 margin-b">
                            <button class="btn waves-effect blue">Update</button>
                        </div>
                    <?php echo e(Form::close()); ?>

                </div>
            </div>
            <div class="col s12 white border-thin margin-t">
                <div class="about-me">
                    <?php echo e(Form::open(['route'=>'updatedescription','class'=>'profile-form-decription'])); ?>

                        <div class="input-field col s12">
                            <?php /*<textarea name="description" id="about-me" class="materialize-textarea" cols="30" rows="10">
                                <?php echo e(Auth::user()->profile->description); ?>

                            </textarea>*/ ?>
                            <?php echo e(Form::textarea("description", Auth::user()->profile->description, ['class'=>'materialize-textarea','id'=>'about-me'])); ?>

                            <label for="about-me">My description:</label>
                        </div>
                        <div class="input-field col s12 margin-b">
                            <button class="btn waves-effect blue">Update</button>
                        </div>
                    <?php echo e(Form::close()); ?>

                </div>
            </div>
            <div class="col s12 white border-thin margin-t">
                <div class="col s12 padding-tb">
                    <button class="btn waves-effect waves-block red lighten-1 disable-my-accound">Disable my accound</button>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('main-javascripts'); ?>
    @parent
    <script src="<?php echo e(asset('js/jquery.validate.min.js')); ?>"></script>
    <script>
        $(function(){$("#country").change(function(){var b=($(this),$("#region")),c=$("#country > option:selected").data("iso");$.ajax({url:'<?php echo e(url(route("get-regions"))); ?>',type:"GET",data:{iso_code:c},success:function(a){var c=JSON.parse(a);if("object"==typeof c){b.empty();for(var d in c)b.append("<option data-region='"+c[d].code+"' data-iso='"+c[d].country+"'>"+c[d].name+"</option>");b.material_select()}}})}),$("#region").change(function(){var b=($(this),$("#citie")),c=$("#region > option:selected").data("iso"),d=$("#region > option:selected").data("region");$.ajax({url:'<?php echo e(url(route("get-cities"))); ?>',type:"GET",data:{country:c,region:d},success:function(a){var c=JSON.parse(a);if(console.log(a),"object"==typeof c){b.empty();for(var d in c)b.append("<option>"+c[d].name+"</option>");b.material_select()}}})}),$(".form-personal-info").submit(function(){var a=$(this);return $.ajax({url:'<?php echo e(url(route("updateprofilepersonalinfo"))); ?>',type:"POST",data:a.serialize(),beforeSend:function(){$(".spinner-icon-hidden").removeClass("hidden-block")},success:function(a){$(".spinner-icon-hidden").addClass("hidden-block");var b=JSON.parse(a);if("object"==typeof b)if("success"==b.status){var c="<div class='green lighten-1'>"+b.message+"</div>";Materialize.toast(c,4e3)}else{var c="<div class='red lighten-1'>"+b.message+"</div>";Materialize.toast(c,4e3)}},error:function(){var a="<div class='red lighten-1'>Unknown error</div>";Materialize.toast(a,4e3)}}).statusCode(statusCodes()),!1}),$(".form-basic-info").submit(function(){var a=$(this);return $.ajax({url:'<?php echo e(url(route("updateProfileBasicInfo"))); ?>',type:"POST",data:a.serialize(),beforeSend:function(){$(".spinner-icon-hidden").removeClass("hidden-block")},success:function(a){$(".spinner-icon-hidden").addClass("hidden-block");var b=JSON.parse(a);if("object"==typeof b)if("success"==b.status){var c="<div class='green lighten-1'>"+b.message+"</div>";Materialize.toast(c,4e3)}else{var c="<div class='red lighten-1'>"+b.message+"</div>";Materialize.toast(c,4e3)}},error:function(){var a="<div class='red lighten-1'>Unknown error</div>";Materialize.toast(a,4e3)}}),!1}),$(".edit-profile-email").click(function(){$.ajax({url:'<?php echo e(url("/getajax/editemail")); ?>',type:"GET",beforeSend:function(){$(".spinner-icon-hidden").removeClass("hidden-block")},success:function(a){$(".spinner-icon-hidden").addClass("hidden-block"),$("#main-modal").html(a),$("#main-modal").openModal()},error:function(){var a="<div class='red lighten-1'>Unknown error</div>";Materialize.toast(a,4e3)}})}),$(".edit-profile-username").click(function(){$.ajax({url:'<?php echo e(url("/getajax/editusername")); ?>',type:"GET",beforeSend:function(){$(".spinner-icon-hidden").removeClass("hidden-block")},success:function(a){$(".spinner-icon-hidden").addClass("hidden-block"),$("#main-modal").html(a),$("#main-modal").openModal()},error:function(){var a="<div class='red lighten-1'>Unknown error</div>";Materialize.toast(a,4e3)}})}),$(".change-password").click(function(){$.ajax({url:'<?php echo e(url("/getajax/changepassword")); ?>',type:"GET",beforeSend:function(){$(".spinner-icon-hidden").removeClass("hidden-block")},success:function(a){$(".spinner-icon-hidden").addClass("hidden-block"),$("#main-modal").html(a),$("#main-modal").openModal();var b=$(document).find(".form-change-password");b.validate({onclick:!1,rules:{current_pass:"required",password:"required",password_confirmation:{equalTo:"#password"}},messages:{password:"The current password is required.",equalTo:"Passwords do not match."},errorPlacement:function(a,b){var c="<div class='red lighten-1'>"+a.text()+"</div>";Materialize.toast(c,4e3),console.log(typeof b),$(b).addClass("invalid")},submitHandler:function(a,c){return c.preventDefault(),$.ajax({url:'<?php echo e(route("updatepassword")); ?>',type:"POST",data:b.serialize(),beforeSend:function(){$(".spinner-icon-hidden").removeClass("hidden-block")},success:function(a){console.log(a),$(".spinner-icon-hidden").addClass("hidden-block");var b=JSON.parse(a);if("object"==typeof b)if("success"==b.status){var c="<div class='green lighten-1'>"+b.message+"</div>";void 0!=b.message&&Materialize.toast(c,4e3),$("#main-modal").closeModal()}else{var c="<div class='red lighten-1'>"+b.message+"</div>";Materialize.toast(c,4e3)}},error:function(){var a="<div class='red lighten-1'>Unknown error</div>";Materialize.toast(a,4e3)}}),!1}})},error:function(){var a="<div class='red lighten-1'>Unknown error</div>";Materialize.toast(a,4e3)}})}),$(document).on("keyup",".username",function(){var a=$(this),b=a.val();$.ajax({url:'<?php echo e(route("existsusername")); ?>',type:"POST",data:{_token:$("#application-token").data("token"),user:b},beforeSend:function(){$(".spinner-icon-hidden").removeClass("hidden-block")},success:function(b){if($(".spinner-icon-hidden").addClass("hidden-block"),status=parseInt(b),1==status){a.css({"border-bottom":"1px solid #F44336","box-shadow":"0 1px 0 0 #F44336"});var c=$('<div class="red lighten-1">username already been used</div>');Materialize.toast(c,4e3),validate_signup_form=!1}else a.removeAttr("style"),validate_signup_form=!0}}).statusCode({500:function(){Materialize.toast("Permision denied")}})}),$(document).on("submit",".form-edit-username",function(){var a=$(this),b=a.find('input[name="user_name"]').val();if(""==b||void 0==b){var c="<div class='red lighten-1'>Insert your username.</div>";Materialize.toast(c,4e3)}else $.ajax({url:'<?php echo e(route("updateusername")); ?>',type:"POST",data:a.serialize(),beforeSend:function(){$(".spinner-icon-hidden").removeClass("hidden-block")},success:function(a){$(".spinner-icon-hidden").addClass("hidden-block");var b=JSON.parse(a);if("object"==typeof b)if("success"==b.status){var c="<div class='green lighten-1'>"+b.message+"</div>";void 0!=b.message&&Materialize.toast(c,4e3),$('input[name="user_name"]').val(value_email),$("#main-modal").closeModal()}else{var c="<div class='red lighten-1'>"+b.message+"</div>";Materialize.toast(c,4e3)}},error:function(){var a="<div class='red lighten-1'>Unknown error</div>";Materialize.toast(a,4e3)}});return!1}),$(document).on("submit",".form-edit-email",function(){var a=$(this),b=a.find('input[type="email"]').val();if(""==b||void 0==b){var c="<div class='red lighten-1'>Insert a valid email.</div>";Materialize.toast(c,4e3)}else $.ajax({url:'<?php echo e(route("updateemail")); ?>',type:"POST",data:a.serialize(),beforeSend:function(){$(".spinner-icon-hidden").removeClass("hidden-block")},success:function(a){$(".spinner-icon-hidden").addClass("hidden-block");var c=JSON.parse(a);if("object"==typeof c)if("success"==c.status){var d="<div class='green lighten-1'>"+c.message+"</div>";void 0!=c.message&&Materialize.toast(d,4e3),$('input[type="email"]').val(b),$("#main-modal").closeModal()}else{var d="<div class='red lighten-1'>"+c.message+"</div>";Materialize.toast(d,4e3)}},error:function(){var a="<div class='red lighten-1'>Unknown error</div>";Materialize.toast(a,4e3)}});return!1}),$(".disable-my-accound").click(function(){var a=$(this),b=a.data("user");mbox.confirm("Are you sure you want to disable your account?",function(c){c&&$.ajax({url:'<?php echo e(route("disableaccound")); ?>',type:"POST",data:{_token:$("#application-token").data("token"),_user:b},beforeSend:function(){a.addClass("disabled"),$(".spinner-icon-hidden").removeClass("hidden-block")},success:function(b){if(a.removeClass("disabled"),$(".spinner-icon-hi dden").addClass("hidden-block"),"object"==typeof b){if("success"==b.status)var c=$('<div class="green lighten-1"><i class="icon-ok-sign"></i> '+b.message+"</div>");else if("error"==b.status)var c=$('<div class="red lighten-1">'+b.message+"</div>");Materialize.toast(c,5e3),setTimeout(function(){window.location.href='<?php echo e(url("/")); ?>'},5e3)}}}).statusCode(statusCodes())})})});
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>