<div class="col-md-9">
                    <div class="nav-drop booking-sort">
                        <h5 class="booking-sort-title"><a href="#">Sort: Price (low to high)<i class="fa fa-angle-down"></i><i class="fa fa-angle-up"></i></a></h5>
                        <ul class="nav-drop-menu">
                            <li><a href="#">Price (hight to low)</a>
                            </li>
                            <li><a href="#">Ranking</a>
                            </li>
                            <li><a href="#">Bedrooms (Most to Least)</a>
                            </li>
                            <li><a href="#">Bedrooms (Least to Most)</a>
                            </li>
                            <li><a href="#">Number of Reviews</a>
                            </li>
                            <li><a href="#">Number of Photos</a>
                            </li>
                            <li><a href="#">Just Added</a>
                            </li>
                        </ul>
                    </div>
                    <ul class="booking-list">

                         <?php 
                            for ($i=1; $i <=6 ; $i++) { 
                            ?>

                        <li>                            
                            <a class="booking-item" href="#">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="booking-item-img-wrap">
                                            <img src="<?php echo base_url();?>public/img/lhotel_porto_bay_sao_paulo_suite_lhotel_living_room_800x600.jpg" alt="Image Alternative text" title="LHOTEL PORTO BAY SAO PAULO suite lhotel living room" />
                                            <div class="booking-item-img-num"><i class="fa fa-picture-o"></i>12</div>
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
                                                <li><i class="fa fa-star"></i>
                                                </li>
                                            </ul><span class="booking-item-rating-number"><b >4.7</b> of 5</span><small>(620 reviews)</small>
                                        </div>
                                        <h5 class="booking-item-title">Cozy Apartment Manhattan East 20s</h5>
                                        <p class="booking-item-address"><i class="fa fa-map-marker"></i> New York, NY (Times Square)</p>
                                        <ul class="booking-item-features booking-item-features-rentals booking-item-features-sign">
                                            <li rel="tooltip" data-placement="top" title="Sleeps"><i class="fa fa-male"></i><span class="booking-item-feature-sign">x 3</span>
                                            </li>
                                            <li rel="tooltip" data-placement="top" title="Bedrooms"><i class="im im-bed"></i><span class="booking-item-feature-sign">x 1</span>
                                            </li>
                                            <li rel="tooltip" data-placement="top" title="Bathrooms"><i class="im im-shower"></i><span class="booking-item-feature-sign">x 1</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-3"><span class="booking-item-price">$386</span><span>/night</span><span class="btn btn-primary">Book Now</span>
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
                            <p><small>320 vacation rentals found in New York. &nbsp;&nbsp;Showing 1 – 15</small>
                            </p>
                            <ul class="pagination">
                                <li class="active"><a href="#">1</a>
                                </li>
                                <li><a href="#">2</a>
                                </li>
                                <li><a href="#">3</a>
                                </li>
                                <li><a href="#">4</a>
                                </li>
                                <li><a href="#">5</a>
                                </li>
                                <li><a href="#">6</a>
                                </li>
                                <li><a href="#">7</a>
                                </li>
                                <li class="dots">...</li>
                                <li><a href="#">43</a>
                                </li>
                                <li class="next"><a href="#">Next Page</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6 text-right">
                            <p>Not what you're looking for? <a class="popup-text" href="#search-dialog" data-effect="mfp-zoom-out">Try your search again</a>
                            </p>
                        </div>
                    </div>

                </div>