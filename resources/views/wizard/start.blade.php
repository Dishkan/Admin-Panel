@extends('layouts.wizard', [
    'namePage'        => 'Dealer Wizard',
    'class'           => 'login-page sidebar-mini ',
    'activePage'      => 'wizard',
    'backgroundImage' => asset('now') . '/img/jet.jpg',
])

<?php
$activeStep = array_key_exists( 'activeStep', $_COOKIE ) ? $_COOKIE['activeStep'] : 'type';
?>

@section('content')

    <script>
        console.log( '<?= $activeStep ?>' )
    </script>

    <style>
        .content .card-body .tab-content .icon{
            display:flex;
            align-items:center;
            justify-content:center;
            margin:20px auto;
        }

        .card-wizard .choice.active{
            transform:scale(1.05);
        }

        .card-wizard .choice{
            transition:transform .3s;
        }

        .section-image .card .card-header .description{
            color:#fff;
        }

        .card-wizard .picture{
            border-radius:0;
        }

        #preloader{
            z-index:4;
            position:fixed;
            top:0;
            left:0;
            width:100%;
            height:100%;
        }

        #loader{
            display:block;
            position:relative;
            left:50%;
            top:50%;
            width:150px;
            height:150px;
            margin:-75px 0 0 -75px;
            border-radius:50%;
            border:3px solid transparent;
            border-top-color:#9370DB;
            -webkit-animation:spin 2s linear infinite;
            animation:spin 2s linear infinite;
        }

        #loader:before{
            content:"";
            position:absolute;
            top:5px;
            left:5px;
            right:5px;
            bottom:5px;
            border-radius:50%;
            border:3px solid transparent;
            border-top-color:#BA55D3;
            -webkit-animation:spin 3s linear infinite;
            animation:spin 3s linear infinite;
        }

        #loader:after{
            content:"";
            position:absolute;
            top:15px;
            left:15px;
            right:15px;
            bottom:15px;
            border-radius:50%;
            border:3px solid transparent;
            border-top-color:#FF00FF;
            -webkit-animation:spin 1.5s linear infinite;
            animation:spin 1.5s linear infinite;
        }

        @-webkit-keyframes spin{
            0%{
                -webkit-transform:rotate(0deg);
                -ms-transform:rotate(0deg);
                transform:rotate(0deg);
            }
            100%{
                -webkit-transform:rotate(360deg);
                -ms-transform:rotate(360deg);
                transform:rotate(360deg);
            }
        }

        @keyframes spin{
            0%{
                -webkit-transform:rotate(0deg);
                -ms-transform:rotate(0deg);
                transform:rotate(0deg);
            }
            100%{
                -webkit-transform:rotate(360deg);
                -ms-transform:rotate(360deg);
                transform:rotate(360deg);
            }
        }
    </style>

    <div class="panel-header panel-header-sm">
    </div>
    <div class="content">
        <div class="col-md-10 mr-auto ml-auto">
        @include('wizard.errors')
        <!--      Wizard container        -->
            <div class="wizard-container">
                <div class="card card-wizard" data-color="primary" id="wizardProfile">
                    <form action="" method="POST">
                        <!--        You can switch " data-color="primary" "  with one of the next bright colors: "green", "orange", "red", "blue"       -->
                        <div class="card-header text-center" data-background-color="orange">
                            <h3 class="card-title">
                                Build Your Dealer Site
                            </h3>
                            <h3 class="description">This information will let us know more about you.</h3>
                            <div class="wizard-navigation">
                                <ul class="nav nav-pills">
                                    <li class="nav-item">
                                        <a class="nav-link @if( 'type' === $activeStep ) active @endif" href="#type"
                                           data-toggle="tab" role="tab"
                                           aria-controls="about" aria-selected="true">
                                            <i class="now-ui-icons users_circle-08"></i> Type
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @if ( 'account' === $activeStep ) active @endif"
                                           href="#account" data-toggle="tab"
                                           role="tab" aria-controls="account" aria-selected="false">
                                            <i class="now-ui-icons ui-1_settings-gear-63"></i> Account
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @if( 'finish' === $activeStep ) active @endif" href="#finish"
                                           data-toggle="tab"
                                           role="tab" aria-controls="finish" aria-selected="false">
                                            <i class="now-ui-icons ui-1_check"></i> Finish
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="tab-content">

                                <div class="tab-pane @if( 'type' === $activeStep ) active @endif" id="type">
                                    <h5 class="info-text"> Choose Type Of Dealership You Provide </h5>
                                    <div class="row justify-content-center types_js">
                                        <div class="col-lg-10">
                                            <div class="row" role="tablist">
                                                <div class="col-sm-4">
                                                    <div class="choice" data-toggle="wizard-checkbox" data-index="1">
                                                        <input required type="checkbox"
                                                               {{ 'group' === old('type') ? 'checked' : '' }} name="type"
                                                               value="group">
                                                        <div class="icon">
                                                            <img src="{{asset('now/img/group.png')}}" alt="">
                                                        </div>
                                                        <h6>Group</h6>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="choice" data-toggle="wizard-checkbox" data-index="2">
                                                        <input required type="checkbox"
                                                               {{ 'oem' === old('type') ? 'checked' : '' }} name="type"
                                                               value="oem">
                                                        <div class="icon">
                                                            <img src="{{asset('now/img/oem.png')}}" alt="">
                                                        </div>
                                                        <h6>New Cars</h6>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="choice" data-toggle="wizard-checkbox" data-index="3">
                                                        <input required type="checkbox"
                                                               {{ 'independent' === old('type') ? 'checked' : '' }} name="type"
                                                               value="independent">
                                                        <div class="icon">
                                                            <img src="{{asset('now/img/independent.png')}}" alt="">
                                                        </div>
                                                        <h6>Independent</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane @if( 'account' === $activeStep ) active @endif" id="account">

                                    <h5 class="info-text">Let's start with the basic information</h5>


                                    <div class="row justify-content-center">
                                        <div class="col-lg-10 mt-3">
                                            <div class="input-group form-control-lg">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="now-ui-icons location_bookmark"></i>
                                                    </div>
                                                </div>
                                                <input id="pac-input" class="form-control"  type="text"
                                                       placeholder="Enter a location" value="{{ old('place_name') }}"/>
                                                <input name="place_name" type="hidden" id="place_name"
                                                       value="{{ old('place_name') }}">
                                                <input name="place_id" type="hidden" id="place_id">
                                            </div>
                                        </div>
                                    </div>

                                    <h4 style="margin:15px 0 0 0" class="info-text">OR</h4>

                                    <div class="row justify-content-center">
                                        <div class="col-lg-10 mt-3">
                                            <div class="input-group form-control-lg">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="now-ui-icons objects_planet"></i>
                                                    </div>
                                                </div>
                                                <input id="website_url" name="website_url" class="form-control"
                                                       type="text" placeholder="Enter Your Old Website URL"
                                                       value="{{ old('website_url') }}"/>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row justify-content-center">
                                        <div class="col-lg-10 mt-3">
                                            {{-- MAP --}}
                                            <div style="height:10em" id="map"></div>
                                            {{-- /MAP --}}
                                        </div>
                                    </div>

                                    <div class="row justify-content-center">
                                        <div class="col-lg-5 mt-3">
                                            <div class="input-group form-control-lg">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="now-ui-icons tech_mobile"></i>
                                                    </div>
                                                </div>
                                                <input required type="text" placeholder="Phone" value="{{ old('dealer_number') }}"
                                                       class="form-control" name="dealer_number">
                                            </div>
                                        </div>
                                        <div class="col-lg-5 mt-3">
                                            <div class="input-group form-control-lg">
                                                <button>Verify</button>
                                            </div>
                                        </div>
                                    </div>


                                    {{--                                    <div class="row justify-content-center">--}}

                                    {{--                                        <div class="col-sm-4">--}}
                                    {{--                                            <div class="picture-container">--}}
                                    {{--                                                <div class="picture">--}}
                                    {{--                                                    <img data-default="{{asset('now/img/default-avatar.png')}}"--}}
                                    {{--                                                         src="{{asset('now/img/default-avatar.png')}}"--}}
                                    {{--                                                         class="picture-src"--}}
                                    {{--                                                         id="logo" title=""/>--}}
                                    {{--                                                    <input name="logo_src" type="file" id="logo_input"--}}
                                    {{--                                                           class="wizard-picture" value="{{ old('logo_src') }}">--}}
                                    {{--                                                </div>--}}
                                    {{--                                                <h6 class="description">Logo</h6>--}}
                                    {{--                                            </div>--}}
                                    {{--                                        </div>--}}

                                    {{--                                        <div class="col-sm-4">--}}
                                    {{--                                            <div class="picture-container">--}}
                                    {{--                                                <div class="picture">--}}
                                    {{--                                                    <img data-default="{{asset('now/img/default-avatar.png')}}"--}}
                                    {{--                                                         src="{{asset('now/img/default-avatar.png')}}"--}}
                                    {{--                                                         class="picture-src"--}}
                                    {{--                                                         id="site_icon" title=""/>--}}
                                    {{--                                                    <input name="site_icon_src" type="file" id="site_icon_input"--}}
                                    {{--                                                           class="wizard-picture" value="{{ old('site_icon_src') }}">--}}
                                    {{--                                                </div>--}}
                                    {{--                                                <h6 class="description">Site Icon</h6>--}}
                                    {{--                                            </div>--}}
                                    {{--                                        </div>--}}

                                    {{--                                    </div>--}}


                                    <div class="row justify-content-center">

                                        <div class="col-lg-5 mt-3">

                                            <div class="input-group form-control-lg">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="now-ui-icons education_paper"></i>
                                                    </div>
                                                </div>
                                                <input required type="text" class="form-control"
                                                       placeholder="Dealership Name" name="dealer_name"
                                                       value="{{ old('dealer_name') }}">
                                            </div>

                                        </div>

                                        <div class="col-lg-5 mt-3">

                                            <div class="input-group form-control-lg">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="now-ui-icons ui-1_email-85"></i>
                                                    </div>
                                                </div>
                                                <input required type="text" placeholder="Lead Emails, comma separated"
                                                       value="{{ old('lead_emails') }}"
                                                       class="form-control" name="lead_emails">
                                            </div>

                                        </div>

                                    </div>


                                    <div class="row justify-content-center">

                                        <div class="col-lg-5 mt-3">

                                            <div class="input-group form-control-lg">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="now-ui-icons business_globe"></i>
                                                    </div>
                                                </div>
                                                <input required type="text" placeholder="Country" value="{{ old('country') }}"
                                                       class="form-control" name="country">
                                            </div>

                                        </div>

                                        <div class="col-lg-5 mt-3">

                                            <div class="input-group form-control-lg">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="now-ui-icons business_chart-pie-36"></i>
                                                    </div>
                                                </div>
                                                <input required type="text" placeholder="State" value="{{ old('state') }}"
                                                       class="form-control" name="state">
                                            </div>

                                        </div>

                                    </div>

                                    <div class="row justify-content-center">

                                        <div class="col-lg-5 mt-3">

                                            <div class="input-group form-control-lg">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="now-ui-icons location_map-big"></i>
                                                    </div>
                                                </div>
                                                <input required type="text" placeholder="City" value="{{ old('city') }}"
                                                       class="form-control" name="city">
                                            </div>

                                        </div>

                                        <div class="col-lg-5 mt-3">

                                            <div class="input-group form-control-lg">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="now-ui-icons ui-1_email-85"></i>
                                                    </div>
                                                </div>
                                                <input required type="text" placeholder="Postal Code"
                                                       value="{{ old('postal_code') }}"
                                                       class="form-control" name="postal_code">
                                            </div>

                                        </div>

                                    </div>

                                    <div class="row justify-content-center">

                                        <div class="col-lg-10 mt-3">

                                            <div class="input-group form-control-lg">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="now-ui-icons location_pin"></i>
                                                    </div>
                                                </div>
                                                <input required type="text" placeholder="Address" value="{{ old('address') }}"
                                                       class="form-control" name="address">
                                            </div>

                                        </div>

                                    </div>

                                    {{--
                                    <div class="row justify-content-center">

                                        <div class="col-lg-10 mt-3">

                                            <div class="input-group form-control-lg">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="now-ui-icons tech_mobile"></i>
                                                    </div>
                                                </div>
                                                <input type="text" placeholder="Monday" value=""
                                                       class="form-control" name="hours[monday]">
                                            </div>

                                        </div>

                                    </div>
                                    --}}

                                </div>

                                <div class="tab-pane @if( 'finish' === $activeStep ) active @endif" id="finish">
                                    <div class="row justify-content-center">

                                        <div class="col-sm-6 mt-3">

                                            <div class="input-group form-control-lg">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="now-ui-icons users_circle-08"></i>
                                                    </div>
                                                </div>
                                                <input type="text" class="form-control"
                                                       value="{{ old('person_firstname') }}"
                                                       placeholder="First Name (required)" name="person_firstname"
                                                       required>
                                            </div>

                                            <div class="input-group form-control-lg">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="now-ui-icons text_caps-small"></i>
                                                    </div>
                                                </div>
                                                <input type="text" placeholder="Last Name (required)"
                                                       value="{{ old('person_lastname') }}"
                                                       class="form-control" name="person_lastname" required>
                                            </div>

                                            <div class="input-group form-control-lg">
                                                <div class="input-group form-control-lg">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="now-ui-icons text_caps-small"></i>
                                                        </div>
                                                    </div>
                                                    <input type="email" placeholder="Email (required)"
                                                           class="form-control"
                                                           value="{{ old('person_email') }}"
                                                           name="person_email" required>
                                                </div>
                                            </div>

                                            <div class="input-group form-control-lg">
                                                <div class="input-group form-control-lg">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="now-ui-icons tech_mobile"></i>
                                                        </div>
                                                    </div>
                                                    <input placeholder="Phone (required)" class="form-control"
                                                           name="person_phonenumber"
                                                           value="{{ old('person_phonenumber') }}" required>
                                                </div>
                                            </div>

                                            <!--Begin input password -->
                                            <div class="input-group form-control-lg {{ $errors->has('password') ? ' has-danger' : '' }}">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="now-ui-icons objects_key-25"></i>
                                                    </div>
                                                </div>
                                                <input class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                                       placeholder="{{ __('Password') }}" type="password"
                                                       name="person_password" value="{{ old( 'person_password' ) }}"
                                                       required>
                                                @if ($errors->has('password'))
                                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <!--Begin input confirm password -->
                                            <div class="input-group form-control-lg">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="now-ui-icons objects_key-25"></i></i>
                                                    </div>
                                                </div>
                                                <input class="form-control" placeholder="{{ __('Confirm Password') }}"
                                                       type="password" name="person_password_confirmation"
                                                       value="{{ old( 'person_password_confirmation' ) }}" required>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="pull-right">
                                <input type='button' class='btn btn-next btn-fill btn-rose btn-wd' name='next'
                                       value='Next'/>
                                <input type='submit' class='btn btn-finish btn-fill btn-rose btn-wd' name='finish'
                                       value='Finish'/>
                            </div>
                            <div class="pull-left">
                                <input type='button' class='btn btn-previous btn-fill btn-default btn-wd'
                                       name='previous' value='Previous'/>
                            </div>
                            <div class="clearfix"></div>
                        </div>

                        {{ csrf_field() }}

                    </form>
                </div>
            </div>
            <!-- wizard container -->
        </div>
    </div>

    <div id="preloader">
        <div id="loader"></div>
    </div>
