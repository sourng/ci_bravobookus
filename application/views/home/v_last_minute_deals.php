<div class="container">
            <div class="gap"></div>
            <h1 class="text-center mb20">Last Minute Deals</h1>
            <div class="row row-wrap">
                <?php 
                // lmdeal=last minute deals
                // $last_minute_deals_data : get from Controller name : home
                foreach ($last_minute_deals_data as $lmdeal) {
                    ?>
                    <div class="col-md-4">
                    <div class="thumb">
                        <header class="thumb-header">
                            <a class="hover-img" href="<?php echo site_url(); ?>hotels.html/<?php echo $lmdeal['hotel_id']; ?>">
                                <img src="<?php echo base_url(); ?>uploads/hotels/<?php echo $lmdeal['h_feature_image'];?>" alt="<?php echo $lmdeal['h_name'];?>" title="<?php echo $lmdeal['h_name'];?>" />
                                <h5 class="hover-title-center">Book Now</h5>
                            </a>
                        </header>
                        <div class="thumb-caption">
                            <ul class="icon-group text-tiny text-color">
                               <?php 
                               if($lmdeal['star_rating']>0){
                                for($i=1;$i<=$lmdeal['star_rating'];$i++){
                                    ?>
                                    <li><i class="fa fa-star"></i></li>
                                    <?php
                                }
                               }else{
                                ?>
                                <li><i class="fa fa-star-half-empty"></i></li>
                                <?php
                               }

                               ?>
                                

                                <!-- <li><i class="fa fa-star"></i>
                                </li>
                                <li><i class="fa fa-star"></i>
                                </li>
                                <li><i class="fa fa-star"></i>
                                </li>
                                <li><i class="fa fa-star-half-empty"></i>
                                </li> -->
                            </ul>
                            <h5 class="thumb-title"><a class="text-darken" href="#"><?php echo $lmdeal['h_name'];?></a></h5>
                            <p class="mb0"><small><i class="fa fa-map-marker"></i> <?php echo $lmdeal['h_address'];?></small>
                            </p>
                            <p class="mb0 text-darken"><span class="text-lg lh1em text-color">$<?php echo $lmdeal['base_rate'];?></span><small> avg/night</small>
                            </p>
                        </div>
                    </div>
                </div>

                    <?php
                }

                ?>
            </div>
            <div class="gap gap-small"></div>
        </div>