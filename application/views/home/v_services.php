<div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="row row-wrap" data-gutter="120">
                       <?php 
                       foreach ($services as $s) {
                        $icon=$s['service_icon'];
                        $service_name=$s['service_name'];
                        $service_desc=$s['service_desc'];
                        ?>
                        <div class="col-md-6">
                            <div class="mb30 thumb"><i class="<?php echo $icon;?> box-icon-left round box-icon-big box-icon-border animate-icon-top-to-bottom"></i>
                                <div class="thumb-caption">
                                    <h4 class="thumb-title"><?php echo $service_name; ?></h4>
                                    <p class="thumb-desc"><?php echo $service_desc; ?></p>
                                </div>
                            </div>
                        </div>

                        <?php
                       }


                        ?>                   

                    </div>
                </div>
            </div>
        </div>