    <div class="container">

   

                <div class="row row-wrap">
                    <div class="col-md-3">
                        <a class="logo" href="<?php echo site_url(); ?>">
                            <img src="<?php echo base_url(); ?>public/img/<?php echo $settings[0]['logo']; ?>" alt="<?php echo $settings[0]['site_name']; ?>" title="<?php echo $settings[0]['site_name']; ?>" />
                        </a>
                        <p class="mb20"><?php echo $settings[0]['note']; ?></p>
                        <ul class="list list-horizontal list-space">
                            <li>
                                <a class="fa fa-facebook box-icon-normal round animate-icon-bottom-to-top" href="../<?php echo $settings[0]['facebook']; ?>"></a>
                            </li>
                            <li>
                                <a class="fa fa-twitter box-icon-normal round animate-icon-bottom-to-top" href="#"></a>
                            </li>
                            <li>
                                <a class="fa fa-google-plus box-icon-normal round animate-icon-bottom-to-top" href="#"></a>
                            </li>
                            <li>
                                <a class="fa fa-linkedin box-icon-normal round animate-icon-bottom-to-top" href="#"></a>
                            </li>
                            <li>
                                <a class="fa fa-pinterest box-icon-normal round animate-icon-bottom-to-top" href="#"></a>
                            </li>
                        </ul>
                    </div>

                    <div class="col-md-3">
                        <h4>Newsletter</h4>
                        <form>
                            <label><?php echo $settings[0]['email']; ?></label>
                            <input type="text" class="form-control">
                            <p class="mt5"><small>*We Never Send Spam</small>
                            </p>
                            <input type="submit" class="btn btn-primary" value="Subscribe">
                        </form>
                    </div>
                    <div class="col-md-2">
                        <ul class="list list-footer">
                            <li><a href="#">About US</a>
                            </li>
                            <li><a href="#">Press Centre</a>
                            </li>
                            <li><a href="#">Best Price Guarantee</a>
                            </li>
                            <li><a href="#">Travel News</a>
                            </li>
                            <li><a href="#">Jobs</a>
                            </li>
                            <li><a href="#">Privacy Policy</a>
                            </li>
                            <li><a href="#">Terms of Use</a>
                            </li>
                            <li><a href="#">Feedback</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h4>Have Questions?</h4>
                        <h4 class="text-color"><?php echo $settings[0]['phone']; ?></h4>
                        <h4><a href="#" class="text-color"><?php echo $settings[0]['email']; ?></a></h4>
                        <p><?php echo $settings[0]['address']; ?></p>
                    </div>

                </div>
            </div>
