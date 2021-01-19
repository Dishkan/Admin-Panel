@extends('layouts.wizard', [
    'namePage'        => 'Dealer Wizard',
    'class'           => 'login-page sidebar-mini ',
    'activePage'      => 'wizard',
    'backgroundImage' => asset('now') . '/img/jet.jpg',
])

@section('content')

    <style>

        textarea {
            width: 100%;
            resize: none;
        }


        button {
            border-radius: 5px;
            padding: 15px 25px;
            font-size: 22px;
            text-decoration: none;
            margin: 20px;
            color: #fff;
            position: relative;
            display: inline-block;
            cursor: pointer;
            border: 0;
        }

        button:active {
            transform: translate(0px, 5px);
            -webkit-transform: translate(0px, 5px);
            box-shadow: 0px 1px 0px 0px;
        }

        button:focus {
            outline: none !important
        }

        input, textarea {
            color: #494949;
            border: 1px solid #e3e3e3;
            border-radius: 3px;
            background: #fff;
            font-size: 14px;
            margin: 0 0 10px;
            padding: 5px;
            width: 100%;
            font-family: "Droid Serif", "Helvetica Neue", Helvetica, Arial, sans-serif;
            line-height: 1.5;
        }

        input:focus {
            border-color: #808080;
            outline: none;
        }

        textarea:focus {
            border-color: #808080;
            outline: none;
        }

        .blue_btn {
            top: -14px;
            left: -18px;
            background-color: #55acee;
            box-shadow: 0px 5px 0px 0px #3C93D5;
        }

        .overlay_popup {
            display: none;
            position: fixed;
            z-index: 999;
            top: 0;
            right: 0;
            left: 0;
            bottom: 0;
            background: #000;
            opacity: 0.5;
        }

        .popup {
            display: none;
            position: fixed;
            z-index: 1000;
            top: 40%;
            left: 50%;
            right: 50%;
            margin-left: -210px;
            margin-top: -50px;
            width: 50%;
        }

        .object {
            width: 30em;
            height: 15em;
            background-color: #eee;
            padding: 3em 4em;
        }

        .content .card-body .tab-content .icon {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 20px auto;
        }

        .card-wizard .choice.active {
            transform: scale(1.05);
        }

        .card-wizard .choice {
            transition: transform .3s;
        }

        .section-image .card .card-header .description {
            color: #fff;
        }

        .card-wizard .picture {
            border-radius: 0;
        }

        #preloader {
            z-index: 4;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        #loader {
            display: block;
            position: relative;
            left: 50%;
            top: 50%;
            width: 150px;
            height: 150px;
            margin: -75px 0 0 -75px;
            border-radius: 50%;
            border: 3px solid transparent;
            border-top-color: #9370DB;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
        }

        #loader:before {
            content: "";
            position: absolute;
            top: 5px;
            left: 5px;
            right: 5px;
            bottom: 5px;
            border-radius: 50%;
            border: 3px solid transparent;
            border-top-color: #BA55D3;
            -webkit-animation: spin 3s linear infinite;
            animation: spin 3s linear infinite;
        }

        #loader:after {
            content: "";
            position: absolute;
            top: 15px;
            left: 15px;
            right: 15px;
            bottom: 15px;
            border-radius: 50%;
            border: 3px solid transparent;
            border-top-color: #FF00FF;
            -webkit-animation: spin 1.5s linear infinite;
            animation: spin 1.5s linear infinite;
        }

        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        form .disabled-button {
            opacity: .5;
            background-color: #000 !important;
            pointer-events: none;
            border-color: #000 !important;
            color: #fff !important;
        }

        form button[type="submit"] {
            padding: 1.3rem 1.5rem;
            margin: 0;
            width: 100% !important;
            min-width: 270px;
            border-radius: 20px;
            font-size: 14px;
            text-transform: uppercase;
            font-weight: 700;
            border: 1px solid #008CBA;
            transition: .3s;
            color: #fff !important;
        }
        form .has-danger:after {
            cursor: pointer;
        }

        /*data-list*/
        .data-list {
            z-index: 2;
            position: absolute;
            top: 0;
            left: 1rem;
            right: 1rem;
            height: 100%;
            display: flex;
            align-items: flex-end;
            justify-content: center;
            padding: 1.5rem 1rem;
            background: rgba(255,255,255,.3);
        }
        .data-list > input {
            cursor: pointer;
            background-color: #4F6877;
            display: block;
            padding: 8px 20px 5px 10px;
            min-height: 25px;
            line-height: 24px;
            overflow: hidden;
            border: 0;
            width: 272px;
            color: #fff;
        }
        .data-list:before {
            content: '';
            display: block;
            position: absolute;
            top:0;
            right: 0;
            left: 0;
            bottom: 0;
            filter: blur(3px);
            z-index: -1;
        }


        /* dropdown-jquery list */
        .dropdown-list {
            width: 272px;
            margin: 0;
            color: #fff;
        }
        .dropdown-list p {
            margin: 0;
        }

        .dropdown-list dd,
        .dropdown-list dt {
            margin: 0px;
            padding: 0px;
        }

        .dropdown-list ul {
            margin: -1px 0 0 0;
        }
        .dropdown-list ul li {
            width: 100% !important;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            cursor: pointer;
            transition: .3s;
            padding-left: 0;
        }
        .dropdown-list ul li:hover {
            padding-left: .15rem
        }
        .dropdown-list ul li > input {
            width: auto;
            margin: 0;
            margin-right: .5rem;
            margin-bottom: 2px;
        }

        .dropdown-list dd {
            position: relative;
        }

        .dropdown-list dt {
            border-radius: 4px;
            background-color: #4F6877;
            display: block;
            padding: 8px 20px 5px 12px;
            min-height: 25px;
            overflow: hidden;
            border: 0;
            width: 100%;
            color: #fff;
            text-decoration: none;
            outline: none;
            font-size: 12px;
            line-height: 24px;

            overflow: auto;
            max-height: 424px;
            cursor: pointer;
        }

        .dropdown-list dt span,
        .dropdown-list .multiSel span {
            cursor: pointer;
            display: inline-block;
            padding: 0 3px 2px 0;
        }

        .dropdown-list dd ul {
            background-color: #4F6877;
            border: 0;
            color: #fff;
            display: none;
            left: 0px;
            padding: 2px 15px 2px 5px;
            position: absolute;
            top: 2px;
            width: 100%;
            list-style: none;
            height: 106px;
            overflow: auto;
            display: flex;
            flex-wrap: wrap;
            flex-direction: row;
        }
        .dropdown-list ul li {
            order: 3;
        }
        .dropdown-list ul li.first-one {
            order: 0;
        }

        .dropdown-list input[type="checkbox"] {
            cursor: pointer;
        }

        .dropdown-list input::placeholder {
            color: #fff;
            opacity: .8;
        }
        .dropdown-list input[name="searchSel"] {
            background: #333;
            border: 1px solid #333;
            color: #fff;
            padding: .2rem .6rem;
            font-size: 12px;
            line-height: 1;
            border-radius: 4px 0 0 4px;
            position: absolute;
            top: 1px;
            right: 100%;
            width: 100%;
            max-width: 100px;
            overflow: hidden;
            margin: 0;
            margin-right: -4px;
            z-index: -1;
            opacity: 0;
            visibility: hidden;
            transition: .3s;
        }
        .dropdown-list dd ul:not([style="display: none;"]) + input[name="searchSel"] {
            opacity: .7;
            visibility: visible;
        }
        .dropdown-list dd ul:not([style="display: none;"]) + input[name="searchSel"]:focus {
            opacity: 1;
        }

        .dropdown-list span.value {
            display: none;
        }
        .dropdown-list .hida {
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
        }
        .dropdown-list .hida:after {
            content: '';
            width: 24px;
            height: 24px;
            background: transparent;
            background-image: url("data:image/svg+xml;utf8,<svg fill='white' height='24' viewBox='0 0 24 24' width='24' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/><path d='M0 0h24v24H0z' fill='none'/></svg>");
            background-repeat: no-repeat;
            background-position: center;
            display: inline-block;
            transform: translateX(14px);
        }

        form #manualButton {
            background-color: #008CBA;
            font-size: 95%;
            height: 47px;
            padding: .3rem 1rem;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 30px;
        }

        /*manual block*/
        #oneblock input[type="button"] {
            padding: .6rem 1.5rem;
            width: 270px !important;
            border-radius: 20px;
            font-size: 14px;
            text-transform: uppercase;
            font-weight: 700;
            border: 1px solid #008CBA;
            transition: .3s;
            color: #fff !important;
        }
        #oneblock .input-group {
            margin-bottom: 0;
        }
        #oneblock input[type="button"]:hover {
            background-color: transparent !important;
            color: #008CBA !important;
        }
        #oneblock h5.info-text {
            margin-top: 2rem;
            margin-bottom: 1rem;
        }
        #oneblock .flex-2-columns {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        #oneblock .flex-2-columns > * {
            width: 100%;
            margin-bottom: 1rem;
        }
        @media (min-width: 992px) {
            #oneblock .flex-2-columns > * {
                width: 48%;
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
                    <!--        You can switch " data-color="primary" "  with one of the next bright colors: "green", "orange", "red", "blue"       -->
                    <div class="card-header text-center" data-background-color="orange">
                        <h3 class="card-title">
                            Build Your Dealer Site
                        </h3>
                        <h3 class="description">This information will let us know more about you.</h3>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane show active" id="type">
                                <h5 id="typetitle" class="info-text"> Choose Type Of Dealership You Provide </h5>
                                <form class=" / on_form_submit_js" action="{{ route('wizard2')  }}" method="POST">
                                    <div class="row justify-content-center types_js">
                                        <div class="col-lg-10">
                                            <input hidden name="dealer_makes" class="hidden / dropdown_list_js">
                                            <div id="autotypes" class="row" role="tablist">
                                                <div class="col-sm-4">
                                                    <div onclick="$('#oneblock').show(); $('#showDatalist').hide(); $('#showMultiDatalist').show();"
                                                         class="datalist choice" data-toggle="wizard-checkbox" data-index="1">
                                                        <input  class="type" type="checkbox"
                                                               {{ 'group' === old('type') ? 'checked' : '' }} name="type"
                                                               value="group">
                                                        <div class="icon">
                                                            <img src="{{asset('now/img/group.png')}}" alt="">
                                                        </div>
                                                        <h6>Dealer Group</h6>
                                                    </div>
                                                    <div id="showMultiDatalist" class="data-list">
                                                        <dl class="dropdown-list / dropdown-jquery">
                                                            <dt>
                                                                <span class="hida">Select Makes</span>
                                                                <p class="multiSel"></p>
                                                            </dt>
                                                            <dd>
                                                                <div class="mutliSelect">
                                                                    <ul style="display: none;">
                                                                        <li class="first-one">
                                                                            <input autocomplete="off" name="allmakes"  type="checkbox" value="select_all" />Select All</li>
                                                                        <li>
                                                                        @foreach($makes as $make)
                                                                            <li>
                                                                                <input autocomplete="off" name="make" type="checkbox" value="{{$make}}" />{{$make}}</li>
                                                                            <li>
                                                                        @endforeach
                                                                    </ul>
                                                                    <input name="searchSel" placeholder="Search">
                                                                </div>
                                                            </dd>
                                                        </dl>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div onclick="$('#oneblock').show(); $('#showDatalist').show(); $('#showMultiDatalist').hide();"
                                                         class="datalist choice" data-toggle="wizard-checkbox"
                                                         data-index="2">
                                                        <input class="type" type="checkbox"
                                                               {{ 'oem' === old('type') ? 'checked' : '' }} name="type"
                                                               value="oem">
                                                        <div id="iconimg" class="icon">
                                                            <img src="{{asset('now/img/oem.png')}}" alt="">
                                                        </div>
                                                        <h6>Franchised Dealer</h6>
                                                    </div>
                                                    <div id="showDatalist" class="data-list">
                                                        <dl class="dropdown-list / dropdown-jquery single-select">
                                                            <dt>
                                                                <span class="hida">Select a Make</span>
                                                                <p class="multiSel"></p>
                                                            </dt>
                                                            <dd>
                                                                <div class="mutliSelect">
                                                                    <ul style="display: none;">
                                                                        @foreach($makes as $make)
                                                                            <li>
                                                                                <input autocomplete="off" name="make" type="checkbox" value="{{$make}}" />{{$make}}</li>
                                                                            <li>
                                                                        @endforeach
                                                                    </ul>
                                                                    <input name="searchSel" placeholder="Search">
                                                                </div>
                                                            </dd>
                                                        </dl>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div onclick="$('#oneblock').show(); $('#showDatalist, #showMultiDatalist').hide();"
                                                         class="choice" data-toggle="wizard-checkbox" data-index="3">
                                                        <input class="type" type="checkbox"
                                                               {{ 'independent' === old('type') ? 'checked' : '' }} name="type"
                                                               value="independent">
                                                        <div class="icon">
                                                            <img src="{{asset('now/img/independent.png')}}" alt="">
                                                        </div>
                                                        <h6>Independent Dealer</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="oneblock">
                                        <div class="row justify-content-center">
                                            <div class="col-lg-10 mt-3">
                                                <div id="autosearch" class="input-group form-control-lg">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="now-ui-icons location_bookmark"></i>
                                                        </div>
                                                    </div>
                                                    <input id="pac-input" class="form-control" type="text"
                                                           placeholder="First, Search For Your Dealership…"
                                                           value="{{ old('place_name') }}"/>
                                                    <input name="place_name" type="hidden" id="place_name"
                                                           value="{{ old('place_name') }}">
                                                    <input name="place_id" type="hidden" id="place_id">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="showAuto">
                                            <div id="phoneAuto" class="row justify-content-center">
                                                <div class="col-lg-5 mt-3">
                                                    <div class="input-group form-control-lg">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <label>Phone Call to</label>
                                                            </div>
                                                        </div>
                                                        <input required type="text" placeholder="Phone"
                                                               value="{{ old('dealer_number_auto') }}"
                                                               class="form-control" name="dealer_number_auto">
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 mt-3">
                                                    <div class="input-group form-control-lg">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <label>Text Message to</label>
                                                            </div>
                                                        </div>
                                                        <input required type="text" placeholder="Phone"
                                                               value="{{ old('dealer_number_auto') }}"
                                                               class="form-control" name="dealer_number_auto">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row justify-content-center">
                                                <div class="col-lg-5 mt-3">
                                                    <div class="input-group form-control-lg">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="now-ui-icons objects_planet"></i>
                                                            </div>
                                                        </div>
                                                        <input required id="old_website_url" name="old_website_url"
                                                               class="form-control"
                                                               type="text" placeholder="Enter Your Old Website URL"
                                                               value="{{ old('old_website_url') }}"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row justify-content-center">
                                                <div class="col-lg-5 mt-3">

                                                    <div class="input-group form-control-lg">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="now-ui-icons ui-1_email-85"></i>
                                                            </div>
                                                        </div>
                                                        <input required type="text"
                                                               placeholder="Lead Emails, comma separated"
                                                               value="{{ old('dealer_email') }}"
                                                               class="form-control" name="dealer_email">
                                                    </div>

                                                </div>

                                            </div>
                                            <div class="row justify-content-center">
                                                <div class="col-lg-5 mt-3">

                                                    <div class="input-group form-control-lg">
                                                        <button id="submitbutton" type="submit" style="background-color: #008CBA; ">
                                                            Start Verification
                                                        </button>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    {{ csrf_field() }}
                                </form>
                                <div class="row justify-content-center types_js">
                                    <input id="buttonAuto" class="disabled-button"
                                           style="margin-top: 2em; width: 20%; background-color: #008CBA; color: white;"
                                           value="Get started" type="button"
                                           onclick="$('#showAuto').show(); $('#buttonAutoHide').show(); $('#buttonAuto').hide() "/>
                                </div>
                                <div class="row justify-content-center types_js">
                                    <input id="buttonAutoHide"
                                           style="margin-top: 2em; width: 20%; background-color: #008CBA; color: white;"
                                           value="Hide it &#8615;" type="button"
                                           onclick="$('#showAuto').hide(); $('#buttonAutoHide').hide(); $('#buttonAuto').show()"/>
                                </div>

                                <div class="row justify-content-center types_js">
                                    <input id="seeManual" style="width: 30%; background-color: #008CBA; color: white;"
                                           value="Add it manually" type="button"
                                           onclick="$('#showManual').show(); $('#hideManual').show(); $('#seeManual, #autosearch, #showDatalist, #autotypes, #typetitle, #showMultiDatalist').hide(); "/>
                                </div>
                                <div class="row justify-content-center types_js">
                                    <input id="hideManual" style="width: 30%; background-color: #008CBA; color: white;"
                                           value="Hide it &#8613;" type="button"
                                           onclick="$('#showManual').hide(); $('#hideManual').hide(); $('#seeManual').show(); $('#autosearch').show();  $('#showDatalist, #showMultiDatalist').hide(); $('#autotypes').show(); $('#typetitle').show()"/>
                                </div>
                                <div id="showManual">
                                    <form action="{{ route('wizard')  }}" method="POST">
                                        <div class="tab-pane" id="account">
                                            <h5 class="info-text">Let's start with the basic information</h5>

                                            <div class="row justify-content-center">
                                                <div class="col-lg-10 mt-3">
                                                    <div class="input-group form-control-lg">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="now-ui-icons shopping_tag-content"></i>
                                                            </div>
                                                        </div>
                                                        <select name="types" name="types" id="input-role"
                                                                class="form-control" placeholder="{{ __('Types') }}"
                                                                required>
                                                            <option value="dealer_group">Dealer group</option>
                                                            <option value="franchised_dealer">Franchised dealer</option>
                                                            <option value="independent_dealer">Independent dealer
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row justify-content-center">
                                                <div class="col-lg-10 mt-3">
                                                    <div class="input-group form-control-lg">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="now-ui-icons text_align-center"></i>
                                                            </div>
                                                        </div>
                                                        <input class="form-control" placeholder="Make" list="dtlist"
                                                               id="datalist" name="make_manual"
                                                               value="{{ old('make_manual')  }}">
                                                        <datalist id="dtlist">
                                                            @foreach($makes as $make)
                                                                <option>{{$make}}</option>
                                                            @endforeach
                                                        </datalist>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row justify-content-center">
                                                <div class="col-lg-10 mt-3">
                                                    <div class="input-group form-control-lg">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="now-ui-icons location_bookmark"></i>
                                                            </div>
                                                        </div>
                                                        <input required name="place_name_manual" id="place_name_manual"
                                                               class="form-control" type="text"
                                                               placeholder="Enter a location"
                                                               value="{{ old('place_name_manual') }}"/>
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
                                                        <input required id="old_website_url"
                                                               name="old_website_url_manual"
                                                               class="form-control"
                                                               type="text" placeholder="Enter Your Old Website URL"
                                                               value="{{ old('old_website_url_manual') }}"/>
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
                                                        <input required type="text" placeholder="Phone"
                                                               value="{{ old('dealer_number') }}"
                                                               class="form-control" name="dealer_number">
                                                    </div>
                                                </div>

                                                <div class="col-lg-5 mt-3">
                                                     <div class="input-group form-control-lg">
                                                         <button type="button" id="verification" class="show_popup blue_btn"
                                                                 rel="popup1">Verify
                                                         </button>
                                                         <div class="overlay_popup"></div>

                                                         <div class="popup" id="popup1">
                                                             <div class="object">
                                                                 <form action="">
                                                                 <p>Verification code: </p>
                                                                     <p><input type="text" name="codename"></p>
                                                                 <input style="background-color: black; color: white " type="submit" value="Send">
                                                                 </form>
                                                             </div>
                                                         </div>
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
                                                        <input required type="text"
                                                               placeholder="Lead Emails, comma separated"
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
                                                        <input required type="text" placeholder="Country"
                                                               value="{{ old('country') }}"
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
                                                        <input required type="text" placeholder="State"
                                                               value="{{ old('state') }}"
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
                                                        <input required type="text" placeholder="City"
                                                               value="{{ old('city') }}"
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
                                                        <input required type="text" placeholder="Address"
                                                               value="{{ old('address') }}"
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

                                        <div class="tab-pane" id="finish">
                                            <h5 class="info-text">User Account</h5>

                                            <div class="row justify-content-center">

                                                <div class="col-sm-10 mt-3 flex-2-columns">

                                                    <div class="input-group form-control-lg">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="now-ui-icons users_circle-08"></i>
                                                            </div>
                                                        </div>
                                                        <input required type="text" class="form-control"
                                                               value="{{ old('person_firstname') }}"
                                                               placeholder="First Name (required)"
                                                               name="person_firstname"
                                                        >
                                                    </div>

                                                    <div class="input-group form-control-lg">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="now-ui-icons text_caps-small"></i>
                                                            </div>
                                                        </div>
                                                        <input required type="text" placeholder="Last Name (required)"
                                                               value="{{ old('person_lastname') }}"
                                                               class="form-control" name="person_lastname">
                                                    </div>

                                                    <div class="input-group form-control-lg">
                                                        <div class="input-group form-control-lg">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">
                                                                    <i class="now-ui-icons text_caps-small"></i>
                                                                </div>
                                                            </div>
                                                            <input required type="email" placeholder="Email (required)"
                                                                   class="form-control"
                                                                   value="{{ old('person_email') }}"
                                                                   name="person_email">
                                                        </div>
                                                    </div>

                                                    <div class="input-group form-control-lg">
                                                        <div class="input-group form-control-lg">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">
                                                                    <i class="now-ui-icons tech_mobile"></i>
                                                                </div>
                                                            </div>
                                                            <input required onchange="verifyFunc()"
                                                                   id="person_phonenumber"
                                                                   placeholder="Phone (required)" class="form-control"
                                                                   name="person_phonenumber"
                                                                   value="{{ old('person_phonenumber') }}">
                                                        </div>
                                                    </div>

                                                    <!--Begin input password -->
                                                    <div
                                                        class="input-group form-control-lg {{ $errors->has('password') ? ' has-danger' : '' }}">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="now-ui-icons objects_key-25"></i>
                                                            </div>
                                                        </div>
                                                        <input required
                                                               class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                                               placeholder="{{ __('Password') }}" type="password"
                                                               name="person_password"
                                                               value="{{ old( 'person_password' ) }}"
                                                        >
                                                        @if ($errors->has('password'))
                                                            <span class="invalid-feedback" style="display: block;"
                                                                  role="alert">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                                        @endif
                                                    </div>
                                                    <!--Begin input confirm password -->
                                                    <div class="input-group form-control-lg">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <i class="now-ui-icons objects_key-25"></i>
                                                            </div>
                                                        </div>
                                                        <input required class="form-control"
                                                               placeholder="{{ __('Confirm Password') }}"
                                                               type="password" name="person_password_confirmation"
                                                               value="{{ old( 'person_password_confirmation' ) }}"
                                                        >
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="row justify-content-center types_js">
                                                <div class="col-lg-5 mt-3">
                                                    <button id="manualButton" type="submit"
                                                        style="background-color: #008CBA; font-size: 95%">Finish
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        {{ csrf_field() }}
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="pull-right">
                            <input id="next" disabled="true" type='hidden'
                                   class='btn btn-next btn-fill btn-rose btn-wd' name='next'
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
                </div>
            </div>
            <!-- wizard container -->
        </div>
    </div>
    </div>
    <div id="preloader">
        <div id="loader"></div>
    </div>
@endsection

@push('js')
    <script>
        //fill makes input on form submit
        $(document).on('submit','form.on_form_submit_js',function(){
            let $checkedType = $(this).find('#autotypes .choice input[type="checkbox"]:checked').parents('.choice')
            let $makes_value = $checkedType.parent().find(".data-list .multiSel").text();
            $(this).find('input.dropdown_list_js').val($makes_value);
        });

        //dropdown-jquery

        //smart search
        var $def_sorder = 3;
        $(".dropdown-jquery input[name='searchSel']").on('input', function(e){
            let searchVal = $(this).val();
            if(searchVal) {
                $(this).parents('.mutliSelect').find('ul li:not(.first-one)').css('order', $def_sorder);
                $(this).parents('.mutliSelect').find('ul li input[type="checkbox"]:not([value="select_all"])').each(function(){
                    let $li_wrap = $(this).parents('li');
                    let check_value = $(this).val().toLowerCase();
                    if (check_value.indexOf( searchVal.toLowerCase() ) >= 0) {
                        $li_wrap.css('order', '1');
                    } else {
                        $li_wrap.css('order', $def_sorder);
                    }
                })
            } else {
                $(this).parents('.mutliSelect').find('ul li:not(.first-one)').css('order', $def_sorder);
            }
        });

        $(".dropdown-jquery dt").on('click', function() {
            $(this).parents(".dropdown-jquery").find("dd ul").slideToggle('fast');
        });

        $(document).bind('click', function(e) {
            var $clicked = $(e.target);
            if (!$clicked.parents().hasClass("dropdown-jquery")) {
                $('.data-list').find("dd ul").hide();
            }
        });

        $('.mutliSelect input[type="checkbox"], .mutliSelect ul li').on('click', function(event) {

            $the_el = $(this);
            let target = $( event.target );
            if ( target.is( "li" ) ) {
                $the_el.find('input[type="checkbox"]').trigger('click');
                return;
            }

            let $the_dropDrown = $the_el.parents(".dropdown-jquery");

            if($the_el.val() == 'select_all') {
                if($the_el.is(':checked')) {
                    $the_dropDrown.find('input[type="checkbox"]:not([value="select_all"]):not(:checked)').trigger("click");
                } else {
                    $the_dropDrown.find('input[type="checkbox"]:not([value="select_all"]):checked').trigger("click");
                }
            } else {
                let single_mode = $the_dropDrown.hasClass("single-select");

                if(!single_mode) {
                    var title = $the_el.closest('.mutliSelect').find('input[type="checkbox"]').val(),
                        title = $the_el.val() + ",";

                    if ($the_el.is(':checked')) {
                        var html = '<span title="' + title + '">' + title + '</span>';
                        $the_dropDrown.find('.multiSel').append(html);
                        $the_dropDrown.find(".hida").hide();

                    } else {
                        $the_dropDrown.find('span[title="' + title + '"]').remove();
                        if($the_dropDrown.find('.multiSel').children().length == 0)
                            $the_dropDrown.find(".hida").show();
                    }
                } else {

                    if ($the_el.is(':checked')) {
                        var title = $the_el.val();
                        $the_dropDrown.find('.multiSel').html(title);
                        $the_dropDrown.find(".hida").hide();
                        $the_dropDrown.find('input[type="checkbox"]:not([value="' + title + '"]):checked').prop( "checked", false );
                    } else {
                        $the_dropDrown.find('.multiSel').html('');
                        $the_dropDrown.find(".hida").show();
                    }

                }
            }
        });
    </script>
    <script>
        $('#showManual').hide()
        $('#showAuto').hide()
        $('#buttonAutoHide').hide()
        $('#hideManual').hide()
        $('#oneblock').hide()
        $('#showDatalist').hide()
        $('#showMultiDatalist').hide()

        function verifyFunc() {
            if ($('#person_phonenumber').val() !== "") {
                $('#verification').prop('disabled', false);
            }
        }

        $('.show_popup').click(function () {
            var popup_id = $('#' + $(this).attr("rel"));
            $(popup_id).show();
            $('.overlay_popup').show();
        })
        $('.overlay_popup').click(function () {
            $('.overlay_popup, .popup').hide();
        })

        // This sample uses the Place Autocomplete widget to allow the user to search
        // for and select a place. The sample then displays an info window containing
        // the place ID and other information about the place that the user has
        // selected.
        // This example requires the Places library. Include the libraries=places
        // parameter when you first load the API. For example:
        // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">
        function initMap() {

            $('#map').hide()

            if (!document.getElementById('map')) {
                return
            }

            const map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: 38.931, lng: -99.88},
                zoom: 4,
                disableDefaultUI: true,
            });
            const input = document.getElementById('pac-input')
            const autocomplete = new google.maps.places.Autocomplete(input)
            let place_name_input = document.getElementById('place_name')
            let place_id_input = document.getElementById('place_id')

            autocomplete.bindTo('bounds', map);
            // Specify just the place data fields that you need.
            autocomplete.setFields(['place_id', 'geometry', 'name']);
            //map.controls[ google.maps.ControlPosition.TOP_LEFT ].push( input );
            const infowindow = new google.maps.InfoWindow();
            const infowindowContent = document.getElementById('infowindow-content');
            infowindow.setContent(infowindowContent);
            const marker = new google.maps.Marker({map: map});
            marker.addListener('click', () => {
                infowindow.open(map, marker);
            });
            autocomplete.addListener('place_changed', () => {

                preloader_start()

                infowindow.close();
                const place = autocomplete.getPlace();

                if (!place.geometry) {
                    return;
                }

                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(17);
                }
                // Set the position of the marker using the place ID and location.
                marker.setPlace({
                    placeId: place.place_id,
                    location: place.geometry.location,
                });
                marker.setVisible(true);

                // do nothing if place id already set and it's the same
                if (place_id_input.value === place.place_id) {
                    return
                }

                place_name_input.value = place.name
                place_id_input.value = place.place_id

                // get details
                let service = new google.maps.places.PlacesService(map);
                let request = {
                    placeId: place.place_id
                };
                service.getDetails(request, function (place_data, status) {
                    preloader_start()

                    if (status === google.maps.places.PlacesServiceStatus.OK) {
                        let place_data_conv = []

                        console.log(place_data)
                        if($("#buttonAuto")) $("#buttonAuto").removeClass("disabled-button");
                        //showAuto
                        if (place_data.vicinity !== '') {
                            $('#showAuto').show()
                            $('#buttonAuto').hide()
                            $('#buttonAutoHide').show()
                        }

                        if (!place_data.formatted_phone_number) {
                            $('#phoneAuto').hide()
                            $('#buttonAuto').hide()
                            $('#buttonAutoHide').show()
                        }

                        if (place_data.formatted_phone_number) {
                            $('#phoneAuto').show()
                            $('#buttonAuto').hide()
                            $('#buttonAutoHide').show()
                        }

                        if (place_data.website) {
                            let hostname = 'https://' + (new URL(place_data.website)).hostname;
                            let $oldWebSiteInput = $('input[name=old_website_url]')
                            $oldWebSiteInput.val(hostname)
                            $oldWebSiteInput.trigger('change')
                        }

                        for (let p = 0; p < place_data.address_components.length; p++) {
                            let type = place_data.address_components[p].types[0]
                            let val = place_data.address_components[p].long_name
                            /*
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
                                                        } */
                        }

                        let inputs = [
                            'dealer_number_auto',
                            'lead_emails_auto',
                            //'dealer_number',
                            //'dealer_name',
                            //'lead_emails',
                            //'country',
                            //'state',
                            //'city',
                            //'postal_code',
                            //'address',
                        ]

                        for (let o = 0; o < inputs.length; o++) {
                            let $input = $('input[name=' + inputs[o] + ']')
                            /*
                            if( 'address' === inputs[ o ] ){
                                $input.val( place_data.formatted_address )
                            }
                            else if( 'dealer_name' === inputs[ o ] ){
                                $input.val( place_data.name )
                            }
                            else if( 'dealer_number' === inputs[ o ] ){
                                $input.val( place_data.formatted_phone_number )
                            }
                            else */
                            if ('dealer_number_auto' === inputs[o]) {
                                $input.val(place_data.formatted_phone_number)
                            } else {
                                $input.val(place_data_conv[inputs[o]])
                            }
                        }
                    } else {
                        console.log(status)
                        preloader_end()
                    }
                });

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
            });
        }

        function preloader_start() {
            let $wizardContainer = $('.wizard-container')
            let $preloader = $('#preloader')

            $preloader.show()
            $wizardContainer.css('opacity', '0.6')
        }

        function preloader_end() {
            let $wizardContainer = $('.wizard-container')
            let $preloader = $('#preloader')

            $preloader.hide()
            $wizardContainer.css('opacity', 1)
        }

        $(document).ready(function () {
            dt.checkFullPageBackgroundImage()

            // Initialise the wizard
            dt.initNowUiWizard()

            setTimeout(function () {
                $('.card.card-wizard').addClass('active')
                preloader_end()
            }, 600)


            let $form = $('form')
            let $types = $('.types_js')
            let $inputs_types = $types.find('.choice')
            let $nextBtn = $form.find('input[name=next]')
            let $finishBtn = $form.find('input[name=finish]')
            let $old_website_url_input = $form.find('#old_website_url')
            let $email_input = $form.find('input[name="person_email"]')
            let $dealeremail_input = $form.find('input[name="dealer_email"]')
            let $phone_input = $form.find('input[name="person_phonenumber"]')
            let $dealer_input = $form.find('input[name="dealer_number"]')

            $phone_input.mask('(999) 999-9999');
            $dealer_input.mask('(999) 999-9999');

            //$nextBtn.hide()

            $inputs_types.on('click', function (el) {

                $finishBtn.hide()

                // $( '#next' ).prop( 'disabled', false );

                let $el = $(el.currentTarget)
                let clickedIndex = $el.data('index')

                if (!$el.hasClass('active')) {
                    $el.addClass('active')
                    $el.find('input').attr('checked')
                    return;
                }

                $el.closest('form').find('.card-footer').css('padding', '10px')
                $nextBtn.hide()

                // disable for all the rest
                $inputs_types.each(function (choice, el_in) {
                    let $el_in = $(el_in)
                    let index = $el_in.data('index')

                    if (clickedIndex !== index) {
                        $el_in.removeClass('active')
                        $el_in.find('input').removeAttr('checked')
                    }
                })

            })

            $email_input.on('keyup focus blur', function () {

                let $the = $(this)
                let email = $the.val()

                $.ajax({
                    url: "{{ route('API_isEmailUnique') }}?email=" + email
                }).done(function (data) {
                    let parsed = JSON.parse(data)

                    if ('ERROR' === parsed.status) {
                        let $errorLabel = $('#person_email-error')
                        $errorLabel.html(parsed.message)
                        $errorLabel.show()
                    }

                });
            })
            $dealeremail_input.on('keyup focus blur', function () {

                let $the = $(this)
                let email = $the.val()

                $.ajax({
                    url: "{{ route('API_isEmailUnique') }}?email=" + email
                }).done(function (data) {
                    let parsed = JSON.parse(data)

                    if ('ERROR' === parsed.status) {
                        let $errorLabel = $('#person_email-error')
                        $errorLabel.html(parsed.message)
                        $errorLabel.show()
                        $('#submitbutton').hide()
                    }
                    else {
                        $('#submitbutton').show()
                    }

                });
            })

            $phone_input.on('keyup focus blur', function () {

                let $the = $(this)
                let phone = $the.val()

                $.ajax({
                    url: "{{ route('API_isPhoneUnique') }}?phone=" + phone
                }).done(function (data) {
                    let parsed = JSON.parse(data)

                    if ('ERROR' === parsed.status) {
                        let $errorLabel = $('#person_phone-error')
                        $errorLabel.html(parsed.message)
                        $errorLabel.show()
                    }

                });
            })

            $old_website_url_input.on('change', function (el) {
                let $the = $(this)
                let val = $the.val()

                if (!val) return

                preloader_start()

                $.ajax({
                    url: "{{ route('API_getSiteData') }}?site-url=" + val
                }).done(function (data) {

                    let parsed = JSON.parse(data)

                    console.log(parsed)

                    if ('OK' !== parsed.status) {
                        preloader_end()
                        return
                    }

                    let $logoImg = $('#logo')
                    let $siteIconImg = $('#site_icon')

                    if (parsed.data.favicon_url) {
                        $siteIconImg.attr('src', parsed.data.favicon_url)
                    } else {
                        $siteIconImg.attr('src', $siteIconImg.data('default'))
                    }

                    if (parsed.data.logo_url) {
                        $logoImg.attr('src', parsed.data.logo_url)
                    } else {
                        $logoImg.attr('src', $logoImg.data('default'))
                    }

                    preloader_end()
                })
            })
        })


    </script>
@endpush


