
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
                <li class="active">New York City Rental Cars</li>
            </ul>
            <!-- v_cars_search_change -->
                 <?php 
                        if(isset($cars_search_change)){
                            $this->load->view($cars_search_change);
                        }
                    ?>   
                <!-- cars_search_change -->
            <h3 class="booking-title">105 Rental Cars in New York on Mar 22 - Mar 27<small><a class="popup-text" href="#search-dialog" data-effect="mfp-zoom-out">Change search</a></small></h3>
            <div class="row">
                <!-- v_cars_menuleft -->
                 <?php 
                        if(isset($car_menuleft)){
                            $this->load->view($car_menuleft);
                        }
                    ?>   
                <!-- v_cars_menuleft -->
                <div class="col-md-9">
                    <div class="nav-drop booking-sort">
                        <h5 class="booking-sort-title"><a href="#">Sort: Price (low to high)<i class="fa fa-angle-down"></i><i class="fa fa-angle-up"></i></a></h5>
                        <ul class="nav-drop-menu">
                            <li><a href="#">Price (high to low)</a>
                            </li>
                            <li><a href="#">Car Name (A-Z)</a>
                            </li>
                            <li><a href="#">Car Name (Z-A)</a>
                            </li>
                            <li><a href="#">Car Type</a>
                            </li>
                        </ul>
                    </div>
                    <ul class="booking-list">
                    	<?php for ($i=1; $i <=15 ; $i++) { ?>
                    		<li>
                            <a class="booking-item" href="<?php echo site_url(); ?>cars/cars_details">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="booking-item-car-img">
                                            <img src="<?php echo site_url(); ?>/public/img/Land-Rover-Range-Rover-Evoque.png" alt="Image Alternative text" title="Image Title" />
                                            <p class="booking-item-car-title">Range Rover Evoque</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <ul class="booking-item-features booking-item-features-sign clearfix">
                                                    <li rel="tooltip" data-placement="top" title="Passengers"><i class="fa fa-male"></i><span class="booking-item-feature-sign">x 6</span>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="Doors"><i class="im im-car-doors"></i><span class="booking-item-feature-sign">x 5</span>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="Baggage Quantity"><i class="fa fa-briefcase"></i><span class="booking-item-feature-sign">x 4</span>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="Automatic Transmission"><i class="im im-shift-auto"></i><span class="booking-item-feature-sign">auto</span>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="Electric Vehicle"><i class="im im-electric"></i>
                                                    </li>
                                                </ul>
                                                <ul class="booking-item-features booking-item-features-small clearfix">
                                                    <li rel="tooltip" data-placement="top" title="Satellite Navigation"><i class="im im-satellite"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="FM Radio"><i class="im im-fm"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="Tilt Steering Wheel"><i class="im im-car-wheel"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="Power Windows"><i class="im im-car-window"></i>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-md-4">
                                                <ul class="booking-item-features booking-item-features-dark">
                                                    <li rel="tooltip" data-placement="top" title="Terminal Pickup"><i class="fa fa-plane"></i>
                                                    </li>
                                                    <li rel="tooltip" data-placement="top" title="Car with Driver"><i class="im im-driver"></i>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3"><span class="booking-item-price">$51</span><span>/day</span>
                                        <p class="booking-item-flight-class">Crossover</p><span class="btn btn-primary">Select</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                    	<?php	} ?>
                    	
                    </ul>
                    <?php 
                        if(isset($cars_count_page)){
                            $this->load->view($cars_count_page);
                        }
                    ?>
                </div>
            </div>
            <div class="gap"></div>
        </div>
