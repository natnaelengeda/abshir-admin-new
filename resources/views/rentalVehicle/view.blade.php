@extends('layouts.app')

@section('content')
	<div class="page-wrapper">
    <div class="row page-titles">

        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">{{trans('lang.vehicle_plural')}} <span class="itemTitle"></span></h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                <li class="breadcrumb-item"><a href= "{!! route('rentalvehicle') !!}" >{{trans('lang.vehicle_plural')}}</a></li>
                <li class="breadcrumb-item active">{{trans('lang.vehicle_details')}}</li>
            </ol>
        </div>

  </div>

   <div class="container-fluid">
   	  <div class="row">
   		  <div class="col-12">

            <div class="resttab-sec">
              <div id="data-table_processing" class="dataTables_processing panel panel-default" style="display: none;">{{trans('lang.processing')}}</div>
              <div class="menu-tab">
                <ul>
                  <li >
                      <a href="{{route('drivers.view',$id)}}">{{trans('lang.tab_basic')}}</a>
                  </li>
									<li class="active">
                      <a href="{{route('drivers.vehicle',$id)}}">{{trans('lang.vehicle')}}</a>
                  </li>
                  <li>
                      <a href="{{route('drivers.ride',$id)}}">{{trans('lang.rides')}}</a>
                  </li>
                  <li>
                      <a href="{{route('payoutRequests.drivers.view',$id)}}">{{trans('lang.tab_payouts')}}</a>
                  </li>


                </ul>

              </div>

            </div>

        <div class="row vendor_payout_create">
            <div class="vendor_payout_create-inner">
                <fieldset>
                    <legend>{{trans('lang.vehicle_details')}}</legend>
                          <div class="form-group row width-50">
                          <label class="col-3 control-label">{{trans('lang.car_name')}}</label>
                          <div class="col-7" class="car_name">
                              <span class="car_name" id="car_name"></span>
                            </div>
                        </div>

                        <div class="form-group row width-50">
                          <label class="col-3 control-label">{{trans('lang.car_number')}}</label>
                          <div class="col-7">
                          <span class="car_number"></span>
                          </div>
                        </div>

                        <div class="form-group row width-50">
                          <label class="col-3 control-label">{{trans('lang.car_model')}}</label>
                          <div class="col-7">
                          <span class="car_model"></span>
                          </div>
                        </div>
                        <div class="form-group row width-50">
                          <label class="col-3 control-label">{{trans('lang.car_image')}}</label>
                          <div class="col-7 car_image">
                          </div>
                          </div>
                        <div class="form-group row width-50" id="div_service_type">
                          <label class="col-3 control-label">{{trans('lang.vehicle_type')}}</label>
                          <div class="col-7">
                          <span class="vehicle_type"></span>
                          </div>
                        </div>
                        <div class="form-group row width-50" id="div_service_type">
                          <label class="col-3 control-label">{{trans('lang.car_color')}}</label>
                          <div class="col-7">
                          <span class="vehicle_color"></span>
                          </div>
                        </div>
			<!-- <div class="form-group row width-50">
			  <label class="col-3 control-label">{{trans('lang.type')}}</label>
			  <div class="col-7">
			  <span class="type"></span>
			  </div>
			</div> -->
                        <div class="form-group row width-50" id="div_service_type1">
                          <label class="col-3 control-label">{{trans('lang.air_conditioning')}}</label>
                          <div class="col-7">
                          <span class="air_conditioning"></span>
                          </div>
                        </div>
			<div class="form-group row width-50" id="div_service_type_doors">
                          <label class="col-3 control-label">{{trans('lang.doors')}}</label>
                          <div class="col-7">
                          <span class="doors"></span>
                          </div>
                        </div>
			<div class="form-group row width-50" id="div_service_type_fuel_filling">
                          <label class="col-3 control-label">{{trans('lang.fuel_filling')}}</label>
                          <div class="col-7">
                          <span class="fuel_filling"></span>
                          </div>
                        </div>
			<div class="form-group row width-50" id="div_service_type_fuel_type">
			  <label class="col-3 control-label">{{trans('lang.fuel_type')}}</label>
	                  <div class="col-7">
		            <span class="fuel_type"></span>
			  </div>
			</div>
												<div class="form-group row width-50" id="div_service_type_gear">
													<label class="col-3 control-label">{{trans('lang.gear')}}</label>
													<div class="col-7">
													<span class="gear"></span>
													</div>
												</div>
												<div class="form-group row width-50" id="div_service_type_max_power">
													<label class="col-3 control-label">{{trans('lang.max_power')}}</label>
													<div class="col-7">
													<span class="max_power"></span>
													</div>
												</div>
												<div class="form-group row width-50" id="div_service_type_mileage">
													<label class="col-3 control-label">{{trans('lang.mileage')}}</label>
													<div class="col-7">
													<span class="mileage"></span>
													</div>
												</div>
												<div class="form-group row width-50" id="div_service_type_mph">
													<label class="col-3 control-label">{{trans('lang.mph')}}</label>
													<div class="col-7">
													<span class="mph"></span>
													</div>
												</div>

												<div class="form-group row width-50" id="div_service_type_top_speed">
													<label class="col-3 control-label">{{trans('lang.top_speed')}}</label>
													<div class="col-7">
													<span class="top_speed"></span>
													</div>
												</div>
												<div class="form-group row width-50" id="div_service_type_passengers">
													<label class="col-3 control-label">{{trans('lang.passengers')}}</label>
													<div class="col-7">
													<span class="passengers"></span>
													</div>
												</div>


                </fieldset>


      <!-- <div class="row vendor_payout_create">
          <div class="vendor_payout_create-inner"> -->
                <!-- <fieldset class="company_details" style="display:none">
                  <legend>{{trans('lang.company_details')}}</legend>

									<div  >
									<div class="form-group row width-50 ">
										<label class="col-3 control-label">{{trans('lang.company_name')}}</label>
										<div class="col-7">
										<span class="company_name"></span>
										</div>
									</div>
									<div class="form-group row width-50 ">
										<label class="col-3 control-label">{{trans('lang.company_address')}}</label>
										<div class="col-7">
										<span class="company_address"></span>
										</div>
									</div>
									</div>



                    </fieldset> -->
                  </div>
              </div>
                <div class="form-group col-12 text-center btm-btn">
                  <a href="{!! route('drivers') !!}" class="btn btn-default"><i class="fa fa-undo"></i>{{trans('lang.cancel')}}</a>
                </div>

          </div>
        </div>
