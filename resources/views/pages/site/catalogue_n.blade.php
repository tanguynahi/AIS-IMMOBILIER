<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>{{ $titre ?? 'Real Estate' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    @include('partials.site.css')
</head>

<body>

    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PTNPV7L" height="0" width="0"
        style="display:none;visibility:hidden"></iframe>
    </noscript>
    <div class="page_loader"></div>

    @include('partials.site.header',['topheader'=>'2'])
    @include('partials.site.sidebar')

    <div class="map-content content-area container-fluid">
        <div class="row">
            <div class="col-lg-5 col-xl-6">
                <div class="row">
                    <div id="map"></div>
                </div>
            </div>
            <div class="col-lg-7 col-xl-6 map-content-sidebar">
                <div class="properties-map-search properties-pad">
                    <div class="title-area">
                        <h2 class="pull-left">Search</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="properties-map-search-content">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <input class="form-control search-fields"
                                        placeholder="Enter address e.g. street, city">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <select class="selectpicker search-fields">
                                        <option>All Status</option>
                                        <option>For Sale</option>
                                        <option>For Rent</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <select class="selectpicker search-fields">
                                        <option>All Type</option>
                                        <option>Apartments</option>
                                        <option>Houses</option>
                                        <option>Shop</option>
                                        <option>Restaurant</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <select class="selectpicker search-fields">
                                        <option>location</option>
                                        <option>United States</option>
                                        <option>American Samoa</option>
                                        <option>Belgium</option>
                                        <option>Canada</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="range-slider form-group clearfix">
                                    <label>Area</label>
                                    <div data-min="0" data-max="10000" data-min-name="min_area"
                                        data-max-name="max_area" data-unit="Sq ft" data-name="area"
                                        class="range-slider-ui ui-slider" aria-disabled="false"></div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="range-slider form-group clearfix">
                                    <label>Price</label>
                                    <div data-min="0" data-max="150000" data-unit="USD" data-min-name="min_price"
                                        data-max-name="max_price" class="range-slider-ui ui-slider"
                                        aria-disabled="false"></div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <div id="options-content" class="collapse">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <select class="selectpicker search-fields">
                                            <option>Bedrooms</option>
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <select class="selectpicker search-fields">
                                            <option>Bathroom</option>
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <select class="selectpicker search-fields">
                                            <option>Balcony</option>
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <select class="selectpicker search-fields">
                                            <option>Garage</option>
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <label class="margin-t-10">Features</label>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="checkbox checkbox-theme checkbox-circle">
                                        <input id="checkbox1" type="checkbox">
                                        <label for="checkbox1">
                                            Free Parking
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-theme checkbox-circle">
                                        <input id="checkbox2" type="checkbox">
                                        <label for="checkbox2">
                                            Air Condition
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-theme checkbox-circle">
                                        <input id="checkbox3" type="checkbox">
                                        <label for="checkbox3">
                                            Places to seat
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-theme checkbox-circle">
                                        <input id="checkbox4" type="checkbox">
                                        <label for="checkbox4">
                                            Swimming Pool
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="checkbox checkbox-theme checkbox-circle">
                                        <input id="checkbox5" type="checkbox">
                                        <label for="checkbox5">
                                            Laundry Room
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-theme checkbox-circle">
                                        <input id="checkbox6" type="checkbox">
                                        <label for="checkbox6">
                                            Window Covering
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-theme checkbox-circle">
                                        <input id="checkbox7" type="checkbox">
                                        <label for="checkbox7">
                                            Central Heating
                                        </label>
                                    </div>
                                    <div class="checkbox checkbox-theme checkbox-circle">
                                        <input id="checkbox8" type="checkbox">
                                        <label for="checkbox8">
                                            Alarm
                                        </label>
                                    </div>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="title-area hidden-sm hidden-xs">
                        <h2 class="pull-left results-for">Results For : Properties List</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="fetching-properties pad-0-15 hidden-sm hidden-xs"></div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.site.js')

    @yield('js')
</body>

</html>
