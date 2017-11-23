
<!-- Modal Views-->
<?php
foreach ($vechicles_list as $vch) {
						?>
<div class="modal fade" id="myVechicleView<?php echo $vch['v_id']; ?>" role="dialog">
	<div class="modal-dialog modal-lg">
	  <div class="modal-content">
		    <div class="modal-header">
		      <button type="button" class="close" data-dismiss="modal">&times;</button>
		      <h4 class="modal-title">Detail Vechicle of <?php echo $vch['company_name']; ?></h4>
			    </div>
			    <div class="modal-body">		
					<table>			
						<thead>
							<tr>
								<th width="35%"> Company Detail</th>
								<th width="35%"> Vechicle Detail</th>
								<th width="30%"> Map</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><?php echo $vch['company_name']; ?></td>
								<td><?php echo $vch['company_name']; ?></td>
								<td><?php echo $vch['company_name']; ?></td>
							</tr>
						</tbody>
					</table>
			    </div>
			    <div class="modal-footer">
			</div>  
<button class="tablink" onclick="openCity('London', this, 'red')" id="defaultOpen">Company</button>
<button class="tablink" onclick="openCity('Paris', this, 'green')">Vechicle</button>
<button class="tablink" onclick="openCity('Tokyo', this, 'blue')">Amenities</button>
<button class="tablink" onclick="openCity('Oslo', this, 'orange')">Location</button>
<div id="London" class="tabcontent">
  <h3>London</h3>
  <p>London is the capital city of England.</p>
</div>
<div id="Paris" class="tabcontent">
  <h3>Paris</h3>
  <p>Paris is the capital of France.</p> 
</div>
<div id="Tokyo" class="tabcontent">
  <h3>Tokyo</h3>
  <p>Tokyo is the capital of Japan.</p>
</div>
<div id="Oslo" class="tabcontent">
  <h3>Oslo</h3>
  <p>Oslo is the capital of Norway.</p>
</div>
<script>
	function openCity(cityName,elmnt,color) {
	    var i, tabcontent, tablinks;
	    tabcontent = document.getElementsByClassName("tabcontent");
	    for (i = 0; i < tabcontent.length; i++) {
	        tabcontent[i].style.display = "none";
	    }
	    tablinks = document.getElementsByClassName("tablink");
	    for (i = 0; i < tablinks.length; i++) {
	        tablinks[i].style.backgroundColor = "";
	    }
	    document.getElementById(cityName).style.display = "block";
	    elmnt.style.backgroundColor = color;

	}
	// Get the element with id="defaultOpen" and click on it
	document.getElementById("defaultOpen").click();
</script>



		</div>
    </div>
</div>

<?php } ?>

</div>
