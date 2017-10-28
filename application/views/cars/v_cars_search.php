<div class="container">
            <h1 class="page-title">Search for Rental Cars</h1>
        </div>




        <div class="container">
            <form>
                <div class="input-daterange" data-date-format="MM d, D">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group form-group-icon-left"><i class="fa fa-map-marker input-icon input-icon-hightlight"></i>
                                <label>Pick Up Location</label>
                                <input class="typeahead form-control" placeholder="City or Airport" type="text" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-hightlight"></i>
                                        <label>Check in</label>
                                        <input class="form-control" name="start" type="text" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-icon-left"><i class="fa fa-clock-o input-icon input-icon-hightlight"></i>
                                        <label>Time</label>
                                        <input class="time-pick form-control" value="12:00 AM" type="text" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group form-group-icon-left"><i class="fa fa-map-marker input-icon input-icon-hightlight"></i>
                                <label>Drop Off Location</label>
                                <input class="typeahead form-control" value="Same as Pickup" placeholder="City or Airport" type="text" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-group-icon-left"><i class="fa fa-calendar input-icon input-icon-hightlight"></i>
                                        <label>Check out</label>
                                        <input class="form-control" name="end" type="text" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-icon-left"><i class="fa fa-clock-o input-icon input-icon-hightlight"></i>
                                        <label>Time</label>
                                        <input class="time-pick form-control" value="12:00 AM" type="text" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input class="btn btn-primary mt10" type="submit" value="Search for Rental Cars" />
            </form>
            <div class="gap gap-small"></div>
            <h3 class="mb20">Popuplar Destinations</h3>
            <div class="row row-wrap">
                   <?php for ($i=1; $i <=12 ; $i++) { ?>
                    <div class="col-md-3">
                    <div class="thumb">
                        <a class="hover-img" href="<?php echo site_url(); ?>cars/cars_details">
                            <img src="<?php echo site_url(); ?>public/img/800x600.jpg" alt="Image Alternative text" title="Sydney Harbour" />
                            <div class="hover-inner hover-inner-block hover-inner-bottom hover-inner-bg-black hover-hold">
                                <div class="text-small">
                                    <h5>Sydney Hotels</h5>
                                    <p>61758 reviews</p>
                                    <p class="mb0">916 offers from $87</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
             <?php  } ?>
            </div>
            <div class="gap"></div>
            <h3 class="mb20">Top Deals</h3>
            <div class="row row-wrap">
                <?php for ($i=1; $i <=8 ; $i++) { ?>
                    <div class="col-md-3">
                    <div class="thumb">
                        <header class="thumb-header">
                            <a href="<?php echo site_url(); ?>cars/cars_details">
                                <img src="<?php echo site_url(); ?>public/img/Mercedes-Benz-Clasa-G-facelift.png" alt="Image Alternative text" title="Image Title" />
                            </a>
                        </header>
                        <div class="thumb-caption">
                            <h5 class="thumb-title"><a class="text-darken" href="#">Mercedes Benz G</a></h5><small>Crossover</small>
                            <ul class="booking-item-features booking-item-features-small booking-item-features-sign clearfix mt5">
                                <li rel="tooltip" data-placement="top" title="Passengers"><i class="fa fa-male"></i><span class="booking-item-feature-sign">x 5</span>
                                </li>
                                <li rel="tooltip" data-placement="top" title="Doors"><i class="im im-car-doors"></i><span class="booking-item-feature-sign">x 2</span>
                                </li>
                                <li rel="tooltip" data-placement="top" title="Baggage Quantity"><i class="fa fa-briefcase"></i><span class="booking-item-feature-sign">x 5</span>
                                </li>
                                <li rel="tooltip" data-placement="top" title="Automatic Transmission"><i class="im im-shift-auto"></i><span class="booking-item-feature-sign">auto</span>
                                </li>
                                <li rel="tooltip" data-placement="top" title="Electric Vehicle"><i class="im im-electric"></i>
                                </li>
                            </ul>
                            <p class="text-darken mb0 text-color">$63<small> /day</small>
                            </p>
                        </div>
                    </div>
                </div>
                 <?php    } ?>
            </div>
            <div class="gap gap-small"></div>
        </div>