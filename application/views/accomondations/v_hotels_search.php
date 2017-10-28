        <div class="container">
            <h1 class="page-title">Search for Hotels</h1>
        </div>

        <div class="container">
            <form action="<?php echo base_url() ?>search_results">
                <div class="row">
                    <div class="col-md-4">
                       <?php
                            if(isset($where)){
                                $this->load->view($where);
                            }
                        ?> 
                    </div>
                    <div class="col-md-4">
                       <?php
                            if(isset($check)){
                                $this->load->view($check);
                            }
                        ?>
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
                <input class="btn btn-primary mt10" type="submit" value="Search for Hotels" />

                <button class="btn btn-primary btn-lg" type="submit">Search for Hotels</button>
            </form>
            <div class="gap gap-small"></div>
            <h3 class="mb20">Hotels in Popular Destinations</h3>
            <div class="row row-wrap">

                <?php 
                    for($i=1;$i<=12;$i++){
                        ?>
                        <div class="col-md-3">
                            <div class="thumb">
                                <a class="hover-img" href="#">
                                    <img src="<?php echo base_url();?>public/img/hotels_70×70.jpg" alt="Image Alternative text" title="Gaviota en el Top" />
                                    <div class="hover-inner hover-inner-block hover-inner-bottom hover-inner-bg-black hover-hold">
                                        <div class="text-small">
                                            <h5>New York City Hotels</h5>
                                            <p>65329 reviews</p>
                                            <p class="mb0">724 offers from $72</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <?php
                    }
                ?>
                
            </div>
            <div class="gap"></div>
            <h3 class="mb20">Top Deals</h3>
            <div class="row row-wrap">

                
                <?php
                    for($i=1;$i<=8;$i++){
                      ?>
                      <div class="col-md-3">
                    <div class="thumb">
                        <header class="thumb-header">
                            <a class="hover-img" href="#">
                                <img src="<?php echo base_url();?>public/img/Hotel_Centar_800×600.jpg" alt="Image Alternative text" title="hotel 1" />
                                <h5 class="hover-title-center">Book Now</h5>
                            </a>
                        </header>
                        <div class="thumb-caption">
                            <ul class="icon-group text-tiny text-color">
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
                            </ul>
                            <h5 class="thumb-title"><a class="text-darken" href="#">InterContinental New York B...</a></h5>
                            <p class="mb0"><small><i class="fa fa-map-marker"></i> Bronx (Bronx)</small>
                            </p>
                            <p class="mb0 text-darken"><span class="text-lg lh1em text-color">$165</span><small> avg/night</small>
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


