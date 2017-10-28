<div class="gap gap-small"></div>
            <h3 class="mb20">Vacation Rentals in Popuplar Destinations</h3>
            <div class="row row-wrap">

                <?php 
                    for ($i=01; $i <=12 ; $i++) { 
                    ?>
                   
                <div class="col-md-3">
                    <div class="thumb">
                        <a class="hover-img" href="#">
                            <img src="<?php echo base_url();?>public/img/gaviota_en_el_top_800x600.jpg" alt="Image Alternative text" title="Gaviota en el Top" />
                            <div class="hover-inner hover-inner-block hover-inner-bottom hover-inner-bg-black hover-hold">
                                <div class="text-small">
                                    <h5>New York City Hotels</h5>
                                    <p>74649 reviews</p>
                                    <p class="mb0">587 offers from $64</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                
                <?php
                        }
                    ?>
                
               
            </div>