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
            <li class="active"><?php echo $hotelDetail[0]['h_name']; ?></li>
        </ul>
        <div class="booking-item-details">
            <header class="booking-item-header">
                <div class="row">
                    <div class="col-md-9">
                        <h2 class="lh1em"><?php echo $hotelDetail[0]['h_name']; ?></h2>
                        <p class="lh1em text-small"><i class="fa fa-map-marker"></i> <?php echo $hotelDetail[0]['h_address']; ?></p>
                        <ul class="list list-inline text-small">
                            <li><a href="<?php echo $hotelDetail[0]['h_email']; ?>"><i class="fa fa-envelope"></i> <?php echo $hotelDetail[0]['h_email']; ?></a>
                            </li>
                            <li><a href="#"><i class="fa fa-home"></i> <?php echo $hotelDetail[0]['h_site']; ?></a>
                            </li>
                            <li><i class="fa fa-phone"></i> <?php echo $hotelDetail[0]['h_contact_phone']; ?></li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <p class="booking-item-header-price"><small>price from</small>  <span class="text-lg">$<?php echo $hotelDetail[0]['hr_base_rate']; ?></span>/night</p>
                        
                        <center><a href="<?php echo site_url(); ?>hotels/payment"><span class="btn btn-primary">Book Nows</span></a></center>
               
                    </div>
                </div>
            </header>
            <div class="row">
                <div class="col-md-6">

                <!--Slide-->   
                    <?php 
                        if(isset($slide)){
                            $this->load->view($slide);
                        }
                    ?>

                </div>
                <div class="col-md-6">

                <!--Exeptional-->   
                    <?php 
                        if(isset($exeptional)){
                            $this->load->view($exeptional);
                        }


                    ?>



                </div>

            </div>
            <div class="gap"></div>
            <h3>Available Rooms</h3>
            <div class="row">

                <?php 
                    if(isset($available_room)){
                        $this->load->view($available_room);
                    }
                ?>

                
            </div>
            <h3 class="mb20">Hotel Reviews</h3>
            <div class="row row-wrap">
                <div class="col-md-8">

                    <?php 
                        if(isset($review)){
                            $this->load->view($review);
                        }
                    ?>
                    <!--write_review-->
                    <div class="box bg-gray">    
                       <?php
                            if(isset($write_review)){
                                $this->load->view($write_review);
                            }
                       ?>
                    </div>

                </div>

                <div class="col-md-4">

                    <?php

                    
                    
                        if(isset($hotels_near)){
                            $this->load->view($hotels_near);
                        }
                    ?>
                </div>


            </div>
        </div>
        <div class="gap gap-small"></div>
    </div>





