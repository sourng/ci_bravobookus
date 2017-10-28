<div class="col-md-9">
                    <div class="booking-item-dates-change">
                        <form>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-daterange" data-date-format="MM d, D">
                                        <div class="row">
                                            <?php
                                                   $this->load->view('hotels_layout/v_check_in_out');
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group form-group-select-plus">
                                        <label>Adults</label>
                                        <div class="btn-group btn-group-select-num" data-toggle="buttons">
                                            <label class="btn btn-primary active">
                                                <input type="radio" name="options" />1</label>
                                            <label class="btn btn-primary">
                                                <input type="radio" name="options" />2</label>
                                            <label class="btn btn-primary">
                                                <input type="radio" name="options" />3</label>
                                            <label class="btn btn-primary">
                                                <input type="radio" name="options" />3+</label>
                                        </div>
                                        <select class="form-control hidden">
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option selected="selected">4</option>
                                            <option>5</option>
                                            <option>6</option>
                                            <option>7</option>
                                            <option>8</option>
                                            <option>9</option>
                                            <option>10</option>
                                            <option>11</option>
                                            <option>12</option>
                                            <option>13</option>
                                            <option>14</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group form-group-select-plus">
                                        <label>Children</label>
                                        <div class="btn-group btn-group-select-num" data-toggle="buttons">
                                            <label class="btn btn-primary active">
                                                <input type="radio" name="options" />0</label>
                                            <label class="btn btn-primary">
                                                <input type="radio" name="options" />1</label>
                                            <label class="btn btn-primary">
                                                <input type="radio" name="options" />2</label>
                                            <label class="btn btn-primary">
                                                <input type="radio" name="options" />2+</label>
                                        </div>
                                        <select class="form-control hidden">
                                            <option>0</option>
                                            <option>1</option>
                                            <option>2</option>
                                            <option selected="selected">3</option>
                                            <option>4</option>
                                            <option>5</option>
                                            <option>6</option>
                                            <option>7</option>
                                            <option>8</option>
                                            <option>9</option>
                                            <option>10</option>
                                            <option>11</option>
                                            <option>12</option>
                                            <option>13</option>
                                            <option>14</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group form-group-select-plus">
                                        <label>Rooms</label>
                                        <div class="btn-group btn-group-select-num" data-toggle="buttons">
                                            <label class="btn btn-primary active">
                                                <input type="radio" name="options" />1</label>
                                            <label class="btn btn-primary">
                                                <input type="radio" name="options" />2</label>
                                            <label class="btn btn-primary">
                                                <input type="radio" name="options" />3</label>
                                            <label class="btn btn-primary">
                                                <input type="radio" name="options" />3+</label>
                                        </div>
                                        <select class="form-control hidden">
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option selected="selected">4</option>
                                            <option>5</option>
                                            <option>6</option>
                                            <option>7</option>
                                            <option>8</option>
                                            <option>9</option>
                                            <option>10</option>
                                            <option>11</option>
                                            <option>12</option>
                                            <option>13</option>
                                            <option>14</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                        </form>
                    </div>
                    <div class="gap gap-small"></div>
                    <ul class="booking-list">
                      
                      <?php 
                      foreach($available_rooms as  $ava) {
                         ?>
                         <li>
                                <a class="booking-item" href="<?php echo site_url(); ?>hotels.html/<?php echo $ava['hotel_id']; ?>">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <img src="<?php echo base_url();?>uploads/hotels/<?php echo $ava['hr_image'] ?>" alt="Image Alternative text" title="The pool" />
                                        </div>
                                        <div class="col-md-6">
                                            <h5 class="booking-item-title"><?php echo $ava['Room Name'] ?></h5>
                                            <p class="text-small">Metus eu eros ipsum mattis vehicula nisl egestas nec ultrices varius semper laoreet</p>
                                            <ul class="booking-item-features booking-item-features-sign clearfix">
                                                <li rel="tooltip" data-placement="top" title="Adults Occupancy"><i class="fa fa-male"></i><span class="booking-item-feature-sign">x 2</span>
                                                </li>
                                                <li rel="tooltip" data-placement="top" title="Beds"><i class="im im-bed"></i><span class="booking-item-feature-sign">x 1</span>
                                                </li>
                                                <li rel="tooltip" data-placement="top" title="Room footage (square feet)"><i class="im im-width"></i><span class="booking-item-feature-sign">580</span>
                                                </li>
                                            </ul>
                                            <ul class="booking-item-features booking-item-features-small clearfix">
                                                <li rel="tooltip" data-placement="top" title="Mini Bar"><i class="im im-bar"></i>
                                                </li>
                                                <li rel="tooltip" data-placement="top" title="Bathtub"><i class="im im-bathtub"></i>
                                                </li>
                                                <li rel="tooltip" data-placement="top" title="Kitchen"><i class="im im-kitchen"></i>
                                                </li>
                                                <li rel="tooltip" data-placement="top" title="Patio"><i class="im im-patio"></i>
                                                </li>
                                                <li rel="tooltip" data-placement="top" title="Soundproof"><i class="im im-soundproof"></i>
                                                </li>
                                                <li rel="tooltip" data-placement="top" title="SPA tub"><i class="im im-spa"></i>
                                                </li>
                                                <li rel="tooltip" data-placement="top" title="Terrace"><i class="im im-terrace"></i>
                                                </li>
                                                <li rel="tooltip" data-placement="top" title="Washing Machine"><i class="im im-washing-machine"></i>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-md-3"><span class="booking-item-price">$<?php echo $ava['room_sell'] ?></span><span>/night</span><span class="btn btn-primary">Book</span>
                                        </div>
                                    </div>
                                </a>
                            </li>


                         <?php
                      }


                      ?>


                    </ul>
                </div>
                
                <div class="col-md-3">
                    <h4>About the Hotel</h4>
                    <p class="mb30">Torquent egestas pharetra est cum tellus ultrices aliquam nam gravida hendrerit primis class egestas primis porta egestas non eleifend risus</p>
                    <h4>Hotel Facilities</h4>
                    <ul class="booking-item-features booking-item-features-expand mb30 clearfix">

                        <?php 
                        echo $showfacil[0]['field2'];
                        ?>




                        
                    </ul>
                </div>
