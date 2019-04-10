
<div class="modal-content">
    <div class="chage-lang-modal row">
        <div class="row">
            <div class="col s12 white padding-tb">
                <div class="col s6 m4 no-padding">
                    <!--<a href="#test1" class="blue-text lighten-1 padding text-lowercase">
                        <i class="icon-camera"></i> <span class="text-lowercase">Photo</span>
                    </a>-->
                    <span class="padding text-lowercase">Add new photo</span>
                </div>
                <div class="tab col s12 m4 hide-on-small-only">
                    <!--<a class="active" href="#test2">Picture</a>-->
                </div>
                <div class="tab col s12 m4 hide-on-small-only">
                    <!--<a href="#test4">Test 4</a>-->
                </div>
                <div class="col s6 m4">

                </div>
            </div>
            <div class="col s12 no-padding">
                <?php echo Form::open(['route'=>'postphoto','class'=>'col s12 no-padding new-photo','onsubmit'=>'return false','files'=>'true']); ?>

                <div class="row">
                    <div class="post-avatar padding col m2 hide-on-small-only">
                        <img src="<?php echo e(asset(Auth::user()->profile->avatar->small)); ?>" alt="avatar" class="responsive-img circle profile-avatar-small" style="max-height: 100%;">
                    </div>
                    <div class="file-field input-field col s12 m10">
                        <div class="btn blue lighten-1">
                            <span>Photo</span>
                            <input type="file" name="file" id="photo-upload">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text">
                        </div>
                    </div>
                    <div class="col s12">
                        <div class="image-holder"></div>
                    </div>
                    <div class="col s12 no-padding valign-wrapper">
                        <div class="input-filed col s12 m6 margin-t  center">
                            <!--<p>
                                <label for="" class="active">Who can see this?</label>
                            </p>-->
                            <span>
                                <input name="privacy" type="radio" id="public-privacy" value="1" class="with-gap" checked />
                                <label for="public-privacy">Public</label>
                            </span>
                            <span>
                                <input name="privacy" type="radio" id="justme-privacy" value="0" class="with-gap" />
                                <label for="justme-privacy">just me.</label>
                            </span>
                        </div>
                        <div class="input-filed col s12 m3 margin-t valign">
                            <button class="btn waves-effect waves-light blue col s12" name="submit" type="submit">Publish</button>
                        </div>
                        <div class="input-filed col s12 m3 margin-t valign">
                            <button type="button" class="modal-action modal-close grey lighten-3 waves-effect waves-blue btn-flat col s12">Cancel</button>
                        </div>
                    </div>
                </div>
                <?php echo Form::close(); ?>

            </div>
        </div>
    </div>
</div>
<!--<div class="modal-footer"></div>-->