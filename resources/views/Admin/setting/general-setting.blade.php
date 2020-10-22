
    {!! Form::model($settings, ['method' => 'POST','route' => ['settingsUpdates'],'enctype'=>'multipart/form-data','data-toggle'=>'validator']) !!}

    {!! Form::hidden('id', null, array('placeholder' => 'id','class' => 'form-control')) !!}
    {!! Form::hidden('page', $page, array('placeholder' => 'id','class' => 'form-control')) !!}

    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="avatar" class="col-sm-3 control-label">Logo</label>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-6">
                                    <img src="{{ getSingleMedia($settings,'site_logo',null) }}" width="150" alt="person" class="image">
                                </div>
                                <div class="col-sm-6">
                                    <div class="custom-file col-md-12">
                                        {!! Form::file('site_logo', ['class'=>"custom-file-input custom-file-input-sm detail" , 'id'=>"site_logo" , 'lang'=>"en"]) !!}
                                        <label class="custom-file-label" for="site_logo">Logo</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="avatar" class="col-sm-3 control-label">Favicon</label>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-6">
                                    <img src="{{ getSingleMedia($settings,'site_favicon',null) }}" height="150" alt="person" class="image">
                                </div>
                                <div class="col-sm-6">
                                    <div class="custom-file col-md-12">
                                        {!! Form::file('site_favicon', ['class'=>"custom-file-input custom-file-input-sm detail" , 'id'=>"site_favicon" , 'lang'=>"en"]) !!}
                                        <label class="custom-file-label" for="site_favicon">Favicon</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                </div>
                <div class="col-md-6">
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="col-md-offset-3 col-sm-12 ">
                            {!! Form::submit('Save Changes', ['class'=>"btn btn-md btn-primary float-md-right"]) !!}
                        </div>
                    </div>
                </div>
            </div>
         </div>
    </div>
{!! Form::close() !!}

<script type="text/javascript">
    $(".filestyle_js").change(function(event) {
        $(document).find(".filestyle_js").filestyle({btnClass: "btn btn-primary btn-sm "});
        readURL(this);
    });

    //Filestyle JS code..
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
        }});
</script>
