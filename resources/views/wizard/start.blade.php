@extends('layouts.app', [
    'namePage'        => 'Dealer Wizard',
    'class'           => 'login-page sidebar-mini ',
    'activePage'      => 'wizard',
    'backgroundImage' => asset('now') . '/img/jet.jpg',
])


@section('content')
    <div class="panel-header panel-header-sm">
    </div>
    <div class="content">
        <div class="col-md-10 mr-auto ml-auto">
            <!--      Wizard container        -->
            <div class="wizard-container">
                <div class="card card-wizard" data-color="primary" id="wizardProfile">
                    <form action="" method="POST">
                        <!--        You can switch " data-color="primary" "  with one of the next bright colors: "green", "orange", "red", "blue"       -->
                        <div class="card-header text-center" data-background-color="orange">
                            <h3 class="card-title">
                                Build Your Dealer Site
                            </h3>
                            <h3 class="description">This information will let us know more about you.</h5>
                                <div class="wizard-navigation">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#about" data-toggle="tab" role="tab"
                                               aria-controls="about" aria-selected="true">
                                                <i class="now-ui-icons users_circle-08"></i> About
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#account" data-toggle="tab" data-toggle="tab"
                                               role="tab" aria-controls="account" aria-selected="false">
                                                <i class="now-ui-icons ui-1_settings-gear-63"></i> Account
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#address" data-toggle="tab" data-toggle="tab"
                                               role="tab" aria-controls="address" aria-selected="false">
                                                <i class="now-ui-icons ui-1_email-85"></i> Address
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">

                                <div class="tab-pane show active" id="about">
                                    <h5 class="info-text"> Let's start with the basic information</h5>
                                    <div class="row justify-content-center">
                                        <div class="col-sm-4">
                                            <div class="picture-container">
                                                <div class="picture">
                                                    <img src="../../assets/img/default-avatar.png" class="picture-src"
                                                         id="wizardPicturePreview" title=""/>
                                                    <input type="file" id="wizard-picture">
                                                </div>
                                                <h6 class="description">Choose Logo</h6>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="input-group form-control-lg">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="now-ui-icons users_circle-08"></i>
                                                    </div>
                                                </div>
                                                <input type="text" class="form-control" value="John"
                                                       placeholder="First Name (required)" name="firstname">
                                            </div>
                                            <div class="input-group form-control-lg">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="now-ui-icons text_caps-small"></i>
                                                    </div>
                                                </div>
                                                <input type="text" placeholder="Last Name (required)" value="Doe"
                                                       class="form-control" name="lastname"/>
                                            </div>
                                        </div>

                                        <div class="col-lg-10 mt-3">
                                            <div class="input-group form-control-lg">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="now-ui-icons text_caps-small"></i>
                                                    </div>
                                                </div>
                                                <input type="email" placeholder="Email (required)" class="form-control" value="jdoe@datgate.com"
                                                       name="email"/>
                                            </div>
                                        </div>

                                        <div class="col-lg-10 mt-3">
                                            <div class="input-group form-control-lg">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="now-ui-icons text_caps-small"></i>
                                                    </div>
                                                </div>
                                                <input id="pac-input" class="form-control" type="text" placeholder="Enter a location"/>
                                                <input name="place_name" type="hidden" id="place_name">
                                                <input name="place_id" type="hidden" id="place_id">
                                            </div>
                                        </div>

                                        <div class="col-lg-10 mt-3">
                                            {{-- MAP --}}
                                            <div style="height:10em" id="map"></div>
                                            {{-- /MAP --}}
                                        </div>

                                    </div>

                                </div>

                                <div class="tab-pane fade" id="account">
                                    <h5 class="info-text"> What are you doing? (checkboxes) </h5>
                                    <div class="row justify-content-center">
                                        <div class="col-lg-10">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="choice" data-toggle="wizard-checkbox">
                                                        <input type="checkbox" name="jobb" value="New">
                                                        <div class="icon">
                                                            <i class="now-ui-icons design-2_ruler-pencil"></i>
                                                        </div>
                                                        <h6>New</h6>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="choice" data-toggle="wizard-checkbox">
                                                        <input type="checkbox" name="jobb" value="New & Used">
                                                        <div class="icon">
                                                            <i class="now-ui-icons business_bulb-63"></i>
                                                        </div>
                                                        <h6>New & Used</h6>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="choice" data-toggle="wizard-checkbox">
                                                        <input type="checkbox" name="jobb" value="Used">
                                                        <div class="icon">
                                                            <i class="now-ui-icons tech_tv"></i>
                                                        </div>
                                                        <h6>Used</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="address">
                                    <div class="row justify-content-center">
                                        <div class="col-sm-12">
                                            <h5 class="info-text"> Are you living in a nice area? </h5>
                                        </div>
                                        <div class="col-sm-7">
                                            <div class="form-group">
                                                <label>Street Name</label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Street No.</label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-5">
                                            <div class="form-group">
                                                <label>City</label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-5">
                                            <div class="form-group">
                                                <label>Country</label>
                                                <select class="selectpicker" data-size="7"
                                                        data-style="btn btn-primary btn-round" title="Single Select">
                                                    <option value="Afghanistan"> Afghanistan</option>
                                                    <option value="Albania"> Albania</option>
                                                    <option value="Algeria"> Algeria</option>
                                                    <option value="American Samoa"> American Samoa</option>
                                                    <option value="Andorra"> Andorra</option>
                                                    <option value="Angola"> Angola</option>
                                                    <option value="Anguilla"> Anguilla</option>
                                                    <option value="Antarctica"> Antarctica</option>
                                                </select>
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
            const map          = new google.maps.Map( document.getElementById( 'map' ), {
                center: { lat: 38.931, lng: -99.88 },
                zoom  : 4,
                disableDefaultUI: true,
            } );
            const input          = document.getElementById( 'pac-input' );
            const autocomplete   = new google.maps.places.Autocomplete( input );
            let place_name_input = document.getElementById( 'place_name' );
            let place_id_input   = document.getElementById( 'place_id' );


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

                console.log(place)

                place_name_input.value = place.name
                place_id_input.value = place.place_id

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

        $( document ).ready( function(){
            demo.checkFullPageBackgroundImage();

            // Initialise the wizard
            demo.initNowUiWizard();
            setTimeout( function(){
                $( '.card.card-wizard' ).addClass( 'active' );
            }, 600 );
        } );

    </script>
@endpush


