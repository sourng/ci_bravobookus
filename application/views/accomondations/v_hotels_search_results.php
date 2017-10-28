   <div class="container">
            <ul class="breadcrumb">
                <li><a href="<?php echo site_url();?><?php echo $breadcrumb_1; ?>.html"><i class="fa fa-home"></i></a></li>
                 <li>
                <a href="<?php echo site_url();?><?php echo $breadcrumb_2; ?>.html" title=""><?php echo $breadcrumb_2; ?>            
                </a>
                </li>
                <li>
                <a href="<?php echo site_url();?><?php echo $breadcrumb_3; ?>.html" title=""><?php echo $breadcrumb_3; ?>            
                </a>
                </li>
                <li><?php echo $breadcrumb_4; ?>
                    
                </li>
            </ul>

            <div class="mfp-with-anim mfp-hide mfp-dialog mfp-search-dialog" id="search-dialog">
                <h3>Search for Hotel</h3>
                <form>
                    <div class="form-group form-group-lg form-group-icon-left"><i class="fa fa-map-marker input-icon input-icon-highlight"></i>
                        <label>Where are you going?</label>
                        <input class="typeahead form-control" placeholder="City, Airport, Point of Interest, Hotel Name or U.S. Zip Code" type="text" />
                    </div>
                    <div class="input-daterange" data-date-format="M d, D">
                        <div class="row">
                            <?php
                                if(isset($check)){
                                    $this->load->view($check);
                                }
                            ?>
                            
                            <?php
                                if(isset($room)){
                                    $this->load->view($room);
                                }
                            ?>
                            <?php
                                if(isset($guests)){
                                    $this->load->view($guests);
                                }
                            ?>
                            
                        </div>
                    </div>
                    <button class="btn btn-primary btn-lg" type="submit">Search for Hotels</button>
                </form>
            </div>

            <h3 class="booking-title">521 hotels in New York on Mar 22 - Apr 17 for 1 adult</h3>
            <form class="booking-item-dates-change mb40">
                <div class="row">
                    <div class="col-md-4">
                        <?php
                            if(isset($where)){
                                $this->load->view($where);
                            }
                        ?>
                    </div>
                    <div class="col-md-4">
                        <div class="input-daterange" data-date-format="MM d, D">
                            <div class="row">
                                <?php
                                    if(isset($check)){
                                        $this->load->view($check);
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <?php
                                if(isset($guests)){
                                    $this->load->view($guests);
                                }
                            ?>
                        
                            <?php
                                if(isset($room)){
                                    $this->load->view($room);
                                }
                            ?>
                        
                        </div>
                    </div>
                </div>
            </form>
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
                        <!-- <h5 class="booking-sort-title"><a href="#">Sort: Aviability<i class="fa fa-angle-down"></i><i class="fa fa-angle-up"></i></a></h5>
                        <ul class="nav-drop-menu">
                            <li><a href="#">Price (low to high)</a>
                            </li>
                            <li><a href="#">Price (hight to low)</a>
                            </li>
                            <li><a href="#" onClick="searchFilter()">Ranking</a>
                            </li>
                            <li><a href="#">Distance</a>
                            </li>
                            <li><a href="#">Number of Reviews</a>
                            </li>
                        </ul> -->
                         <div class="sort-select select float-left">
                            <span data-placeholder="Select">Star rating</span>
                            <select id="sortBy" onchange="searchFilter()">
                                <option value="">Sort By</option>
                                <option value="asc">Ascending</option>
                                <option value="desc">Descending</option>
                            </select>
                        </div>

                    </div>
                      

                    <div class="booking-list" id="postList">                       
                         <?php if(!empty($hotel)): foreach($hotel as $row): ?>
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
                                              <!--   <li><i class="fa fa-star"></i>
                                                </li>
                                                <li><i class="fa fa-star"></i>
                                                </li>
                                                <li><i class="fa fa-star"></i>
                                                </li>
                                                <li><i class="fa fa-star"></i>
                                                </li>
                                                <li><i class="fa fa-star-o"></i>
                                                </li> -->


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
                                        <p class="booking-item-address"><i class="fa fa-map-marker"></i>  <?php echo $row['h_address']; ?></p>
                                        <div>
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
                                            <li rel="tooltip" data-placement="top" title="" data-original-title="Bedrooms">
                                                <i class="im im-bed"></i>
                                                <span class="booking-item-feature-sign">x 1</span>
                                            </li>
                                            <li rel="tooltip" data-placement="top" title="" data-original-title="Bathrooms"><i class="im im-shower"></i><span class="booking-item-feature-sign">x 1</span>
                                            </li>
                                        </ul>

                                        <!-- End Facility -->



                                        </div>

                                        <!-- <small class="booking-item-last-booked">Latest booking: 58 minutes ago</small> -->


                                    </div>
                                    <div class="col-md-3"><span class="booking-item-price-from">from</span><span class="booking-item-price">$391</span><span>/night</span><span class="btn btn-primary">Book Now</span>
                                        <p class="booking-item-last-booked" style="color:blue;">Latest booking: 58 minutes ago</p>
                                    </div>
                                </div>
                            </a>
                        </li> 
                        <?php endforeach; else: ?>
                        <p>Post(s) not available.</p>
                        <?php endif; ?>
                        


                        <div class="loading" style="display: none;">
                            <div class="content">
                                <img src="<?php echo base_url().'assets/images/loading.gif'; ?>"/>
                            </div>
                        </div>


                      
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

                    </div>
                    
            



                </div>
            </div>
            <div class="gap"></div>
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
