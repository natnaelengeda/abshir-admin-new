@extends('layouts.app')

@section('content')

<div class="page-wrapper">

    <div class="row page-titles">


        <div class="col-md-5 align-self-center">

            <h3 class="text-themecolor">{{trans('lang.destination')}}</h3>

        </div>

        <div class="col-md-7 align-self-center">

            <ol class="breadcrumb">

                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>

                <li class="breadcrumb-item"><a href="{!! route('destinations') !!}">{{trans('lang.destination')}}</a></li>

                <li class="breadcrumb-item active">{{trans('lang.destination_create')}}</li>

            </ol>

        </div>

    </div>

    <div class="card-body">

        <div id="data-table_processing" class="dataTables_processing panel panel-default" style="display: none;">
            {{trans('lang.processing')}}
        </div>

        <div class="error_top"></div>

        <div class="row vendor_payout_create">

            <div class="vendor_payout_create-inner">

                <fieldset>

                    <legend>{{trans('lang.destination')}}</legend>


                    <div class="form-group row width-50">

                        <label class="col-3 control-label">{{trans('lang.title')}}</label>

                        <div class="col-7">

                            <input type="text" class="form-control title">

                        </div>

                    </div>
                    <div class="form-group row width-50">
                        <label class="col-3 control-label ">{{trans('lang.select_section')}}</label>
                        <div class="col-7">
                            <select name="section_id" id="section_id" class="form-control">
                                <option value="">{{trans('lang.select')}}</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row width-50">
                        <label class="col-3 control-label">{{trans('lang.vendor_latitude')}}</label>
                        <div class="col-7">
                            <input class="form-control latitude" type="number" min="-90" max="90" onkeypress="return chkAlphabets3(event,'error1')"><div id="error1" class="err"></div>
                        </div>
                    </div>

                    <div class="form-group row width-50">
                        <label class="col-3 control-label">{{trans('lang.vendor_longitude')}}</label>
                        <div class="col-7">
                            <input class="form-control longitude" type="number" min="-180" max="180" onkeypress="return chkAlphabets3(event,'error2')"><div id="error2" class="err"></div>
                        </div>
                    </div>
                    
                    <div class="form-group row width-100">
                        <div class="col-12">
                            <h6>
                                {{ trans("lang.know_your_cordinates") }} 
                                <a target="_blank" href="https://www.latlong.net/">{{trans("lang.latitude_and_longitude_finder") }}</a>
                            </h6>
                        </div>
                    </div>

                    <div class="form-group row width-50">
                        <label class="col-3 control-label">{{trans('lang.image')}}</label>
                        <div class="col-7">
                            <input type="file" onChange="handleFileSelect(event)">
                            <div class="placeholder_img_thumb destination_image"></div>
                            <div id="uploding_image"></div>
                        </div>
                    </div>

                    <div class="form-group row width-50">

                        <div class="form-check width-50">

                            <input type="checkbox" id="is_publish">

                            <label class="col-3 control-label" for="is_publish">{{trans('lang.is_publish')}}</label>

                        </div>

                    </div>
                    
                </fieldset>

            </div>
        </div>

    </div>

    <div class="form-group col-12 text-center">

        <button type="button" class="btn btn-primary  create_banner_btn"><i class="fa fa-save"></i>
            {{trans('lang.save')}}
        </button>

        <a href="{!! route('destinations') !!}" class="btn btn-default"><i class="fa fa-undo"></i>{{trans('lang.cancel')}}</a>

    </div>

</div>


@endsection

@section('scripts')

<script type="text/javascript">

var database = firebase.firestore();
var ref_sections = database.collection('sections');
var storageRef = firebase.storage().ref('images');
var sections_list = [];
var photo = "";

var placeholderImage = '';
var placeholder = database.collection('settings').doc('placeHolderImage');
placeholder.get().then(async function (snapshotsimage) {
    var placeholderImageData = snapshotsimage.data();
    placeholderImage = placeholderImageData.image;
});

$(document).ready(function () {
    ref_sections.get().then(async function (snapshots) {
        snapshots.docs.forEach((listval) => {
            var data = listval.data();
            if (data.serviceTypeFlag == "cab-service") {

            sections_list.push(data);
            $('#section_id').append($("<option></option>")
                .attr("value", data.id)
                .text(data.name));
            }
        })
    })
});

$(".create_banner_btn").click(function () {
    
    var sectionId = $('#section_id').val();
    var title = $(".title").val();
    var latitude = parseFloat($(".latitude").val());
    var longitude = parseFloat($(".longitude").val());
    var is_publish = $("#is_publish").is(':checked');

    if (title == '') {

        $(".error_top").show();

        $(".error_top").html("");

        $(".error_top").append("<p>{{trans('lang.title_error')}}</p>");

        window.scrollTo(0, 0);

    } else if (sectionId == '') {

        $(".error_top").show();

        $(".error_top").html("");

        $(".error_top").append("<p>{{trans('lang.set_section_error')}}</p>");

        window.scrollTo(0, 0);

    } else if (latitude == '' || longitude == '') {

        $(".error_top").show();

        $(".error_top").html("");

        $(".error_top").append("<p>{{trans('lang.latlong_error')}}</p>");

        window.scrollTo(0, 0);

    }else {

        var id = database.collection("tmp").doc().id;

        database.collection('popular_destinations').doc(id).set({
            'id': id,
            'title': title,
            'image': photo,
            'latitude': latitude,
            'longitude': longitude,
            'is_publish': is_publish,
            'sectionId': sectionId
        }).then(function (result) {
            window.location.href = '{{ route("destinations")}}';

        }).catch(function (error) {
            $(".error_top").show();
            $(".error_top").html("");
            $(".error_top").append("<p>" + error + "</p>");

        });
    }
});

function handleFileSelect(evt) {
    
    var f = evt.target.files[0];
    
    var reader = new FileReader();
    
    reader.onload = (function (theFile) {

        return function (e) {

            var filePayload = e.target.result;
            var val = f.name;
            var ext = val.split('.')[1];
            var docName = val.split('fakepath')[1];
            var filename = (f.name).replace(/C:\\fakepath\\/i, '')
            var timestamp = Number(new Date());
            var filename = filename.split('.')[0] + "_" + timestamp + '.' + ext;
            var uploadTask = storageRef.child(filename).put(theFile);
            
            uploadTask.on('state_changed', function (snapshot) {

                var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
                console.log('Upload is ' + progress + '% done');
                jQuery("#uploding_image").text("Image is uploading...");

            }, function (error) {
            
            }, function () {
                uploadTask.snapshot.ref.getDownloadURL().then(function (downloadURL) {
                    jQuery("#uploding_image").text("Upload is completed");
                    photo = downloadURL;
                    if (photo) {
                        setTimeout(function(){jQuery("#uploding_image").hide();},3000);
                        $(".destination_image").html('<img class="rounded" style="50px" src="' + photo + '" alt="image">');
                    }
                });
            });
        };
    })(f);
    reader.readAsDataURL(f);
}

	function chkAlphabets3(event,msg)
	{
		if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57))
		{
		document.getElementById(msg).innerHTML="Accept only Number and Dot(.)";
		return false;
		}
		else
		{
		document.getElementById(msg).innerHTML="";
		return true;
		}
	}
</script>

@endsection
