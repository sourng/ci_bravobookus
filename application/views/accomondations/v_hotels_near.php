<h4>Hotels Near InterContinental New York Barclay</h4>
    <ul class="booking-list">

        <?php
            for($i=1;$i<=5;$i++){
                ?>
                <li>
                    <div class="booking-item booking-item-small">
                        <div class="row">
                            <div class="col-xs-4">
                                <img src="<?php echo base_url();?>public/img/Hotel_Centar_800×600.jpg" alt="Image Alternative text" title="hotel PORTO BAY SERRA GOLF living room" />
                            </div>
                            <div class="col-xs-5">
                                <h5 class="booking-item-title">Waldorf Astoria New York</h5>
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
                                </ul>
                            </div>
                            <div class="col-xs-3"><span class="booking-item-price-from">from</span><span class="booking-item-price">$345</span>
                            </div>
                        </div>
                    </div>
                </li>
        <?php
            }
        ?>
        
       
    </ul>