@endsection

@push('js')
    <script>
        // This sample uses the Place Autocomplete widget to allow the user to search
        // for and select a place. The sample then displays an info window containing
        // the place ID and other information about the place that the user has
        // selected.
        // This example requires the Places library. Include the libraries=places
        // parameter when you first load the API. For example:
        // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">
        function initMap(){

            if( ! document.getElementById( 'map' ) ){
                return
            }

            const map            = new google.maps.Map( document.getElementById( 'map' ), {
                center          : { lat: 38.931, lng: -99.88 },
                zoom            : 4,
                disableDefaultUI: true,
            } );
            const input          = document.getElementById( 'pac-input' )
            const autocomplete   = new google.maps.places.Autocomplete( input )
            let place_name_input = document.getElementById( 'place_name' )
            let place_id_input   = document.getElementById( 'place_id' )

            autocomplete.bindTo( 'bounds', map );
            // Specify just the place data fields that you need.
            autocomplete.setFields( [ 'place_id', 'geometry', 'name' ] );
            //map.controls[ google.maps.ControlPosition.TOP_LEFT ].push( input );
            const infowindow        = new google.maps.InfoWindow();
            const infowindowContent = document.getElementById( 'infowindow-content' );
            infowindow.setContent( infowindowContent );
            const marker = new google.maps.Marker( { map: map } );
            marker.addListener( 'click', () => {
                infowindow.open( map, marker );
            } );
            autocomplete.addListener( 'place_changed', () => {

                preloader_start()

                infowindow.close();
                const place = autocomplete.getPlace();

                if( ! place.geometry ){
                    return;
                }

                if( place.geometry.viewport ){
                    map.fitBounds( place.geometry.viewport );
                }
                else{
                    map.setCenter( place.geometry.location );
                    map.setZoom( 17 );
                }
                // Set the position of the marker using the place ID and location.
                marker.setPlace( {
                    placeId : place.place_id,
                    location: place.geometry.location,
                } );
                marker.setVisible( true );

                // do nothing if place id already set and it's the same
                if( place_id_input.value === place.place_id ){
                    return
                }

                place_name_input.value = place.name
                place_id_input.value   = place.place_id

                // get details
                let service = new google.maps.places.PlacesService( map );
                let request = {
                    placeId: place.place_id
                };
                service.getDetails( request, function( place_data, status ){
                    preloader_start()

                    if( status === google.maps.places.PlacesServiceStatus.OK ){
                        let place_data_conv = []

                        console.log( place_data )

                        if( place_data.website ){
                            let hostname         = 'https://' + ( new URL( place_data.website ) ).hostname;
                            let $oldWebSiteInput = $( 'input[name=website_url]' )
                            $oldWebSiteInput.val( hostname )
                            $oldWebSiteInput.trigger( 'change' )
                        }

                        for( let p = 0; p < place_data.address_components.length; p++ ){
                            let type = place_data.address_components[ p ].types[ 0 ]
                            let val  = place_data.address_components[ p ].long_name

                            if( 'locality' === type ){
                                place_data_conv[ 'city' ] = val
                            }
                            else if( 'administrative_area_level_1' === type ){
                                place_data_conv[ 'state' ] = val
                            }
                            else if( 'postal_code' === type ){
                                place_data_conv[ 'postal_code' ] = val
                            }
                            else if( 'country' === type ){
                                place_data_conv[ 'country' ] = val
                            }
                        }

                        let inputs = [
                            'dealer_number',
                            'dealer_name',
                            'lead_emails',
                            'country',
                            'state',
                            'city',
                            'postal_code',
                            'address',
                        ]

                        for( let o = 0; o < inputs.length; o++ ){
                            let $input = $( 'input[name=' + inputs[ o ] + ']' )

                            if( 'address' === inputs[ o ] ){
                                $input.val( place_data.formatted_address )
                            }
                            else if( 'dealer_name' === inputs[ o ] ){
                                $input.val( place_data.name )
                            }
                            else if( 'dealer_number' === inputs[ o ] ){
                                $input.val( place_data.formatted_phone_number )
                            }
                            else{
                                $input.val( place_data_conv[ inputs[ o ] ] )
                            }
                        }
                    }
                    else{
                        console.log( status )
                        preloader_end()
                    }
                } );

                preloader_end()

                /*
                infowindowContent.children.namedItem( 'place-name' ).textContent    =
                    place.name;
                infowindowContent.children.namedItem( 'place-id' ).textContent      =
                    place.place_id;
                infowindowContent.children.namedItem( 'place-address' ).textContent =
                    place.formatted_address;
                 */

                //infowindow.open( map, marker );
            } );
        }

        function preloader_start(){
            let $wizardContainer = $( '.wizard-container' )
            let $preloader       = $( '#preloader' )

            $preloader.show()
            $wizardContainer.css( 'opacity', '0.6' )
        }

        function preloader_end(){
            let $wizardContainer = $( '.wizard-container' )
            let $preloader       = $( '#preloader' )

            $preloader.hide()
            $wizardContainer.css( 'opacity', 1 )
        }

        $( document ).ready( function(){
            dt.checkFullPageBackgroundImage()

            // Initialise the wizard
            dt.initNowUiWizard()

            setTimeout( function(){
                $( '.card.card-wizard' ).addClass( 'active' )
                preloader_end()
            }, 600 )


            let $form                  = $( 'form' )
            let $types                 = $( '.types_js' )
            let $inputs_types          = $types.find( '.choice' )
            let $nextBtn               = $form.find( 'input[name=next]' )
            let $website_url_input = $form.find( '#website_url' )
            let $email_input           = $form.find( 'input[name="person_email"]' )
            let $phone_input           = $form.find( 'input[name="person_phonenumber"]' )

			<?php $steps_indexes = [ 'type', 'account', 'finish' ]; ?>
            $( '.card-wizard' ).bootstrapWizard( 'show', <?= array_search( $activeStep, $steps_indexes ) ?> )

            //$nextBtn.hide()

            $inputs_types.on( 'click', function( el ){
                let $el          = $( el.currentTarget )
                let clickedIndex = $el.data( 'index' )

                if( ! $el.hasClass( 'active' ) ){
                    $el.addClass( 'active' )
                    $el.find( 'input' ).attr( 'checked' )
                    return;
                }

                $el.closest( 'form' ).find( '.card-footer' ).css( 'padding', '10px' )
                $nextBtn.show()

                // disable for all the rest
                $inputs_types.each( function( choice, el_in ){
                    let $el_in = $( el_in )
                    let index  = $el_in.data( 'index' )

                    if( clickedIndex !== index ){
                        $el_in.removeClass( 'active' )
                        $el_in.find( 'input' ).removeAttr( 'checked' )
                    }
                } )

            } )

            $email_input.on( 'keyup focus blur', function(){

                let $the  = $( this )
                let email = $the.val()

                $.ajax( {
                    url: "{{ route('API_isEmailUnique') }}?email=" + email
                } ).done( function( data ){
                    let parsed = JSON.parse( data )

                    if( 'ERROR' === parsed.status ){
                        let $errorLabel = $( '#person_email-error' )
                        $errorLabel.html( parsed.message )
                        $errorLabel.show()
                    }

                } );
            } )

            $phone_input.on( 'keyup focus blur', function(){

                let $the  = $( this )
                let phone = $the.val()

                $.ajax( {
                    url: "{{ route('API_isPhoneUnique') }}?phone=" + phone
                } ).done( function( data ){
                    let parsed = JSON.parse( data )

                    if( 'ERROR' === parsed.status ){
                        let $errorLabel = $( '#person_phone-error' )
                        $errorLabel.html( parsed.message )
                        $errorLabel.show()
                    }

                } );
            } )

            $website_url_input.on( 'change', function( el ){
                let $the = $( this )
                let val  = $the.val()

                if( ! val ) return

                preloader_start()

                $.ajax( {
                    url: "{{ route('API_getSiteData') }}?site-url=" + val
                } ).done( function( data ){

                    let parsed = JSON.parse( data )

                    console.log( parsed )

                    if( 'OK' !== parsed.status ){
                        preloader_end()
                        return
                    }

                    let $logoImg     = $( '#logo' )
                    let $siteIconImg = $( '#site_icon' )

                    if( parsed.data.favicon_url ){
                        $siteIconImg.attr( 'src', parsed.data.favicon_url )
                    }
                    else{
                        $siteIconImg.attr( 'src', $siteIconImg.data( 'default' ) )
                    }

                    if( parsed.data.logo_url ){
                        $logoImg.attr( 'src', parsed.data.logo_url )
                    }
                    else{
                        $logoImg.attr( 'src', $logoImg.data( 'default' ) )
                    }

                    preloader_end()
                } )
            } )
        } )


    </script>
@endpush

<?php setcookie( 'activeStep', $activeStep, time() - 3600 ); ?>