</div>

@endsection

@section('scripts')

<script type="text/javascript">

var id = "<?php echo $id;?>";
var database = firebase.firestore();
var ref = database.collection('users').where("id","==",id);
var photo ="";
var vendorOwnerId = "";
var vendorOwnerOnline = false;

var placeholderImage = '';
var placeholder = database.collection('settings').doc('placeHolderImage');

placeholder.get().then( async function(snapshotsimage){
  var placeholderImageData = snapshotsimage.data();
  placeholderImage = placeholderImageData.image;
})

$(document).ready(async function(){
  		
      jQuery("#data-table_processing").show();
  		
      ref.get().then( async function(snapshots){

        var dirver = snapshots.docs[0].data();
       // console.log(dirver.carModelName);
        $(".driver_name").text(dirver.firstName);

        if (dirver.serviceType == "cab-service") {
          $(".car_name").text(dirver.carMakes);
          $(".car_model").text(dirver.carModelName);
          $(".vehicle_type").text(dirver.vehicleType)
          $(".vehicle_color").text(dirver.carColor)
          $(".car_number").text(dirver.carNumber);

        }else{
        $(".email").text(dirver.email);
        $(".phone").text(dirver.phoneNumber);
        $(".car_name").text(dirver.carName);
        $(".car_number").text(dirver.carNumber);
        $(".car_model").text(dirver.carModelName);

        }
        //$(".vehicle_type").text(dirver.vehicleType);

        if (dirver.serviceType == "rental-service") {
          $(".vehicle_type").text(dirver.vehicleType);
        } else {
          $('#div_service_type').hide();
        }
        
      

        if(dirver.companyName != ""){
          $(".type").text('Company');
          $(".company_details").show();
          $(".company_address").text(dirver.companyAddress)
          $(".company_name").text(dirver.companyName)
        }else{
          $(".type").text('Individual');
        }
        var image="";
        if (dirver.carPictureURL) {
          image='<img width="200px" id="" height="auto" src="'+dirver.carPictureURL+'">';
        }else{
          image='<img width="200px" id="" height="auto" src="'+placeholderImage+'">';
        }
        $(".car_image").html(image);

        var driver_image="";
        if (dirver.profilePictureURL) {
          driver_image='<img width="200px" id="" height="auto" src="'+dirver.profilePictureURL+'">';
        }else{
          driver_image='<img width="200px" id="" height="auto" src="'+placeholderImage+'">';
        }
        $(".profile_image").html(driver_image);
        //$(".air_conditioning").text(dirver.carInfo.air_conditioning);
        if (dirver.serviceType == "rental-service") {
          $(".air_conditioning").text(dirver.carInfo.air_conditioning);
        } else {
          $('#div_service_type1').hide();
        }
        //$(".doors").text(dirver.carInfo.doors);
        if (dirver.serviceType == "rental-service") {
          $(".doors").text(dirver.carInfo.doors);
        } else {
          $('#div_service_type_doors').hide();
        }
        //$(".fuel_filling").text(dirver.carInfo.fuel_filling);
        if (dirver.serviceType == "rental-service") {
          $(".fuel_filling").text(dirver.carInfo.fuel_filling);
        } else {
          $('#div_service_type_fuel_filling').hide();
        }
        //$(".fuel_type").text(dirver.carInfo.fuel_type);
        if (dirver.serviceType == "rental-service") {
          $(".fuel_type").text(dirver.carInfo.fuel_type);
        } else {
          $('#div_service_type_fuel_type').hide();
        }
        //$(".gear").text(dirver.carInfo.gear);
        if (dirver.serviceType == "rental-service") {
          $(".gear").text(dirver.carInfo.gear);
        } else {
          $('#div_service_type_gear').hide();
        }
        //$(".max_power").text(dirver.carInfo.maxPower);
        if (dirver.serviceType == "rental-service") {
          $(".max_power").text(dirver.carInfo.maxPower);
        } else {
          $('#div_service_type_max_power').hide();
        }
        //$(".mileage").text(dirver.carInfo.mileage);
        if (dirver.serviceType == "rental-service") {
          $(".mileage").text(dirver.carInfo.mileage);
        } else {
          $('#div_service_type_mileage').hide();
        }
        //$(".mph").text(dirver.carInfo.mph);
        if (dirver.serviceType == "rental-service") {
          $(".mph").text(dirver.carInfo.mph);
        } else {
          $('#div_service_type_mph').hide();
        }
        //$(".passengers").text(dirver.carInfo.passenger);
        if (dirver.serviceType == "rental-service") {
          $(".passengers").text(dirver.carInfo.passenger);
        } else {
          $('#div_service_type_passengers').hide();
        }
        //$(".top_speed").text(dirver.carInfo.topSpeed);
        if (dirver.serviceType == "rental-service") {
          $(".top_speed").text(dirver.carInfo.topSpeed);
        } else {
          $('#div_service_type_top_speed').hide();
        }

        jQuery("#data-table_processing").hide();

		})

})

</script>

@endsection
