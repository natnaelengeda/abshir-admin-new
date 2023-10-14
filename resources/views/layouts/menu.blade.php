<nav class="sidebar-nav">

    <ul id="sidebarnav">

        <li>
            <a class="waves-effect waves-dark" href="{!! url('dashboard') !!}" aria-expanded="false">
                <i class="mdi mdi-home"></i>
                <span class="hide-menu">{{trans('lang.dashboard')}}</span>
            </a>
        </li>

        {{-- <li><a class="waves-effect waves-dark" href="{!! url('section') !!}" aria-expanded="false">
                <i class="mdi mdi-clipboard-text"></i>
                <span class="hide-menu">{{trans('lang.section_plural')}}</span>
            </a>
        </li> --}}

        <li>
            <a class="waves-effect waves-dark" href="{!! url('users') !!}" aria-expanded="false">
                <i class="mdi mdi-account-multiple"></i>
                <span class="hide-menu">{{trans('lang.user_customer')}}</span>
            </a>
        </li>

        {{-- <li>
            <a class="waves-effect waves-dark" href="{!! url('owners') !!}" aria-expanded="false">

                <i class="mdi mdi-account-multiple"></i>

                <span class="hide-menu">{{trans('lang.owner_vendor')}}</span>

            </a>
        </li> --}}

        <li class="nav-subtitle">
            <span class="nav-subtitle-span">Ride Service</span>
        </li>

        {{-- <li><a class="waves-effect waves-dark" href="{!! url('vendors') !!}" aria-expanded="false">
                <i class="mdi mdi-shopping"></i>
                <span class="hide-menu">{{trans('lang.vendor_plural')}}</span>
            </a>
        </li> --}}

        <li><a class="waves-effect waves-dark" href="{!! url('drivers') !!}" aria-expanded="false">
                <i class="mdi mdi-car"></i>
                <span class="hide-menu">{{trans('lang.driver_plural')}}</span>
            </a>
        </li>

        {{-- <li><a class="waves-effect waves-dark" href="{!! url('categories') !!}" aria-expanded="false">
                <i class="mdi mdi-clipboard-text"></i>
                <span class="hide-menu">{{trans('lang.category_plural')}}</span>
            </a>
        </li> --}}
        {{-- <li><a class="waves-effect waves-dark" href="{!! url('brands') !!}" aria-expanded="false">
                <i class="mdi mdi-domain"></i>
                <span class="hide-menu">{{trans('lang.brand')}}</span>
            </a>
        </li> --}}

        <li><a class="waves-effect waves-dark" href="{!! url('destinations') !!}" aria-expanded="false">
                <i class="mdi mdi-account-location"></i>
                <span class="hide-menu">{{trans('lang.destination')}}</span>
            </a>
        </li>

        <li><a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                <i class="mdi mdi-plus-box"></i>
                <span class="hide-menu">{{trans('lang.attribute_plural')}}</span>
            </a>

            <ul aria-expanded="false" class="collapse">
                <li><a href="{!! url('attributes') !!}">{{trans('lang.item_attribute_plural')}}</a></li>
                <li><a href="{!! url('reviewattributes') !!}">{{trans('lang.review_attribute_plural')}}</a></li>
            </ul>

        </li>
        <li><a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">

                <i class="mdi mdi-calendar-check"></i>

                <span class="hide-menu">{{trans('lang.report_plural')}}</span>

            </a>

            <ul aria-expanded="false" class="collapse">

                <li><a href="{!! url('/report/sales') !!}">{{trans('lang.reports_sale')}}</a></li>

            </ul>

        </li>
        {{-- <li><a class="waves-effect waves-dark" href="{!! url('items') !!}" aria-expanded="false">
                <i class="mdi mdi-cart"></i>
                <span class="hide-menu">{{trans('lang.item_plural')}}</span>
            </a>
        </li> --}}

        {{-- <li>
            <a class="waves-effect waves-dark" href="{!! url('map/multivendor') !!}" aria-expanded="false">
                <i class="mdi mdi-home-map-marker"></i>
                <span class="hide-menu">{{trans('lang.god_eye')}}</span>
            </a>
        </li> --}}

        {{-- <li><a class="waves-effect waves-dark" href="{!! url('orders') !!}" aria-expanded="false">
                <i class="mdi mdi-library-books"></i>
                <span class="hide-menu">{{trans('lang.order_plural')}}</span>
            </a>
        </li> --}}

        {{-- <li><a class="waves-effect waves-dark" href="{!! url('coupons') !!}" aria-expanded="false">
                <i class="mdi mdi-sale"></i>
                <span class="hide-menu">{{trans('lang.coupon_plural')}}</span>
            </a>
        </li> --}}

        {{-- <li><a class="waves-effect waves-dark" href="{!! url('banners') !!}" aria-expanded="false">
                <i class="mdi mdi-monitor-multiple "></i>
                <span class="hide-menu">{{trans('lang.menu_items')}}</span>
            </a>
        </li> --}}

        <li class="nav-subtitle">
            <span class="nav-subtitle-span">Ride</span>
        </li>

        {{-- <li><a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                <i class="mdi mdi-package"></i>
                <span class="hide-menu">{{trans('lang.parcel_plural')}}</span>
            </a>

            <ul aria-expanded="false" class="collapse">
                <li><a href="{!! url('map/parcel') !!}">{{ trans('lang.god_eye') }} </a></li>
                <li><a href="{!! url('parcelCategory') !!}">{{ trans('lang.parcel_category') }} </a></li>
                <li><a href="{!! url('parcel_weight') !!}">{{ trans('lang.parcel_weight') }} </a></li>
                <li><a href="{!! url('parcel_coupons') !!}">{{ trans('lang.parcel_coupons') }}</a></li>
                <li><a href="{!! url('parcel_orders') !!}">{{trans('lang.parcel_orders')}}</a></li>
            </ul>

        </li> --}}

        <li><a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                <i class="mdi mdi-car"></i>
                <span class="hide-menu">{{trans('lang.cab_service')}}</span>
            </a>

            <ul aria-expanded="false" class="collapse">

                <li><a href="{!! url('map/cab') !!}">{{ trans('lang.god_eye') }} </a></li>
                <li><a href="{!! url('rides') !!}">{{ trans('lang.rides') }} </a></li>
                <li><a href="{!! url('sos') !!}">{{ trans('lang.sos_ride') }} </a></li>
                <li><a class="waves-effect waves-dark" href="{!! url('settings/promos') !!}" aria-expanded="false">
                        <span class="hide-menu">{{trans('lang.promo_pural')}}</span>
                    </a>
                </li>
                <li><a class="waves-effect waves-dark" href="{!! url('complaints') !!}" aria-expanded="false">
                        <span class="hide-menu">{{trans('lang.complaints')}}</span>
                    </a>
                </li>
                <li><a class="waves-effect waves-dark" href="{!! url('vehicleType') !!}" aria-expanded="false">
                        {{trans('lang.cab')}} {{trans('lang.vehicle_type')}}
                    </a>
                </li>
            </ul>
        </li>

