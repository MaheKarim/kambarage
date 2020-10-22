<div class="col-md-12 pall-20">
    <div class="row ">
		<div class="col-md-4">
			<div class="user-sidebar">
				<div class="user-body user-profile text-center">
					<div class="user-img">
					<?php
						$default = URL::asset(\Config::get('constant.USER.DEFAULT_IMAGE'));
                           			 if(isset($user_data->image) && $user_data->image != null){
                     			           $image = fileExitsCheck($default,'uploads/profile-image',$user_data->image);
                           			 }else{
                           			     $image = $default;
						}
					?>
						<img class="rounded-circle width-max-150 img-fluid image" src="{{ $image }}" alt="user-image" />
					</div>
					<div class="sideuser-info">
						<a>{{$user_data->email}}</a>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-8">
			<div class="user-content">
				{!! Form::model($user_data, ['route'=>'user.update','method' => 'POST','data-toggle' => 'validator', 'enctype'=> 'multipart/form-data','id' => 'user-form']) !!}
					<input type="hidden" name="profile" value="profile">
					{!! Form::hidden('username') !!}
					{!! Form::hidden('email') !!}
				    {!! Form::hidden('id', null, array('placeholder' => 'id','class' => 'form-control')) !!}
				    <div class="row ">

                        @if($user_data->is('admin'))
                            <div class="col-md-6">
                                <div class="form-group  has-feedback">
                                    <label class="col-md-12 control-label">{{trans('messages.email')}} <span class="required">*</span></label>
                                    <div class="col-md-12">
                                        {!! Form::email('email', null, array('placeholder' => trans('messages.email'),'class' => 'form-control','required')) !!}
                                    </div>
                                </div>
                            </div>
                        @endif

				        <div class="col-md-6">
				            <div class="form-group  has-feedback">
				                <label class="col-md-12 control-label">{{trans('messages.full_name')}} <span class="required">*</span></label>
				                <div class="col-md-12">
				                    {!! Form::text('name', null, array('placeholder' => trans('messages.full_name'),'class' => 'form-control','required')) !!}
				                </div>
				            </div>
				        </div>

				        <div class="col-md-6">
				            <div class="form-group  has-feedback">
				                <label class="col-md-12 control-label">{{trans('messages.contact_no')}} <span class="required">*</span></label>
				                <div class="col-md-12">
				                    {!! Form::text('contact_number', null, array('placeholder' => trans('messages.contact_no'),'class' => 'form-control', 'pattern'=>"[0-9]{6,12}", 'data-minlength'=>'10','maxlength'=>13,'data-error'=>"Phone number is invalid",'required')) !!}
									{{--<span class="help-block with-errors">--}}
								</div>
				            </div>
				        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-12 control-label">{{trans('messages.choose_profile_image')}}</label>
                                <div class="row mlr-0">
                                    <div class="col-md-12">
                                        <div class="custom-file col-md-12">
                                            {!! Form::file('profile_image', ['class'=>"custom-file-input custom-file-input-sm detail" , 'id'=>"profile_image" , 'lang'=>"en" ,  'accept'=>"image/*"]) !!}
                                            <label class="custom-file-label" for="profile_image">Profile Image</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

				        @if($user_data->is('admin'))
				        <div class="col-md-12">
				            <div class="form-group  has-feedback">
				                <label class="col-md-12 control-label">Portfolio</label>
				                <div class="col-md-12">
				                    {!! Form::textarea('portfolio', null, array('placeholder' =>'Portfolio','class' => 'form-control textarea','rows' => 4)) !!}

				                </div>
				            </div>
				        </div>
				        @endif


				        <div class="col-md-12">
							{!! Form::submit(trans('messages.update'), ['class'=>"btn btn-md btn-primary float-md-right"]) !!}
				        </div>
				    </div>
			</div>
		</div>
    </div>
</div>

<script>

	function readURL(input) {
	  if (input.files && input.files[0]) {
	    var reader = new FileReader();

	    var res=isImage(input.files[0].name);

	    if(res==false){
	        var msg='Image should be png/PNG, jpg/JPG & jpeg/JPG.';
	        Snackbar.show({text: msg ,pos: 'bottom-center',backgroundColor:'#f94b4b',actionTextColor:'white'});
	        return false;
	    }

	    reader.onload = function(e) {
	      $('.image').attr('src', e.target.result);
	    }

	    reader.readAsDataURL(input.files[0]);
	  }
	}

	function getExtension(filename) {
	    var parts = filename.split('.');
	    return parts[parts.length - 1];
	}

	function isImage(filename) {
	    var ext = getExtension(filename);
	    switch (ext.toLowerCase()) {
	    case 'jpg':
	    case 'jpeg':
	    case 'png':
	    case 'gif':
	        return true;
	    }
	    return false;
	}

	$(".filestyle2").filestyle({size: "xs",btnClass: "button xs"});

    $(".filestyle2").change(function(event) {
      readURL(this);
    });

    $(document).ready(function(){
    	if (typeof(tinyMCE) != "undefined") {
    	    tinymce.init({
    	        selector: '.textarea',
    	        height: 100,
    	        theme: 'modern',
    	        content_css: [
    	            // 'http://fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
    	            // 'http://www.tinymce.com/css/codepen.min.css'
    	        ],
    	        image_advtab: true,
    	        plugins: "textcolor colorpicker image imagetools media charmap link print textcolor code codesample table",
    	        toolbar: "image undo redo | link image | code table",
    	        toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent | forecolor backcolor | removeformat | code',
    	        image_title: true,
    	        automatic_uploads: true,
    	        file_picker_types: 'image',
    	        file_picker_callback: function (cb, value, meta) {
    	            var input = document.createElement('input');
    	            input.setAttribute('type', 'file');
    	            input.setAttribute('accept', 'image/*');

    	            input.onchange = function () {
    	                var file = this.files[0];

    	                var reader = new FileReader();
    	                reader.onload = function () {
    	                    var id = 'blobid' + (new Date()).getTime();
    	                    var blobCache = tinymce.activeEditor.editorUpload.blobCache;
    	                    var base64 = reader.result.split(',')[1];
    	                    var blobInfo = blobCache.create(id, file, base64);
    	                    blobCache.add(blobInfo);

    	                    cb(blobInfo.blobUri(), {title: file.name});
    	                };
    	                reader.readAsDataURL(file);
    	            };

    	            input.click();
    	        }
    	    });
    	}
    });
</script>
