@extends('layouts.app')

@section('content')

<div class="page-wrapper">

    <div class="row page-titles">

        <div class="col-md-5 align-self-center">

            <h3 class="text-themecolor">{{trans('lang.coupon_plural')}} <span class="storeTitle"></span></h3>

        </div>

        <div class="col-md-7 align-self-center">

            <ol class="breadcrumb">

                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('lang.dashboard')}}</a></li>

                <li class="breadcrumb-item active">{{trans('lang.coupon_table')}}</li>

            </ol>

        </div>

        <div>

        </div>

    </div>


    <div class="container-fluid">
        <div id="data-table_processing" class="dataTables_processing panel panel-default"
             style="display: none;">{{trans('lang.processing')}}
        </div>
        <div class="row">

            <div class="col-12">

                <?php if ($id != '') { ?>
                    <div class="menu-tab">
                        <ul>
                            <li>
                                <a href="{{route('vendors.view',$id)}}">{{trans('lang.tab_basic')}}</a>
                            </li>
                            <li>
                                <a href="{{route('vendors.items',$id)}}">{{trans('lang.tab_items')}}</a>
                            </li>
                            <li>
                                <a href="{{route('vendors.orders',$id)}}">{{trans('lang.tab_orders')}}</a>
                            </li>
                            <li>
                                <a href="{{route('vendors.reviews',$id)}}">{{trans('lang.tab_reviews')}}</a>
                            </li>
                            <li class="active">
                                <a href="{{route('vendors.coupons',$id)}}">{{trans('lang.tab_promos')}}</a>
                            <li>
                                <a href="{{route('vendors.payout',$id)}}">{{trans('lang.tab_payouts')}}</a>
                            </li>
                            <li class="dine_in_future" style="display:none;">
                                <a href="{{route('vendors.booktable',$id)}}">{{trans('lang.dine_in_future')}}</a>
                            </li>
                        </ul>
                    </div>
                <?php } ?>

                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs align-items-end card-header-tabs w-100">
                            <li class="nav-item">
                                <a class="nav-link active" href="{!! url()->current() !!}"><i
                                            class="fa fa-list mr-2"></i>{{trans('lang.coupon_table')}}</a>
                            </li>
                            <?php if ($id != '') { ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="{!! route('coupons.create') !!}/{{$id}}"><i
                                                class="fa fa-plus mr-2"></i>{{trans('lang.coupon_create')}}</a>
                                </li>
                            <?php } else { ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="{!! route('coupons.create') !!}"><i
                                                class="fa fa-plus mr-2"></i>{{trans('lang.coupon_create')}}</a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div id="users-table_filter" class="pull-right">
                            <div class="row">
                                <div class="col-md-9">
                                </div>
                                <!--  <div id="data-table_processing" class="dataTables_processing panel panel-default"
                                       style="display: none;">{{trans('lang.processing')}}
                                  </div>

                                  <div id="users-table_filter" class="pull-right">

                                      <div class="row">

                                          <div class="col-sm-9">
                                              <label>{{ trans('lang.search_by')}}

                                                  <select name="selected_search" id="selected_search"
                                                          class="form-control input-sm">
                                                      <option value="code">{{trans('lang.coupon_code')}}</option>
                                                      <option value="description">{{trans('lang.coupon_description')}}</option>
                                                  </select>

                                                  <div class="form-group">
                                                      <input type="search" id="search" class="search form-control"
                                                             placeholder="Search" aria-controls="users-table">
                                              </label>&nbsp;<button onclick="searchtext();" class="btn btn-warning btn-flat">{{
                                                  trans('lang.search')}}
                                              </button>&nbsp;<button onclick="searchclear();" class="btn btn-warning btn-flat">{{
                                                  trans('lang.clear')}}
                                              </button>
                                          </div>
                                      </div>-->
                                <div class="col-md-3">
                                    <select id="section_id" class="form-control allModules" style="width:100%"
                                            onchange="clickLink(this.value)">
                                        <option value="">{{trans('lang.select')}} {{trans('lang.section_plural')}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive m-t-10">

                            <table id="couponTable"
                                   class="display nowrap table table-hover table-striped table-bordered table table-striped"
                                   cellspacing="0" width="100%">

                                <thead>

                                <tr>
                                    <th class="delete-all"><input type="checkbox" id="is_active"><label
                                                class="col-3 control-label" for="is_active"
                                        ><a id="deleteAll" class="do_not_delete"
                                            href="javascript:void(0)"><i
                                                        class="fa fa-trash"></i> {{trans('lang.all')}}</a></label></th>

                                    <th>{{trans('lang.coupon_code')}}</th>

                                    <th>{{trans('lang.coupon_discount')}}</th>
                                    <th>{{trans('lang.vendor')}}</th>

                                    <th>{{trans('lang.section')}}</th>
                                    <th>{{trans('lang.coupon_privacy')}}</th>
                                    <th>{{trans('lang.coupon_expires_at')}}</th>

                                    <th>{{trans('lang.coupon_enabled')}}</th>

                                    <th>{{trans('lang.actions')}}</th>

                                </tr>

                                </thead>

                                <tbody id="append_list1">

                                </tbody>

                            </table>

                            <!--  <nav aria-label="Page navigation example">
                                  <ul class="pagination justify-content-center">
                                      <li class="page-item ">
                                          <a class="page-link" href="javascript:void(0);" id="users_table_previous_btn"
                                             onclick="prev()" data-dt-idx="0" tabindex="0">{{trans('lang.previous')}}</a>
                                      </li>
                                      <li class="page-item">
                                          <a class="page-link" href="javascript:void(0);" id="users_table_next_btn"
                                             onclick="next()" data-dt-idx="2" tabindex="0">{{trans('lang.next')}}</a>
                                      </li>
                                  </ul>
                              </nav>-->
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

</div>
</div>


@endsection

@section('scripts')

<script type="text/javascript">

    var database = firebase.firestore();
    var offest = 1;
    var pagesize = 10;
    var end = null;
    var endarray = [];
    var start = null;
    var user_number = [];

    $('.sectionDiv').hide();

    <?php if($id != ''){ ?>
    getStoreNameFunction('<?php echo $id; ?>');
    var ref = database.collection('coupons').where('vendorID', '==', '<?php echo $id; ?>');
    <?php }else{ ?>
    $('.sectionDiv').show();
    var section_id = getCookie('section_id');
    if (section_id != '') {
        var ref = database.collection('coupons').where('section_id', '==', section_id);
    } else {
        var ref = database.collection('coupons');
    }
    <?php } ?>

    var ref_sections = database.collection('sections');

    var currentCurrency = '';
    var currencyAtRight = false;
    var decimal_degits = 0;

    var refCurrency = database.collection('currencies').where('isActive', '==', true);
    refCurrency.get().then(async function (snapshots) {
        var currencyData = snapshots.docs[0].data();
        currentCurrency = currencyData.symbol;
        currencyAtRight = currencyData.symbolAtRight;

        if (currencyData.decimal_degits) {
            decimal_degits = currencyData.decimal_degits;
        }

    });

    var append_list = '';

    $(document).ready(function () {

        $(document.body).on('click', '.redirecttopage', function () {
            var url = $(this).attr('data-url');
            window.location.href = url;
        });

        var inx = parseInt(offest) * parseInt(pagesize);
        jQuery("#data-table_processing").show();

        append_list = document.getElementById('append_list1');
        append_list.innerHTML = '';
        ref.get().then(async function (snapshots) {
            html = '';


            html = await buildHTML(snapshots);
            jQuery("#data-table_processing").hide();
            if (html != '') {
                append_list.innerHTML = html;
                start = snapshots.docs[snapshots.docs.length - 1];
                endarray.push(snapshots.docs[0]);
                if (snapshots.docs.length < pagesize) {
                    jQuery("#data-table_paginate").hide();
                }
            }

            $('#couponTable').DataTable({

                order: [],
                columnDefs: [{
                    targets: 5,
                    type: 'date',
                    render: function (data) {
                        return data;
                    }
                },
                    {orderable: false, targets: [0, 4, 5, 6, 7, 8]},
                ],
                order: [1, "asc"],
                "language": {
                    "zeroRecords": "{{trans("lang.no_record_found")}}",
                    "emptyTable": "{{trans("lang.no_record_found")}}"
                },
                responsive: true,
            });

        });


        ref_sections.get().then(async function (snapshots) {

            snapshots.docs.forEach((listval) => {
                var data = listval.data();

                $('#section_id').append($("<option value=''>{{trans('lang.select')}} {{trans('lang.section_plural')}}</option>")
                    .attr("value", data.id)
                    .text(data.name));
            })

            $('#section_id').val(section_id);
        })

    });

    function clickLink(value) {
        setCookie('section_id', value, 30);
        location.reload();
    }

    function getStoreNameFunction(vendorId) {
        var vendorName = '';
        database.collection('vendors').where('id', '==', vendorId).get().then(function (snapshots) {
            var vendorData = snapshots.docs[0].data();
            vendorName = vendorData.title;
            $(".storeTitle").text(' - ' + vendorName);
            if (vendorData.dine_in_active == true) {
                $(".dine_in_future").show();
            }
        });
        return vendorName;
    }

    async function buildHTML(snapshots) {
        var html = '';
        await Promise.all(snapshots.docs.map(async (listval) => {
            var val = listval.data();
            var getData = await getListData(val);

            html += getData;
        }));
        return html;
    }

    // datas.id = listval.id;
    // alldata.push(datas);
    // });
    async function getListData(val) {


        var html = '';
        var count = 0;
        //alldata.forEach((listval) => {

        //var val = listval;

        html = html + '<tr>';
        newdate = '';
        if (currencyAtRight) {
            if (val.discountType == 'Percent' || val.discountType == 'Percentage') {
                discount_price = val.discount + "%";
            } else {
                discount_price = parseFloat(val.discount).toFixed(decimal_degits) + "" + currentCurrency;
            }
        } else {
            if (val.discountType == 'Percent' || val.discountType == 'Percentage') {
                discount_price = val.discount + "%";
            } else {
                discount_price = currentCurrency + "" + parseFloat(val.discount).toFixed(decimal_degits);
            }
        }
        var id = val.id;
        var route1 = '{{route("coupons.edit",":id")}}';
        route1 = route1.replace(':id', id);
        <?php if($id != ''){ ?>
        route1 = route1 + '?eid={{$id}}';
        <?php }?>
        // console.log('val'+JSON.stringify(val));

        html = html + '<td class="delete-all"><input type="checkbox" id="is_open_' + id + '" class="is_open" dataId="' + id + '"><label class="col-3 control-label"\n' +
            'for="is_open_' + id + '" ></label></td>';

        html = html + '<td  data-url="' + route1 + '" class="redirecttopage">' + val.code + '</td>';
        html = html + '<td>' + discount_price + '</td>';
        if (val.hasOwnProperty("vendorID")) {
            var store = await getStoreName(val.vendorID);
            html = html + '<td>' + store + '</td>';
        } else {
            html = html + '<td></td>';
        }
        if (val.hasOwnProperty("section_id")) {
            var section = await getSectionName(val.section_id);
            html = html + '<td>' + section + '</td>';
        } else {
            html = html + '<td></td>';
        }
        if (val.hasOwnProperty('isPublic') && val.isPublic) {
            html = html + '<td class="success"><span class="badge badge-success py-2 px-3">{{trans("lang.public")}}</sapn></td>';
        } else {
            html = html + '<td class="danger"><span class="badge badge-danger py-2 px-3">{{trans("lang.private")}}</sapn></td>';
        }
        var date = '';
        var time = '';
        if (val.hasOwnProperty("expiresAt")) {
            try {
                date = val.expiresAt.toDate().toDateString();
                time = val.expiresAt.toDate().toLocaleTimeString('en-US');
            } catch (err) {

            }
            html = html + '<td class="dt-time">' + date + ' ' + time + '</td>';
        } else {
            html = html + '<td></td>';
        }
        if (val.isEnabled) {
            html = html + '<td><label class="switch"><input type="checkbox" checked id="' + val.id + '" name="isEnabled"><span class="slider round"></span></label></td>';
        } else {
            html = html + '<td><label class="switch"><input type="checkbox" id="' + val.id + '" name="isEnabled"><span class="slider round"></span></label></td>';
        }

        html = html + '<td class="action-btn"><a href="' + route1 + '"><i class="fa fa-edit"></i></a><a id="' + val.id + '" name="coupon_delete_btn" class="do_not_delete" href="javascript:void(0)"><i class="fa fa-trash"></i></a></td>';

        html = html + '</tr>';
        count = count + 1;
        //});
        return html;
    }

    async function getSectionName(sectionId) {

        var sectionName = '';
        if (sectionId != '') {
            await database.collection('sections').where("id", "==", sectionId).get().then(async function (snapshots) {

                if (snapshots.docs.length) {
                    var data = snapshots.docs[0].data();
                    sectionName = data.name;
                }
            });
        }

        return sectionName;
    }


    $(document).on("click", "input[name='isEnabled']", function (e) {
        var ischeck = $(this).is(':checked');
        var id = this.id;
        if (ischeck) {
            database.collection('coupons').doc(id).update({'isEnabled': true}).then(function (result) {

            });
        } else {
            database.collection('coupons').doc(id).update({'isEnabled': false}).then(function (result) {

            });
        }
    });

    async function getStoreName(vendorId) {
        var vendorName = '';

        if (vendorId != '' && vendorId != null) {
            await database.collection('vendors').where("id", "==", vendorId).get().then(async function (snapshots) {
                if (snapshots.docs.length) {
                    var data = snapshots.docs[0].data();

                    vendorName = data.title;
                }
            });
        }

        return vendorName;
    }

    $("#is_active").click(function () {
        $("#couponTable .is_open").prop('checked', $(this).prop('checked'));
    });

    $("#deleteAll").click(function () {
        if ($('#couponTable .is_open:checked').length) {
            if (confirm("{{trans('lang.selected_delete_alert')}}")) {
                jQuery("#data-table_processing").show();
                $('#couponTable .is_open:checked').each(function () {
                    var dataId = $(this).attr('dataId');
                    database.collection('coupons').doc(dataId).delete().then(function () {
                        window.location.reload();
                    });

                });
            }
        } else {
            alert("{{trans('lang.select_delete_alert')}}");
        }
    });

    $(document).on("click", "a[name='coupon_delete_btn']", function (e) {
        var id = this.id;
        jQuery("#data-table_processing").show();
        database.collection('coupons').doc(id).delete().then(function () {
            window.location = "{{! url()->current() }}";
        });


    });

</script>

@endsection
