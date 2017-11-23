<script>
      var save_method; //for save method string
      var table;

      function add_vechicle(){
        save_method = 'add';
        $('#frm-vechicle')[0].reset(); // reset form on modals
        $('#VechicleAddModal').modal('show'); // show bootstrap modal
      }

      function edit_vechicle(id){
        save_method = 'update';
        $('#frm-vechicle')[0].reset(); // reset form on modals   
        //Ajax Load data from ajax
          $.ajax({
            url : "<?php echo site_url('Admin_dashboard/ajax_edit')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            { 
                $('[name="v_id"]').val(data.v_id);
                $('[name="code"]').val(data.code);
                $('[name="vehicle_name"]').val(data.vehicle_name);
                $('[name="vehicle_type"]').val(data.vehicle_type);
                $('[name="drivers"]').val(data.drivers); 
                $('[name="amenities[]"]').val(data.amenities); 
                $('[name="status"]').val(data.status); 
                $('#VechicleAddModal').modal('show'); // show bootstrap modal when complete 
                $('.modal-title').text('Edit Vechicle'); // Set title to Bootstrap modal title
     
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
      }     

      function save(){
        var url;
        if(save_method == 'add')
        {
            url = "<?php echo site_url('Admin_dashboard/vechile_add')?>";
        }
        else
        {
          url = "<?php echo site_url('Admin_dashboard/vechile_update')?>";
        }
   
         // ajax adding data to database
            $.ajax({
              url : url,
              type: "POST",
              data: $('#frm-vechicle').serialize(),
              dataType: "JSON",
              success: function(data)
              {
                 //if success close modal and reload ajax table
                 $('#VechicleAddModal').modal('hide');
                location.reload();// for reload a page
              },
              error: function (jqXHR, textStatus, errorThrown)
              {
                  alert('Error adding / update data');
              }
          });
      }
   
      function delete_vechicle(id){
        if(confirm('Are you sure delete this data?'))
        {
          // ajax delete data from database
            $.ajax({
              url : "<?php echo site_url('Admin_dashboard/vechile_delete')?>/"+id,
              type: "POST",
              dataType: "JSON",
              success: function(data)
              {
                 
                 location.reload();
              },
              error: function (jqXHR, textStatus, errorThrown)
              {
                  alert('Error deleting data');
              }
          });
   
        }
      }

</script>