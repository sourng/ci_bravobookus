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
            <li class="active">InterContinental New York Barclay</li>
        </ul>
        <div class="booking-item-details">
            <header class="booking-item-header">
                <div class="row">
                    <div class="col-md-9">
                        <h2 class="lh1em">InterContinental New York Barclay</h2>
                        <p class="lh1em text-small"><i class="fa fa-map-marker"></i> 6782 Sarasea Circle, Siesta Key, FL 34242</p>
                        <ul class="list list-inline text-small">
                            <li><a href="#"><i class="fa fa-envelope"></i> Hotel E-mail</a>
                            </li>
                            <li><a href="#"><i class="fa fa-home"></i> Hotel Website</a>
                            </li>
                            <li><i class="fa fa-phone"></i> +1 (163) 493-1463</li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <p class="booking-item-header-price"><small>price from</small>  <span class="text-lg">$350</span>/night</p>
                        
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
                <!--Exeptional-->   
                <div class="col-md-6">
                    <?php 
                        if(isset($exeptional)){
                            $this->load->view($exeptional);
                        }
                        echo $showfacil[0]['field2'];
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




