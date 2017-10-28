<div class="container">
            <ul class="breadcrumb">
                <li><a href="index.html">Home</a>
                </li>
                <li><a href="#">United States</a>
                </li>
                <li><a href="#">New York (NY)</a>
                </li>
                <li><a href="#">New York City</a>
                </li>
                <li><a href="#">New York City Rental Cars</a>
                </li>
                <li class="active">Maserati GranTurismo</li>
            </ul>
            <div class="booking-item-details">

                <header class="booking-item-header">
                    <div class="row">
                        <div class="col-md-9">
                            <h2 class="lh1em">Maserati GranTurismo</h2>
                            <ul class="list list-inline text-small">
                                <li><a href="#"><i class="fa fa-envelope"></i> E-mail Car Agent</a>
                                </li>
                                <li><i class="fa fa-phone"></i> 810 1 941-684-2144</li>
                            </ul>
                        </div>
                        <div class="col-md-3">
                            <p class="booking-item-header-price"><small>price</small>  <span class="text-lg">$70</span>/day</p>
                        </div>
                    </div>
                </header>
                <div class="gap gap-small"></div>
                <div class="row row-wrap">
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-5">
                                <img src="<?php echo site_url(); ?>/public/img/Maserati-GranTurismo-Sport-facelift.png" alt="Image Alternative text" title="Image Title" />
                            </div>
                            <div class="col-md-7">
                                <div class="booking-item-price-calc">
                                    <div class="row row-wrap">
                                        <div class="col-md-6">
                                            <div class="checkbox">
                                                <label>
                                                    <input class="i-check" type="checkbox" />Child Toddler Seat<span class="pull-right">$35</span>
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    <input class="i-check" type="checkbox" />Ski Rack<span class="pull-right">$40</span>
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    <input class="i-check" type="checkbox" />Infant Child Seat<span class="pull-right">$35</span>
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    <input class="i-check" type="checkbox" />GPS Satellite<span class="pull-right">$100</span>
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    <input class="i-check" type="checkbox" />Show Chains<span class="pull-right">$120</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <ul class="list">
                                                <li>
                                                    <p>Price Per Day <span>$70</span>
                                                    </p>
                                                </li>
                                                <li>
                                                    <p>Rental Price <span>$490</span>
                                                    </p>
                                                    <small>7 days (april 13 - april 20)</small>
                                                </li>
                                                <li>
                                                    <p>Equipment <span>$<span id="car-equipment-total" data-value="0">0</span></span>
                                                    </p>
                                                </li>
                                                <li>
                                                    <p>Rental Tolal <span>$<span id="car-total" data-value="490">490</span></span>
                                                    </p>
                                                </li>
                                            </ul>
                                            <a href="#" class="btn btn-primary">Checkout</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="text-small">Arrive at your destination in style with this air-conditioned automatic. With room for 4 passengers and 2 pieces of luggage, it's ideal for small groups looking to get from A to B in comfort. Price can change at any moment so book now to avoid disappointment!</p>

                        <hr>
                        <div class="row row-wrap">
                            <div class="col-md-4">
                                <h5>Car Features</h5>
                                <ul class="booking-item-features booking-item-features-expand clearfix">
                                    <li><i class="fa fa-male"></i><span class="booking-item-feature-title">Up to 4 Passengers</span>
                                    </li>
                                    <li><i class="im im-car-doors"></i><span class="booking-item-feature-title">3 Doors</span>
                                    </li>
                                    <li><i class="fa fa-briefcase"></i><span class="booking-item-feature-title">2 Pieces of Laggage</span>
                                    </li>
                                    <li><i class="im im-shift-auto"></i><span class="booking-item-feature-title">Automatic Transmission</span>
                                    </li>
                                    <li><i class="im im-diesel"></i><span class="booking-item-feature-title">Gas Vehicle</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <h5>Default Equipment</h5>
                                <ul class="booking-item-features booking-item-features-expand clearfix">
                                    <li><i class="im im-climate-control"></i><span class="booking-item-feature-title">Climate Control</span>
                                    </li>
                                    <li><i class="im im-stereo"></i><span class="booking-item-feature-title">Stereo CD/MP3</span>
                                    </li>
                                    <li><i class="im im-car-window"></i><span class="booking-item-feature-title">Power Windows</span>
                                    </li>
                                    <li><i class="im im-fm"></i><span class="booking-item-feature-title">FM Radio</span>
                                    </li>
                                    <li><i class="im im-lock"></i><span class="booking-item-feature-title">Power Door Locks</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <h5>Pickup Features</h5>
                                <ul class="booking-item-features booking-item-features-expand booking-item-features-dark clearfix">
                                    <li><i class="fa fa-plane"></i><span class="booking-item-feature-title">Terminal Pickup</span>
                                    </li>
                                    <li><i class="im im-meet"></i><span class="booking-item-feature-title">Meet and Greet</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <?php 
                        if(isset($cars_location)){
                            $this->load->view($cars_location);
                        }
                    ?> 
                        <div class="gap gap-small"></div>
                    </div>
                </div>
            </div>
        </div>