{{-- 
        <li><a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                <i class="mdi mdi-package"></i>
                <span class="hide-menu">{{trans('lang.rental_plural')}}</span>
            </a>

            <ul aria-expanded="false" class="collapse">
                <li><a href="{!! url('map/rental') !!}">{{ trans('lang.god_eye') }} </a></li>
                <li><a class="waves-effect waves-dark" href="{!! url('rentalvehicleType') !!}" aria-expanded="false">{{trans('lang.rental_vehicle_type')}}</a></li>
                <li><a class="waves-effect waves-dark" href="{!! url('rentaldiscount') !!}" aria-expanded="false">{{trans('lang.rental_discount')}}</a></li>
                <li><a href="{!! url('rental_orders') !!}">{{trans('lang.rental_orders')}} </a></li>
                <li><a class="waves-effect waves-dark" href="{!! url('rentalvehicle') !!}" aria-expanded="false">{{trans('lang.rental_vehicle')}}</a></li>
            </ul>
        </li> --}}

        <li><a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                <i class="fa fa-taxi"></i>
                <span class="hide-menu">{{trans('lang.vehicle_manage')}}</span>
            </a>

            <ul aria-expanded="false" class="collapse">
                <li><a class="waves-effect waves-dark" href="{!! url('carMake') !!}" aria-expanded="false">{{trans('lang.make')}}</a></li>
                <li><a class="waves-effect waves-dark" href="{!! url('carModel') !!}" aria-expanded="false">{{trans('lang.model')}}</a></li>
            </ul>
        </li>

        <li class="nav-subtitle"><span class="nav-subtitle-span">{{trans('lang.other_settings')}}</span></li>

        <li><a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                <i class="mdi mdi-comment-alert"></i>
                <span class="hide-menu">{{trans('lang.notifications')}}</span>
            </a>

            <ul aria-expanded="false" class="collapse">

                <li>
                    <a href="{!! url('notification') !!}">{{ trans('lang.send_notification') }}</a>
                </li>

                <li><a href="{!! url('dynamic-notification') !!}">{{trans('lang.dynamic_notification')}}</a></li>

            </ul>

        </li>

        <li><a class="waves-effect waves-dark" href="{!! url('email-templates') !!}" aria-expanded="false">
                <i class="mdi mdi-email"></i>
                <span class="hide-menu">{{trans('lang.email_templates')}}</span>
            </a>
        </li>

        <li><a class="waves-effect waves-dark" href="{!! url('cms') !!}" aria-expanded="false">
                <i class="mdi mdi-book-open-page-variant"></i>
                <span class="hide-menu">{{trans('lang.cms_plural')}}</span>
            </a>
        </li>

        <li><a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                <i class="mdi mdi-bank"></i>
                <span class="hide-menu">{{trans('lang.payment_plural')}}</span>
            </a>

            <ul aria-expanded="false" class="collapse">

                <li>
                    <a href="{!! url('payments') !!}">{{ trans('lang.vendor_plural') }} {{trans('lang.payment_plural')}}</a>
                </li>

                <li><a href="{!! url('vendorsPayouts') !!}">{{trans('lang.vendors_payout_plural')}}</a></li>

                <li>
                    <a href="{!! url('driverpayments') !!}">{{trans('lang.driver_plural')}}{{trans('lang.payment_plural')}}</a>
                </li>

                <li><a href="{!! url('driversPayouts') !!}">{{trans('lang.drivers_payout')}}</a></li>

                <li><a href="{!! url('walletstransaction') !!}">{{trans('lang.wallet_transaction')}}</a></li>

                <li><a href="{!! url('payoutRequests/vendor') !!}">{{trans('lang.payout_request')}}</a></li>

                {{--<li><a href="{!! url('order_transactions') !!}">{{trans('lang.order_transactions')}}</a></li>--}}

            </ul>

        </li>


        <li><a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                <i class="mdi mdi-settings"></i>
                <span class="hide-menu">{{trans('lang.app_setting')}}</span>
            </a>

            <ul aria-expanded="false" class="collapse">

                <li><a href="{!! url('settings/app/globals') !!}">{{trans('lang.app_setting_globals')}}</a></li>

                <li><a href="{!! url('settings/currencies') !!}">{{trans('lang.currency_plural')}}</a></li>

                <li><a href="{!! url('settings/payment/stripe') !!}">{{trans('lang.app_setting_payment')}}</a></li>

                <li><a href="{!! url('settings/app/adminCommission') !!}">{{trans('lang.vendor_admin_commission')}}</a>
                </li>

                <li><a href="{!! url('settings/app/radiusConfiguration') !!}">{{trans('lang.radios_configuration')}}</a>
                </li>

                <li><a href="{!! url('tax') !!}">{{trans('lang.tax_setting')}}</a></li>
                <li><a href="{!! url('settings/app/deliveryCharge') !!}">{{trans('lang.delivery_charge')}}</a></li>

                <li><a href="{!! url('settings/app/languages') !!}">{{trans('lang.languages')}}</a></li>

                <li><a href="{!! url('settings/app/specialOffer') !!}">{{trans('lang.special_offer')}}</a></li>

                <li><a href="{!! url('termsAndConditions') !!}">{{trans('lang.terms_and_conditions')}}</a></li>

                <li><a href="{!! url('privacyPolicy') !!}">{{trans('lang.privacy_policy')}}</a></li>

                <li><a href="{!! url('homepageTemplate') !!}">{{trans('lang.homepageTemplate')}}</a></li>

                <li><a href="{!! url('footerTemplate') !!}">{{trans('lang.footer_template')}}</a></li>
            </ul>


        </li>
    </ul>

    {{-- <p class="web_version"></p> --}}
</nav>