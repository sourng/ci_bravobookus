<div class="tabbable booking-details-tabbable">
    <ul class="nav nav-tabs" id="myTab">
        <li class="active"><a href="#tab-1" data-toggle="tab"><i class="fa fa-camera"></i>Photos</a>
        </li>
        <li><a href="#google-map-tab" data-toggle="tab"><i class="fa fa-map-marker"></i>On the Map</a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane fade in active" id="tab-1">
            <div class="fotorama" data-allowfullscreen="true" data-nav="thumbs">
                <?php
                    for($i=1;$i<=10;$i++){
                        ?>
                    <img src="<?php echo base_url();?>public/img/brookfield_800x600.jpg" alt="Image Alternative text" title="hotel PORTO BAY SERRA GOLF living room" />

                    <img src="<?php echo base_url();?>public/img/offices__800×600.jpg" alt="Image Alternative text" title="hotel PORTO BAY RIO INTERNACIONAL rooftop pool" />

                     <img src="<?php echo base_url();?>public/img/hotel_paris_800×600.jpg" alt="Image Alternative text" title="hotel PORTO BAY RIO INTERNACIONAL rooftop pool" />

                <?php
                    }
                        ?>
    
            </div>
        </div>
        <div class="tab-pane fade" id="google-map-tab">
            <div id="map-canvas" style="width:100%; height:500px;"></div>
        </div>
    </div>
</div>