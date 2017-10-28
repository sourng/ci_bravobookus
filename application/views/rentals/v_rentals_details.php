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
                <li><a href="#">New York City Hotels</a>
                </li>
                <li class="active">Duplex Greenwich</li>
            </ul>
            <div class="booking-item-details">
                <header class="booking-item-header">
                    <div class="row">
                        <div class="col-md-9">
                            <h2 class="lh1em">Midtown Manhattan Oversized</h2>
                            <p class="lh1em text-small"><i class="fa fa-map-marker"></i> 6782 Sarasea Circle, Siesta Key, FL 34242</p>
                            <ul class="list list-inline text-small">
                                <li><a href="#"><i class="fa fa-envelope"></i> Agent E-mail</a>
                                </li>
                                <li><a href="#"><i class="fa fa-home"></i> Agent Website</a>
                                </li>
                                <li><i class="fa fa-phone"></i> +1 (520) 466-9587</li>
                            </ul>
                        </div>
                        <div class="col-md-3">
                            <p class="booking-item-header-price"><span class="text-lg">$250</span>/night</p>
                        </div>
                    </div>
                </header>
                
               
                <?php 
                if (isset($booking_slider)) {
                 	$this->load->view($booking_slider);
                 } ?>


                <div class="gap"></div>
                <div class="row">
                    <div class="col-md-3">
                        <h3>Amenities</h3>
                        <ul class="booking-item-features booking-item-features-expand mb30 clearfix">
                            <li><i class="im im-wi-fi"></i><span class="booking-item-feature-title">Wi-Fi Internet</span>
                            </li>
                            <li><i class="im im-parking"></i><span class="booking-item-feature-title">Parking</span>
                            </li>
                            <li><i class="im im-air"></i><span class="booking-item-feature-title">Air Conditioning</span>
                            </li>
                            <li><i class="im im-kitchen"></i><span class="booking-item-feature-title">Kitchen</span>
                            </li>
                            <li><i class="im im-pool"></i><span class="booking-item-feature-title">Pool</span>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <h3>Suitability</h3>
                        <ul class="booking-item-features booking-item-features-expand mb30 clearfix">
                            <li><i class="im im-wheel-chair"></i><span class="booking-item-feature-title">Wheelchair Access</span>
                            </li>
                            <li><i class="im im-smoking"></i><span class="booking-item-feature-title">Smoking Allowed</span>
                            </li>
                            <li><i class="im im-children"></i><span class="booking-item-feature-title">For Children</span>
                            </li>
                            <li><i class="im im-elder"></i><span class="booking-item-feature-title">Elder Access</span>
                            </li>
                            <li><i class="im im-dog"></i><span class="booking-item-feature-title">Pet Allowed</span>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h3>Property description</h3>
                        <p>Dignissim nec mollis ante urna nostra pulvinar pretium urna montes sed posuere ridiculus augue bibendum lorem nascetur laoreet interdum viverra torquent gravida convallis potenti sollicitudin accumsan commodo nullam aenean cursus ornare dis mi ad nulla imperdiet varius euismod himenaeos per hac dis primis accumsan id lobortis aptent tincidunt class faucibus</p>
                        <p>Diam erat blandit libero leo nibh lobortis condimentum posuere taciti senectus volutpat fames montes elit feugiat augue nibh feugiat sociis</p>
                    </div>
                </div>
                <div class="gap gap-small"></div>
                <h3 class="mb20">Property Reviews</h3>
                

                <?php 
                if (isset($review_list)) {
                 	$this->load->view($review_list);
                 } ?>


            </div>
            <div class="gap gap-small"></div>
        </div>
s