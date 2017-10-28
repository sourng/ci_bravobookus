<div class="container">
            <div class="row">
                <div class="col-md-4">
                    <img class="pp-img" src="<?php echo site_url(); ?>/public/img/paypal.png" alt="Image Alternative text" title="Image Title" />
                    <p>Important: You will be redirected to PayPal's website to securely complete your payment.</p><a class="btn btn-primary">Checkout via Paypal</a>	
                </div>

                <div class="col-md-4">
                    <h4>Pay via Credit/Debit Card</h4>
                    <ul class="card-select">
                        <li>
                            <img class="card-select-img" src="<?php echo site_url(); ?>/public/img/payment/visa-curved-64px.png" alt="Image Alternative text" title="Image Title" />
                            <div class="card-select-data">
                                <p class="card-select-number">xxxx xxxx xxxx 1456</p>
                                <input class="form-control card-select-cvc" type="text" placeholder="CVC" />
                            </div>
                        </li>
                        <li>
                            <img class="card-select-img" src="<?php echo site_url(); ?>/public/img/payment/maestro-curved-64px.png" alt="Image Alternative text" title="Image Title" />
                            <div class="card-select-data">
                                <p class="card-select-number">xxxx xxxx xxxx 6698</p>
                                <input class="form-control card-select-cvc" type="text" placeholder="CVC" />
                            </div>
                        </li>
                    </ul>
                    <div class="gap gap-small"></div>
                    <h4>Pay with new Card</h4>
                    <form class="cc-form">
                        <div class="clearfix">
                            <div class="form-group form-group-cc-number">
                                <label>Card Number</label>
                                <input class="form-control" placeholder="xxxx xxxx xxxx xxxx" type="text" /><span class="cc-card-icon"></span>
                            </div>
                            <div class="form-group form-group-cc-cvc">
                                <label>CVC</label>
                                <input class="form-control" placeholder="xxxx" type="text" />
                            </div>
                        </div>
                        <div class="clearfix">
                            <div class="form-group form-group-cc-name">
                                <label>Cardholder Name</label>
                                <input class="form-control" type="text" />
                            </div>
                            <div class="form-group form-group-cc-date">
                                <label>Valid Thru</label>
                                <input class="form-control" placeholder="mm/yy" type="text" />
                            </div>
                        </div>
                        <div class="checkbox checkbox-small">
                            <label>
                                <input class="i-check" type="checkbox" checked/>Add to My Cards</label>
                        </div>
                        <input class="btn btn-primary" type="submit" value="Proceed Payment" />
                    </form>
                </div>

                <?php 
                        if(isset($cars_cost)){
                            $this->load->view($cars_cost);
                        }
                    ?>   
            </div>
            <div class="gap"></div>
        </div>