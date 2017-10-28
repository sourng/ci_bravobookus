<?php 
if(isset($destination)){
	$dest=$destination;
}else{
	$dest="";
} ?>
<div class="form-group form-group-icon-left"><i class="fa fa-map-marker input-icon input-icon-hightlight"></i>
    <label>Where You want to stay?</label>
    <!-- <input class="typeahead form-control" placeholder="City, Hotel Name or U.S. Zip Code" type="text" id="destination" class="field-input" /> -->
    <!-- <input type="text" id="destination" class="field-input"> -->
     <input class="typeahead form-control" placeholder="City, Hotel Name or U.S. Zip Code" type="text" id="keywords" name="destination" id="destination" class="field-input" onkeyup="searchFilter()" value="<?php echo $dest; ?>">

</div>