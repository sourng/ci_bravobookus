   <?php if(!empty($hotels)): foreach($hotels as $row): ?>
                        <li>
                            <a class="booking-item" href="<?php echo site_url(); ?>hotels.html/<?php echo $row['hotel_id']; ?>">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="booking-item-img-wrap">
                                            <img src="<?php echo base_url(); ?>uploads/hotels/<?php echo $row['h_feature_image']; ?>" alt="<?php echo $row['h_feature_image']; ?>" title="<?php echo $row['h_name']; ?>" />
                                            <div class="booking-item-img-num"><i class="fa fa-picture-o"></i>28</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="booking-item-rating">
                                            <ul class="icon-group booking-item-rating-stars">
                                                <?php 
                                                if($row['star_rating']>0){
                                                    for($i=1;$i<= $row['star_rating'];$i++){
                                                        ?>
                                                        <i class="fa fa-star"></i>
                                                        <?php
                                                    }
                                                }else{
                                                    ?>
                                                    <i class="fa fa-star-o"></i>
                                                    <?php
                                                } 
                                                ?>   
                                            </ul><span class="booking-item-rating-number"><b >3.9</b> of 5</span><small>(1199 reviews)</small>
                                        </div>
                                        <h5 class="booking-item-title"><?php echo $row['h_name']; ?></h5>
                                        <p class="booking-item-address"><i class="fa fa-map-marker"></i> <?php echo $row['h_address']; ?></p>
                                         <!--   <small class="booking-item-last-booked">
                                            <?php 
                                           // echo short_title($row['h_description'], 168);
                                      ?>
                                        </small> -->
                                        <!-- Facility -->
                                        <ul class="booking-item-features booking-item-features-rentals booking-item-features-sign">
                                            <li rel="tooltip" data-placement="top" title="Sleep" data-original-title="Sleeps">
                                                <i class="fa fa-male"></i>
                                                <span class="booking-item-feature-sign">x 3</span>
                                            </li>
                                            <li rel="tooltip" data-placement="top" title="Bedrooms" data-original-title="Bedrooms">
                                                <i class="im im-bed"></i>
                                                <span class="booking-item-feature-sign">x 1</span>
                                            </li>
                                            <li rel="tooltip" data-placement="top" title="Bathrooms" data-original-title="Bathrooms">
                                                <i class="im im-shower">                                                    
                                                </i><span class="booking-item-feature-sign">x 1</span>
                                            </li>
                                        </ul>

                                        <!-- End Facility -->


                                        
                                    </div>
                                    <div class="col-md-3"><span class="booking-item-price-from">from</span><span class="booking-item-price">$391</span><span>/night</span>
                                        <span class="btn btn-primary">Book Now</span>
                                        <p class="booking-item-last-booked" style="color:blue;">Latest booking: 58 minutes ago</p>
                                    </div>
                                </div>
                            </a>
                        </li> 
                        <?php endforeach; else: ?>
                        <p>Post(s) not available.</p>
                        <?php endif; ?>
                       
                                <div class="row">
                        <div class="col-md-6">
                            <p><small>521 hotels found in New York. &nbsp;&nbsp;Showing 1 – 15</small>
                            </p>
                            
                            <?php echo $this->ajax_pagination->create_links(); ?>
                           <!--  <ul class="pagination">
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
                            </ul> -->

                        </div>
                        <div class="col-md-6 text-right">
                            <p>Not what you're looking for? <a class="popup-text" href="#search-dialog" data-effect="mfp-zoom-out">Try your search again</a>
                            </p>
                        </div>
                    </div>


                        <div class="loading" style="display: none;">
                            <div class="content">
                                <img src="<?php echo base_url().'assets/images/loading.gif'; ?>"/>
                            </div>
                        </div>
<?php
function short_title($old_string,$limit_word){
    // strip tags to avoid breaking any html
    $string = strip_tags($old_string);

    if (strlen($string) > $limit_word) {

        // truncate string
        $stringCut = substr($string, 0, $limit_word);

        // make sure it ends in a word so assassinate doesn't become ass...
        $string = substr($stringCut, 0, strrpos($stringCut, ' ')).'...'; 
    }
    return($string);
}
         
?>