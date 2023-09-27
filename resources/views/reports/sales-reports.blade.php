@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">{{trans('lang.reports_sale')}}</h3>
            </div>

            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>
                    {{--<li class="breadcrumb-item"><a href="{{url('/reports/sales')}}">{{trans('lang.reports_sale')}}</a>
                    </li>--}}
                    <li class="breadcrumb-item active">{{trans('lang.reports_sale')}}</li>
                </ol>
            </div>
            <div>

                <div class="card-body">

                    <div id="data-table_processing" class="dataTables_processing panel panel-default"
                         style="display: none;">{{trans('lang.processing')}}</div>
                    <div class="error_top"></div>

                    <div class="row vendor_payout_create">
                        <div class="vendor_payout_create-inner">
                            <fieldset>
                                <legend>{{trans('lang.reports_sale')}}</legend>

                                <div class="form-group row width-50">
                                    <label class="col-3 control-label">{{trans('lang.select_section')}}</label>
                                    <div class="col-7">
                                        <select class="form-control section">
                                            <option value="">{{trans('lang.select_section')}}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row width-50 vendors_div">
                                    <label class="col-3 control-label">{{trans('lang.select_vendor')}}</label>
                                    <div class="col-7">
                                        <select class="form-control vendors">
                                            <option value="">{{trans('lang.all')}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row width-50">
                                    <label class="col-3 control-label">{{trans('lang.select_driver')}}</label>
                                    <div class="col-7">
                                        <select class="form-control driver">
                                            <option value="">{{trans('lang.all')}}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row width-50">
                                    <label class="col-3 control-label">{{trans('lang.select_user')}}</label>
                                    <div class="col-7">
                                        <select class="form-control customer">
                                            <option value="">{{trans('lang.all')}}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row width-50 category_div">
                                    <label class="col-3 control-label">{{trans('lang.select_category')}}</label>
                                    <div class="col-7">
                                        <select class="form-control category">
                                            <option value="">{{trans('lang.all')}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row width-100">
                                    <label class="col-3 control-label">{{trans('lang.select_date')}}</label>
                                    <div class="col-7">
                                        <div id="reportrange"
                                             style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                            <i class="fa fa-calendar"></i>&nbsp;
                                            <span></span> <i class="fa fa-caret-down"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row width-100">
                                    <label class="col-3 control-label">{{trans('lang.file_format')}}<span
                                                class="required-field"></span></label>
                                    <div class="col-7">
                                        <select class="form-control file_format">
                                            <option value="">{{trans('lang.file_format')}}</option>
                                            {{--<option value="xls">{{trans('lang.xls')}}</option>--}}
                                            <option value="csv">{{trans('lang.csv')}}</option>
                                            <option value="pdf">{{trans('lang.pdf')}}</option>
                                        </select>
                                    </div>
                                </div>


                            </fieldset>


                        </div>
                    </div>
                    <div class="form-group col-12 text-center btm-btn">
                        <button type="submit" class="btn btn-primary download-sales-report"><i
                                    class="fa fa-save"></i> {{ trans('lang.download')}}</button>

                    </div>

                </div>
            </div>

        </div>

    </div>


@endsection
@section('scripts')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>

    <script>
        var database = firebase.firestore();
        var refCurrency = database.collection('currencies').where('isActive', '==', true).limit('1');
        var vendorsRef = database.collection('vendors').orderBy('title').orderBy('createdAt');
        var driverUserRef = database.collection('users').where('role', '==', 'driver').orderBy('firstName').orderBy('createdAt');
        var customerRef = database.collection('users').where('role', '==', 'customer').orderBy('firstName').orderBy('createdAt');
        var categoryRef = database.collection('vendor_categories').orderBy('title');
        var paymentMethodRef = database.collection('settings').doc('payment');
        var refSection = database.collection('sections').where('isActive', '==', true);

        setDate();

        function setDate() {
            var start = moment().subtract(29, 'days');
            var end = moment();

            function cb(start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }

            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, cb);

            cb(start, end);
        }

        var decimal_degits = 0;
        var symbolAtRight = false;
        var currentCurrency = '';
        refCurrency.get().then(async function (snapshots) {

            var currencyData = snapshots.docs[0].data();
            currentCurrency = currencyData.symbol;
            decimal_degits = currencyData.decimalDigits;

            if (currencyData.symbolAtRight) {
                symbolAtRight = true;
            }
        });
        refSection.get().then(function (snapShots) {

            if (snapShots.docs.length > 0) {

                snapShots.docs.forEach((listval) => {
                    var data = listval.data();

                    $('.section').append('<option value="' + data.id + '" serviceType="' + data.serviceTypeFlag + '">' + data.name + '</option>');
                });

            }
        });

        paymentMethodRef.get().then(function (snapShots) {

            var data = snapShots.data();
            Object.keys(data).forEach((listval) => {

                $('.payment_method').append($("<option value='" + data[listval].name + "'>" + data[listval].name + "</option>"));
            });
        });

        customerRef.get().then(function (snapShots) {

            if (snapShots.docs.length > 0) {

                snapShots.docs.forEach((listval) => {
                    var data = listval.data();

                    $('.customer').append('<option value="' + data.id + '">' + data.firstName + ' ' + data.lastName + '</option>');
                });

            }
        });

        var arraySectionVendor = [];
        var arraySectionDriver = [];
        var arraySectionCategory = [];

        $('.section').on('change', async function () {
            var section = $(".section :selected").val();
            var sectionName = $(".section :selected").text();
            var serviceType = $(".section :selected").attr('serviceType');

            if (section != '') {

                $('#data-table_processing').show();
                if (sectionName == 'Cab Service' || sectionName == 'Parcel Service' || sectionName == 'Rental Service') {
                    $('.vendors_div').addClass('d-none');
                    $('.category_div').addClass('d-none');

                } else {

                    $('.vendors_div').removeClass('d-none');
                    $('.category_div').removeClass('d-none');


                    await database.collection('vendors').orderBy('title')/*.orderBy('createdAt')*/.where('section_id', '==', section).get().then(function (snapShots) {
                        $('.vendors').empty();
                        $('.vendors').html('<option value="">{{trans("lang.all")}}</option>');

                        if (snapShots.docs.length > 0) {

                            snapShots.docs.forEach((listval) => {
                                var data = listval.data();
                                arraySectionVendor.push(data.id);
                                $('.vendors').append('<option value="' + data.id + '">' + data.title + '</option>');
                            });

                        }
                    });

                    await database.collection('vendor_categories').orderBy('title').where('section_id', '==', section).get().then(function (snapShots) {
                        $('.category').empty();
                        $('.category').html('<option value="">{{trans("lang.all")}}</option>');

                        if (snapShots.docs.length > 0) {

                            snapShots.docs.forEach((listval) => {
                                var data = listval.data();
                                arraySectionCategory.push(data.id);

                                $('.category').append('<option value="' + data.id + '">' + data.title + '</option>');
                            });

                        }
                    });
                }


                await database.collection('users').where('role', '==', 'driver').orderBy('firstName')/*.orderBy('createdAt')*/.where('serviceType', '==', serviceType).get().then(function (snapShots) {
                    $('.driver').empty();
                    $('.driver').html('<option value="">{{trans("lang.all")}}</option>');

                    if (snapShots.docs.length > 0) {

                        snapShots.docs.forEach((listval) => {
                            var data = listval.data();
                            arraySectionDriver.push(data.id);

                            $('.driver').append('<option value="' + data.id + '">' + data.firstName + ' ' + data.lastName + '</option>');
                        });

                    }
                });

                $('#data-table_processing').hide();
            }
        });

        async function generateReport(orderData, headers, fileFormat) {

            if ((fileFormat == "pdf") ? document.title = "sales-report" : "") ;

            objectExporter({
                type: fileFormat,
                exportable: orderData,
                headers: headers,
                fileName: 'sales-report',
                columnSeparator: ',',
                headerStyle: 'font-weight: bold; padding: 5px; border: 1px solid #dddddd;',
                cellStyle: 'border: 1px solid lightgray; margin-bottom: -1px;',
                sheetName: 'sales-report',
                documentTitle: '',
            });

        }

        async function getReportData(orderSnapshots, sectionName) {

            var orderData = [];

            await Promise.all(orderSnapshots.docs.map(async (order) => {

                var orderObj = order.data();
                var orderId = orderObj.id;
                var finalOrderObject = {};

                finalOrderObject['Order ID'] = orderId;
                var driverData = ((orderObj.driver && orderObj.driver != null) ? orderObj.driver : '');

                if (sectionName == 'Cab Service') {
                    finalOrderObject['From'] = ((orderObj.sourceLocationName) ? orderObj.sourceLocationName.replace(/,/g, " ") : "");
                    finalOrderObject['To'] = ((orderObj.destinationLocationName) ? orderObj.destinationLocationName.replace(/,/g, " ") : "");
                    finalOrderObject['Driver Name'] = (driverData.firstName) ? ((driverData.lastName) ? driverData.firstName + ' ' + driverData.lastName : driverData.firstName) : "";
                    finalOrderObject['Driver Email'] = (driverData.email) ? driverData.email : "";
                    finalOrderObject['Driver Phone'] = ((driverData.phoneNumber) ? (driverData.phoneNumber.includes('+') ? driverData.phoneNumber.slice(1) : '(+) ' + driverData.phoneNumber) : '');
                    finalOrderObject['Vehicle Name'] = ((driverData.carName) ? driverData.carName : "");
                    finalOrderObject['Vehicle Make'] = ((driverData.carMakes) ? driverData.carMakes : "");
                    finalOrderObject['Vehicle Number'] = ((driverData.carNumber) ? driverData.carNumber : "");
                } else if (sectionName == 'Parcel Service') {
                    finalOrderObject['From'] = ((orderObj.sender.address) ? orderObj.sender.address.replace(/,/g, " ") : "");
                    finalOrderObject['To'] = ((orderObj.receiver.address) ? orderObj.receiver.address.replace(/,/g, " ") : "");
                    finalOrderObject['Driver Name'] = (driverData.firstName) ? ((driverData.lastName) ? driverData.firstName + ' ' + driverData.lastName : driverData.firstName) : "";
                    finalOrderObject['Driver Email'] = (driverData.email) ? driverData.email : "";
                    finalOrderObject['Driver Phone'] = ((driverData.phoneNumber) ? (driverData.phoneNumber.includes('+') ? driverData.phoneNumber.slice(1) : '(+) ' + driverData.phoneNumber) : '');
                    finalOrderObject['Vehicle Name'] = ((driverData.carName) ? driverData.carName : "");
                    finalOrderObject['Vehicle Make'] = ((driverData.carMakes) ? driverData.carMakes : "");
                    finalOrderObject['Vehicle Number'] = ((driverData.carNumber) ? driverData.carNumber : "");
                } else if (sectionName == 'Rental Service') {
                    finalOrderObject['From'] = ((orderObj.pickupAddress) ? orderObj.pickupAddress.replace(/,/g, " ") : "");
                    finalOrderObject['To'] = ((orderObj.dropAddress) ? orderObj.dropAddress.replace(/,/g, " ") : "");
                    finalOrderObject['Driver Name'] = (driverData.firstName) ? ((driverData.lastName) ? driverData.firstName + ' ' + driverData.lastName : driverData.firstName) : "";
                    finalOrderObject['Driver Email'] = (driverData.email) ? driverData.email : "";
                    finalOrderObject['Driver Phone'] = ((driverData.phoneNumber) ? (driverData.phoneNumber.includes('+') ? driverData.phoneNumber.slice(1) : '(+) ' + driverData.phoneNumber) : '');
                    finalOrderObject['Vehicle Name'] = ((driverData.carName) ? driverData.carName : "");
                    finalOrderObject['Vehicle Make'] = ((driverData.carMakes) ? driverData.carMakes : "");
                    finalOrderObject['Vehicle Number'] = ((driverData.carNumber) ? driverData.carNumber : "");
                } else {
                    var vendorData = ((orderObj.vendor && orderObj.vendor != null) ? orderObj.vendor : '');
                    finalOrderObject['Vendor Name'] = ((vendorData.title) ? vendorData.title : "");
                    finalOrderObject['Category'] = ((vendorData.categoryTitle) ? vendorData.categoryTitle : "");
                    finalOrderObject['Driver Name'] = (driverData.firstName) ? ((driverData.lastName) ? driverData.firstName + ' ' + driverData.lastName : driverData.firstName) : "";
                    finalOrderObject['Driver Email'] = (driverData.email) ? driverData.email : "";
                    finalOrderObject['Driver Phone'] = ((driverData.phoneNumber) ? (driverData.phoneNumber.includes('+') ? driverData.phoneNumber.slice(1) : '(+) ' + driverData.phoneNumber) : '');

                }


                var userData = ((orderObj.author && orderObj.author != null) ? orderObj.author : '');
                var date = orderObj.createdAt.toDate();

                var distanceType = ((orderObj.distanceType && orderObj.distanceType != "" && orderObj.distanceType != null) ? orderObj.distanceType : "");

                finalOrderObject['User Name'] = ((userData.firstName) ? ((userData.lastName) ? userData.firstName + ' ' + userData.lastName : userData.firstName) : "");
                finalOrderObject['User Email'] = ((userData.email) ? userData.email : "");
                finalOrderObject['User Phone'] = ((userData.phoneNumber) ? (userData.phoneNumber.includes('+') ? userData.phoneNumber.slice(1) : '(+) ' + userData.phoneNumber) : '');

                finalOrderObject['Date'] = moment(date).format('ddd MMM DD YYYY h:mm:ss A');

                if (sectionName == 'Cab Service') {
                    finalOrderObject['Payment Method'] = orderObj.paymentMethod;

                } else {
                    finalOrderObject['Payment Method'] = orderObj.payment_method;

                }
                var total_amount = getProductsTotal(orderObj, sectionName);
                var adminCommission = getAdminCommission(orderObj, sectionName);

                if (symbolAtRight) {
                    total_amount = parseFloat(total_amount).toFixed(decimal_degits) + "" + currentCurrency;
                    adminCommission = parseFloat(adminCommission).toFixed(decimal_degits) + "" + currentCurrency;
                } else {
                    total_amount = currentCurrency + "" + parseFloat(total_amount).toFixed(decimal_degits);
                    adminCommission = currentCurrency + "" + parseFloat(adminCommission).toFixed(decimal_degits);
                }

                finalOrderObject['Total'] = (total_amount);
                finalOrderObject['Admin Commission'] = adminCommission;

                orderData.push(finalOrderObject);
            }));

            return orderData;
        }

        function getProductsTotal(snapshotsProducts, sectionName) {

            var total_price = 0;

            if (sectionName == 'Cab Service' || sectionName == 'Parcel Service' || sectionName == 'Rental Service') {
                if (sectionName == "Parcel Service") {
                    var discount = parseFloat(snapshotsProducts.discount);
                    var subTotal = snapshotsProducts.subTotal;

                    var total_price = subTotal;

                    var intRegex = /^\d+$/;
                    var floatRegex = /^((\d+(\.\d *)?)|((\d*\.)?\d+))$/;

                    if (intRegex.test(discount) || floatRegex.test(discount)) {

                        discount = parseFloat(discount);
                        total_price -= parseFloat(discount);

                    }

                    var total_tax_amount = 0;

                    if (snapshotsProducts.hasOwnProperty('taxSetting') && snapshotsProducts.taxSetting != '' && snapshotsProducts.taxSetting != null) {
                        for (var i = 0; i < snapshotsProducts.taxSetting.length; i++) {
                            var data = snapshotsProducts.taxSetting[i];

                            var tax = 0;

                            if (data.type && data.tax) {
                                if (data.type == "percentage") {

                                    tax = (data.tax * total_price) / 100;
                                } else {
                                    tax = data.tax;
                                }
                            }
                            total_tax_amount += parseFloat(tax);
                        }
                    }

                    total_price += parseFloat(total_tax_amount);

                } else if (sectionName == 'Cab Service') {
                    var total_price = parseFloat(snapshotsProducts.subTotal);
                    var discount = parseFloat(snapshotsProducts.discount);

                    total_price = total_price - discount;

                    try {
                        if (snapshotsProducts.tax) {
                            if (snapshotsProducts.taxType && snapshotsProducts.tax) {
                                if (snapshotsProducts.taxType == "percent") {
                                    tax = (snapshotsProducts.tax * total_price) / 100;
                                } else {
                                    tax = snapshotsProducts.tax;
                                }
                                tax = parseFloat(tax);
                                if (!isNaN(tax) && tax != 0) {
                                    total_price = total_price + parseFloat(tax);
                                }
                            }
                        }
                    } catch (error) {

                    }

                    var tip_amount = parseFloat(snapshotsProducts.tip_amount);
                    if (!isNaN(tip_amount) && tip_amount != 0) {
                        total_price = total_price + tip_amount;
                    }
                } else if (sectionName == 'Rental Service') {
                    var discount = parseFloat(snapshotsProducts.discount);
                    var discountType = snapshotsProducts.discountType;
                    var discountLabel = "";
                    var subTotal = snapshotsProducts.subTotal;
                    var driverRate = snapshotsProducts.driverRate;

                    var notes = snapshotsProducts.note;

                    if (driverRate == undefined) {
                        driverRate = 0;
                    }

                    if (subTotal == undefined) {
                        subTotal = 0;
                    }

                    var total_price = parseFloat(subTotal) + parseFloat(driverRate);

                    var intRegex = /^\d+$/;
                    var floatRegex = /^((\d+(\.\d *)?)|((\d*\.)?\d+))$/;

                    if (intRegex.test(discount) || floatRegex.test(discount)) {

                        discount = parseFloat(discount).toFixed(decimal_degits);
                        total_price -= parseFloat(discount);

                    }

                    var total_tax_amount = 0;

                    if (snapshotsProducts.hasOwnProperty('taxSetting') && snapshotsProducts.taxSetting != '' && snapshotsProducts.taxSetting != null) {

                        for (var i = 0; i < snapshotsProducts.taxSetting.length; i++) {
                            var data = snapshotsProducts.taxSetting[i];

                            var tax = 0;

                            if (data.type && data.tax) {
                                if (data.type == "percentage") {

                                    tax = (data.tax * total_price) / 100;
                                } else {
                                    tax = data.tax;
                                }
                            }
                            total_tax_amount += parseFloat(tax);
                        }
                    }

                    total_price += parseFloat(total_tax_amount);
                }
            } else {
                var discount = parseFloat(snapshotsProducts.discount);
                var couponCode = snapshotsProducts.couponCode;
                var extras = snapshotsProducts.extras;
                var extras_price = snapshotsProducts.extras_price;
                var rejectedByDrivers = snapshotsProducts.rejectedByDrivers;
                var takeAway = snapshotsProducts.takeAway;
                var tip_amount = snapshotsProducts.tip_amount;
                var status = snapshotsProducts.status;
                var products = snapshotsProducts.products;
                var deliveryCharge = snapshotsProducts.deliveryCharge;
                var totalProductPrice = 0;

                var specialDiscount = snapshotsProducts.specialDiscount;

                var intRegex = /^\d+$/;
                var floatRegex = /^((\d+(\.\d *)?)|((\d*\.)?\d+))$/;

                if (products) {

                    products.forEach((product) => {

                        var val = product;
                        if (val.price) {
                            price_item = parseFloat(val.price);

                            extras_price_item = 0;
                            if (val.extras_price && !isNaN(extras_price_item) && !isNaN(val.quantity)) {
                                extras_price_item = (parseFloat(val.extras_price) * parseInt(val.quantity));
                            }
                            if (!isNaN(price_item) && !isNaN(val.quantity)) {
                                totalProductPrice = parseFloat(price_item) * parseInt(val.quantity);
                            }
                            var extras_price = 0;
                            if (parseFloat(extras_price_item) != NaN && val.extras_price != undefined) {
                                extras_price = extras_price_item;
                            }
                            totalProductPrice = parseFloat(extras_price) + parseFloat(totalProductPrice);
                            totalProductPrice = parseFloat(totalProductPrice);
                            if (!isNaN(totalProductPrice)) {
                                total_price += parseFloat(totalProductPrice);
                            }


                        }

                    });
                }

                if (intRegex.test(discount) || floatRegex.test(discount)) {

                    discount = parseFloat(discount).toFixed(decimal_degits);
                    total_price -= parseFloat(discount);

                }
                var special_discount = 0;
                if (specialDiscount != undefined) {
                    special_discount = parseFloat(specialDiscount.special_discount);

                    total_price = total_price - special_discount;
                }
                tax = 0;
                if (snapshotsProducts.hasOwnProperty('taxSetting')) {
                    var total_tax_amount = 0;
                    for (var i = 0; i < snapshotsProducts.taxSetting.length; i++) {
                        var data = snapshotsProducts.taxSetting[i];

                        if (data.type && data.tax) {
                            if (data.type == "percentage") {
                                tax = (data.tax * total_price) / 100;
                            } else {
                                tax = data.tax;
                            }
                        }
                        total_tax_amount += parseFloat(tax);
                    }
                    total_price = parseFloat(total_price) + parseFloat(total_tax_amount);
                }


                if ((intRegex.test(deliveryCharge) || floatRegex.test(deliveryCharge)) && !isNaN(deliveryCharge)) {

                    deliveryCharge = parseFloat(deliveryCharge).toFixed(decimal_degits);
                    total_price += parseFloat(deliveryCharge);
                }

                if (intRegex.test(tip_amount) || floatRegex.test(tip_amount) && !isNaN(tip_amount)) {

                    tip_amount = parseFloat(tip_amount).toFixed(decimal_degits);
                    total_price += parseFloat(tip_amount);
                    total_price = parseFloat(total_price).toFixed(decimal_degits);
                }

            }

            return total_price;
        }

        function getAdminCommission(snapshotsProducts, sectionName) {

            var admin_commission = 0;

            if (sectionName == 'Cab Service' || sectionName == 'Parcel Service' || sectionName == 'Rental Service') {
                if (sectionName == "Parcel Service") {
                    var discount = parseFloat(snapshotsProducts.discount);
                    var subTotal = snapshotsProducts.subTotal;

                    var total_price = subTotal;

                    var intRegex = /^\d+$/;
                    var floatRegex = /^((\d+(\.\d *)?)|((\d*\.)?\d+))$/;

                    if (intRegex.test(discount) || floatRegex.test(discount)) {

                        discount = parseFloat(discount);
                        total_price -= parseFloat(discount);

                    }

                    var adminCommission = 0;

                    if (snapshotsProducts.adminCommission != undefined && snapshotsProducts.adminCommissionType != undefined) {

                        if (snapshotsProducts.adminCommissionType == "Percent") {
                            adminCommission = (total_price * parseFloat(snapshotsProducts.adminCommission)) / 100;
                        } else {
                            adminCommission = parseFloat(snapshotsProducts.adminCommission);
                        }
                    } else if (snapshotsProducts.adminCommission != undefined) {
                        adminCommission = parseFloat(snapshotsProducts.adminCommission);
                    }

                    admin_commission = parseFloat(adminCommission);

                } else if (sectionName == 'Cab Service') {
                    var total_price = parseFloat(snapshotsProducts.subTotal);
                    var discount = parseFloat(snapshotsProducts.discount);

                    total_price = total_price - discount;

                    var adminCommission = 0;

                    if (snapshotsProducts.adminCommission != undefined && snapshotsProducts.adminCommissionType != undefined) {

                        if (snapshotsProducts.adminCommissionType == "Percent") {
                            adminCommission = (total_price * parseFloat(snapshotsProducts.adminCommission)) / 100;
                        } else {
                            adminCommission = parseFloat(snapshotsProducts.adminCommission);
                        }
                    } else if (snapshotsProducts.adminCommission != undefined) {
                        adminCommission = parseFloat(snapshotsProducts.adminCommission);
                    }

                    admin_commission = parseFloat(adminCommission);

                } else if (sectionName == 'Rental Service') {
                    var discount = parseFloat(snapshotsProducts.discount);
                    var discountType = snapshotsProducts.discountType;
                    var discountLabel = "";
                    var subTotal = snapshotsProducts.subTotal;
                    var driverRate = snapshotsProducts.driverRate;

                    var notes = snapshotsProducts.note;

                    if (driverRate == undefined) {
                        driverRate = 0;
                    }

                    if (subTotal == undefined) {
                        subTotal = 0;
                    }

                    var total_price = parseFloat(subTotal) + parseFloat(driverRate);

                    var intRegex = /^\d+$/;
                    var floatRegex = /^((\d+(\.\d *)?)|((\d*\.)?\d+))$/;

                    if (intRegex.test(discount) || floatRegex.test(discount)) {

                        discount = parseFloat(discount).toFixed(decimal_degits);
                        total_price -= parseFloat(discount);

                    }

                    var adminCommission = 0;

                    if (snapshotsProducts.adminCommission != undefined && snapshotsProducts.adminCommissionType != undefined) {

                        if (snapshotsProducts.adminCommissionType == "Percent") {
                            adminCommission = (total_price * parseFloat(snapshotsProducts.adminCommission)) / 100;
                        } else {
                            adminCommission = parseFloat(snapshotsProducts.adminCommission);
                        }
                    } else if (snapshotsProducts.adminCommission != undefined) {
                        adminCommission = parseFloat(snapshotsProducts.adminCommission);
                    }

                    admin_commission = parseFloat(adminCommission);
                }
            } else {
                var discount = parseFloat(snapshotsProducts.discount);
                var couponCode = snapshotsProducts.couponCode;
                var extras = snapshotsProducts.extras;
                var extras_price = snapshotsProducts.extras_price;
                var rejectedByDrivers = snapshotsProducts.rejectedByDrivers;
                var takeAway = snapshotsProducts.takeAway;
                var tip_amount = snapshotsProducts.tip_amount;
                var status = snapshotsProducts.status;
                var products = snapshotsProducts.products;
                var deliveryCharge = snapshotsProducts.deliveryCharge;
                var totalProductPrice = 0;

                var specialDiscount = snapshotsProducts.specialDiscount;

                var intRegex = /^\d+$/;
                var floatRegex = /^((\d+(\.\d *)?)|((\d*\.)?\d+))$/;

                var total_price = 0;

                if (products) {

                    products.forEach((product) => {

                        var val = product;
                        if (val.price) {
                            price_item = parseFloat(val.price);

                            extras_price_item = 0;
                            if (val.extras_price && !isNaN(extras_price_item) && !isNaN(val.quantity)) {
                                extras_price_item = (parseFloat(val.extras_price) * parseInt(val.quantity));
                            }
                            if (!isNaN(price_item) && !isNaN(val.quantity)) {
                                totalProductPrice = parseFloat(price_item) * parseInt(val.quantity);
                            }
                            var extras_price = 0;
                            if (parseFloat(extras_price_item) != NaN && val.extras_price != undefined) {
                                extras_price = extras_price_item;
                            }
                            totalProductPrice = parseFloat(extras_price) + parseFloat(totalProductPrice);
                            totalProductPrice = parseFloat(totalProductPrice);
                            if (!isNaN(totalProductPrice)) {
                                total_price += parseFloat(totalProductPrice);
                            }


                        }

                    });
                }

                if (intRegex.test(discount) || floatRegex.test(discount)) {

                    discount = parseFloat(discount).toFixed(decimal_degits);
                    total_price -= parseFloat(discount);

                }
                var special_discount = 0;
                if (specialDiscount != undefined) {
                    special_discount = parseFloat(specialDiscount.special_discount);

                    total_price -= parseFloat(special_discount);
                }

                var adminCommission = 0;

                if (snapshotsProducts.adminCommission != undefined && snapshotsProducts.adminCommissionType != undefined) {

                    if (snapshotsProducts.adminCommissionType == "Percent") {
                        adminCommission = (total_price * parseFloat(snapshotsProducts.adminCommission)) / 100;
                    } else {
                        adminCommission = parseFloat(snapshotsProducts.adminCommission);
                    }

                } else if (snapshotsProducts.adminCommission != undefined) {
                    adminCommission = parseFloat(snapshotsProducts.adminCommission);
                }

                admin_commission = parseFloat(adminCommission);
            }

            return admin_commission;
        }

        $(document).on('click', '.download-sales-report', function () {

            var section = $(".section :selected").val();
            var serviceType = $(".section :selected").attr('serviceType');
            var sectionName = $(".section :selected").text();
            var vendors = $(".vendors :selected").val();
            var driver = $(".driver :selected").val();
            var customer = $(".customer :selected").val();
            var category = $(".category :selected").val();
            var payment_method = $(".payment_method :selected").val();
            var fileFormat = $(".file_format :selected").val();
            let start_date = moment($('#reportrange').data('daterangepicker').startDate).toDate();
            let end_date = moment($('#reportrange').data('daterangepicker').endDate).toDate();

            var headers = [];

            $(".error_top").html("");

            if (section == "") {
                $(".error_top").show();
                $(".error_top").show();
                $(".error_top").html("");
                $(".error_top").append("<p>{{trans('lang.select_section')}}</p>");
                window.scrollTo(0, 0);
            } else if (fileFormat == '') {
                $(".error_top").show();
                $(".error_top").html("");
                $(".error_top").append("<p>{{trans('lang.file_format_error')}}</p>");
                window.scrollTo(0, 0);
            } else {
                jQuery("#data-table_processing").show();

                var ordersRef = "";
                var headerArray = [];


                if (sectionName == 'Cab Service') {
                    ordersRef = database.collection('rides').where('status', 'in', ["Order Completed"]).orderBy('createdAt', 'desc');
                    headerArray = ['Order ID', 'From', 'To', 'Driver Name', 'Driver Email', 'Driver Phone', 'Vehicle Name', 'Vehicle Make', 'Vehicle Number', 'User Name', 'User Email', 'User Phone', 'Date', 'Payment Method', 'Total', 'Admin Commission'];
                    if (driver == "") {
                        ordersRef = ordersRef.where('driver.serviceType', '==', serviceType)
                    }


                } else if (sectionName == 'Parcel Service') {
                    ordersRef = database.collection('parcel_orders').where('status', 'in', ["Order Completed"]).orderBy('createdAt', 'desc');
                    headerArray = ['Order ID', 'From', 'To', 'Driver Name', 'Driver Email', 'Driver Phone', 'Vehicle Name', 'Vehicle Make', 'Vehicle Number', 'User Name', 'User Email', 'User Phone', 'Date', 'Payment Method', 'Total', 'Admin Commission'];

                    if (driver == "") {
                        ordersRef = ordersRef.where('driver.serviceType', '==', serviceType)
                    }


                } else if (sectionName == 'Rental Service') {
                    ordersRef = database.collection('rental_orders').where('status', 'in', ["Order Completed"]).orderBy('createdAt', 'desc');
                    headerArray = ['Order ID', 'From', 'To', 'Driver Name', 'Driver Email', 'Driver Phone', 'Vehicle Name', 'Vehicle Make', 'Vehicle Number', 'User Name', 'User Email', 'User Phone', 'Date', 'Payment Method', 'Total', 'Admin Commission'];

                    if (driver == "") {
                        ordersRef = ordersRef.where('driver.serviceType', '==', serviceType)
                    }

                } else {

                    headerArray = ['Order ID', 'Vendor Name', 'Category', 'Driver Name', 'Driver Email', 'Driver Phone', 'User Name', 'User Email', 'User Phone', 'Date', 'Payment Method', 'Total', 'Admin Commission'];

                    ordersRef = database.collection('vendor_orders').where('status', 'in', ["Order Completed"]).where('section_id', '==', section).orderBy('createdAt', 'desc');

                    if (vendors != "") {
                        ordersRef = ordersRef.where('vendorID', '==', vendors)
                    }

                    if (category != "") {
                        ordersRef = ordersRef.where('vendor.categoryID', '==', category)
                    }
                }

                if (driver != "") {
                    ordersRef = ordersRef.where('driverID', '==', driver)
                }


                if (customer != "") {
                    ordersRef = ordersRef.where('authorID', '==', customer)
                }

                if (start_date != "") {
                    ordersRef = ordersRef.where('createdAt', '>=', start_date)
                }

                if (end_date != "") {
                    ordersRef = ordersRef.where('createdAt', '<=', end_date)
                }

                if (fileFormat == 'xls' || fileFormat == 'csv') {
                    headers = headerArray;
                    var script = document.createElement("script");
                    script.setAttribute("src", "https://unpkg.com/object-exporter@3.2.1/dist/objectexporter.min.js");

                    var head = document.head;
                    head.insertBefore(script, head.firstChild);
                } else {
                    for (var k = 0; k < headerArray.length; k++) {
                        headers.push({
                            alias: headerArray[k],
                            name: headerArray[k],
                            flex: 1,
                        });
                    }

                    var script = document.createElement("script");
                    script.setAttribute("src", "{{ asset('js/objectexporter.min.js') }}");
                    script.setAttribute("async", "false");
                    var head = document.head;
                    head.insertBefore(script, head.firstChild);

                }

                ordersRef.get().then(async function (orderSnapshots) {

                    if (orderSnapshots.docs.length > 0) {
                        var reportData = await getReportData(orderSnapshots, sectionName);

                        generateReport(reportData, headers, fileFormat);

                        jQuery("#data-table_processing").hide();
                        setDate();
                        $('.file_format').val('').trigger('change');
                        $('.section').val('').trigger('change');
                        $('.driver').val('').trigger('change');
                        $('.customer').val('').trigger('change');
                        $('.service').val('').trigger('change');
                        $('.status').val('').trigger('change');
                        $('.payment_method').val('').trigger('change');
                        $('.payment_status').val('').trigger('change');

                    } else {
                        jQuery("#data-table_processing").hide();
                        setDate();
                        $(".error_top").show();
                        $(".error_top").html("");
                        $(".error_top").append("<p>{{trans('lang.not_found_data_error')}}</p>");
                        window.scrollTo(0, 0);

                    }

                }).catch((error) => {

                    jQuery("#data-table_processing").hide();

                    console.log("Error getting documents: ", error);
                    $(".error_top").show();
                    $(".error_top").html(error);
                    window.scrollTo(0, 0);
                });
            }
        });
    </script>
@endsection