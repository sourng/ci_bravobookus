        <div class="gap"></div>

        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <?php 
                        if(isset($paypal)){
                            $this->load->view($paypal);
                        }
                    ?>
                </div>

                <div class="col-md-4">
                    <h4>Pay via Credit/Debit Card</h4>
                    <?php
                        if(isset($registered_middle)){
                            $this->load->view($registered_middle);
                        }
                    ?>
                    <div class="gap gap-small"></div>
                    <h4>Pay with new Card</h4>
                    <?php 
                        if(isset($payment_form)){
                            $this->load->view($payment_form);
                        }
                    ?>
                </div>

                <div class="col-md-4">
                    <?php
                        if(isset($payment_right)){
                            $this->load->view($payment_right);
                        }
                    ?>
                </div>
            </div>
            <div class="gap"></div>
        </div>


