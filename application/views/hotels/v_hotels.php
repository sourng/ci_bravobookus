<ul class="breadcrumb">
                <li><a href="index.html">Home</a>
                </li>
                <li><a href="#">United States</a>
                </li>
                <li><a href="#">New York (NY)</a>
                </li>
                <li><a href="#">New York City</a>
                </li>
                <li class="active">New York City Hotels</li>
            </ul>
            <!--change search-->
            <?php
                if(isset($change_search)){
                    $this->load->view($change_search);
                }
            ?>
            <h3 class="booking-title">521 hotels in New York on Mar 22 - Apr 17 for 1 adult <span class="btn btn-default"><a class="popup-text" href="#search-dialog" data-effect="mfp-zoom-out">Change search</a></span></h3>
            <div class="row">
                <div class="col-md-3">
                    <?php 
                        if(isset($menu_left_hotel)){
                            $this->load->view($menu_left_hotel);
                        }
                    ?>
                </div>
                <div class="col-md-9"> 
                    <div class="nav-drop booking-sort">
                        <h5 class="booking-sort-title"><a href="#">Sort: Aviability<i class="fa fa-angle-down"></i><i class="fa fa-angle-up"></i></a></h5>
                        <ul class="nav-drop-menu">
                            <li><a href="#">Price (low to high)</a>
                            </li>
                            <li><a href="#">Price (hight to low)</a>
                            </li>
                            <li><a href="#">Ranking</a>
                            </li>
                            <li><a href="#">Distance</a>
                            </li>
                            <li><a href="#">Number of Reviews</a>
                            </li>
                        </ul>
                    </div>
                    <ul class="booking-list">
                        <?php 
                                foreach ($hotels as $hotel) {                               
                            ?>
                        <li>
                            <a class="booking-item" href="<?php echo site_url(); ?>hotels.html/<?php echo $hotel['hotel_id']; ?>">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="booking-item-img-wrap">
                                            <img src="<?php echo base_url(); ?>uploads/hotels/<?php echo $hotel['h_feature_image']; ?>" alt="Image Alternative text" title="LHOTEL PORTO BAY SAO PAULO suite lhotel living room" />
                                            <div class="booking-item-img-num"><i class="fa fa-picture-o"></i>29</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="booking-item-rating">
                                            <ul class="icon-group booking-item-rating-stars">
                                                <li><i class="fa fa-star"></i>
                                                </li>
                                                <li><i class="fa fa-star"></i>
                                                </li>
                                                <li><i class="fa fa-star"></i>
                                                </li>
                                                <li><i class="fa fa-star"></i>
                                                </li>
                                                <li><i class="fa fa-star-half-empty"></i>
                                                </li>
                                            </ul><span class="booking-item-rating-number"><b >4.4</b> of 5</span><small>(406 reviews)</small>
                                        </div>
                                        <h5 class="booking-item-title"><?php echo $hotel['h_name']; ?></h5>
                                        <p class="booking-item-address"><i class="fa fa-map-marker"></i> <?php echo $hotel['h_address']; ?></p><small class="booking-item-last-booked">Latest booking: 1 hour ago</small>
                                    </div>
                                    <div class="col-md-3"><span class="booking-item-price-from">from</span><span class="booking-item-price">$<?php echo $hotel['rate']; ?></span><span>/night</span><span class="btn btn-primary">Book Now</span>
                                    </div>
                                </div>
                            </a>
                        </li>

                                <?php
                            }

                      ?>                        
                    </ul>
                    <div class="row">
                        <div class="col-md-6">
                            <p><small>521 hotels found in New York. &nbsp;&nbsp;Showing 1 – 15</small>
                            </p>
                            <ul class="pagination">
                                <?php echo $this->pagination->create_links(); ?>
                            </ul>
                        </div>
                        <div class="col-md-6 text-right">
                            <p>Not what you're looking for? <a class="popup-text" href="#search-dialog" data-effect="mfp-zoom-out">Try your search again</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="gap"></div>
            