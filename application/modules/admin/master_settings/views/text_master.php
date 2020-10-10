<main>
<?php $this->template->datatables() ?>
<nav aria-label="breadcrumb" class="main-breadcrumb">
	<ol class="breadcrumb breadcrumb-style2">
		<li class="breadcrumb-item"><a href="#">Master Settings</a></li>
		<li class="breadcrumb-item active" aria-current="page">Tax Master</li>
	</ol>
</nav>
<?php
 $atributes=array('id'=>'frm', 'name'=>'frm' ,'autocomplete'=>'off');
  echo form_open('',$atributes);
?>


<div class="row">
   <div class="col-md-12">
     <h5>Tax Details
			 <button type="button" data-toggle="modal" data-target="#verticalModal" class="btn btn-success has-icon myBtn" id="add_tax" style=" float: right; "><i class="material-icons mr-1">playlist_add</i> Add </button>
		</h5>
		 <br>

<!-- MODAL -->

<div class="modal fade" id="verticalModal" tabindex="-1" role="dialog" aria-labelledby="verticalModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h6 class="modal-title" id="verticalModalLabel"><strong> <u>Add Tax </strong> </u></h6>
						<button class="btn btn-icon btn-sm btn-text-secondary rounded-circle" type="button" data-dismiss="modal">
							<i class="material-icons">close</i>
						</button>
					</div>
					<div class="modal-body">
							<div class="row">
								<div class="col-md-12">
		              <label style="font-size : 15px">Tax % <span class="star">*</span></label>
		              <span class="input-icon">
		                <i style="font-size : 19px" class="material-icons">add_box</i>
		                <input id="tax" name="tax" maxlength="2" type="number" class="form-control form-control-sm" placeholder="Tax %">
		              </span>
		            </div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<br />
		              <div class="custom-control custom-switch">
		                <input type="checkbox" class="custom-control-input" id="displayStatus" checked name="display_status">
		                <label style="font-size : 14px;" class="custom-control-label" for="displayStatus">Active Status</label>
		              </div>
								</div>
							</div>
							<input type="hidden" name="hidid" id="hidid" />
					</div>
					<div class="modal-footer">
	          <button type="button" class="btn btn-light btn-xs" data-dismiss="modal">Close</button>
	          <div id="crude">
	            <button onclick="savetax(1)" type="button" class="btn btn-primary btn-xs">Save</button>
	          </div>
	        </div>
				</div>
		</div>
</div>
<!--  End of modal -->


        <div class="table-responsive">
          <table id="example" class="table table-striped table-bordered table-sm dt-responsive nowrap w-100">
            <thead>
              <tr>
							<th>Sl No</th>
              <th>Tax</th>
              <th>Status</th>
              <th>Edit</th>
              <th>Delete</th>
              </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
        </div>
   </div>
</div>

</form>

</main>
<script>
var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
	csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

	$(document).ready(function() {

		table = $('#example').DataTable({
			//dom: '<"html5buttons" B>lTfgitp',
			'ajax': {
					url: '<?php echo admin_url() ?>master_settings/get_tax_data',
					type: 'POST',
					data: {[csrfName]: csrfHash},
			},
			"columns": [
					{ "data": "no" },
					{ "data": "disp_tax" },
					{ "data": "display" },
					{ "data": "edit" },
					{ "data": "delete" },

				]
	});

$('#example tbody').on('click', '.edit', function() {
     var data = table.row($(this).parents('tr')).data();
     $("#hidid").val(data.id);
		 $("#tax").val(data.tax_value);
		 if(data.display_status==1)  $('#displayStatus').prop("checked", true); else  $('#displayStatus').prop("checked", false);
		 crude_btn_manage(2);
		 $('#verticalModal').modal('show');

	  });

		$('#example tbody').on('click', '.delete', function() {
		     var data = table.row($(this).parents('tr')).data();
		    	id=data.id;
					delete_data(id);
				});
});
function savetax(crude=1)
{
	if(crude==1) msg="Data saved successfully"; else msg="Data updated successfully";
	  $.ajax({
	   type: "POST",
	   url: '<?php echo admin_url() ?>master_settings/save_tax',
	   data: $("form").serialize() +"&crude="+crude,
	   success: function(result){
			 		if(result==1)
					{
						table.ajax.reload();
						notify_msg("success","<h5>Success..!</h5> "+msg);
					  $('#verticalModal').modal('hide');
						$('#frm').trigger("reset");
					}
					else{
						notify_msg("error","<h5>Error..!</h5>"+result);
					}

	     }
	 });
}
function delete_data(id=0)
{
	 if(id>0)
	 {
		 const confirmRemove = bootbox.confirm({
       message: 'Are you sure to delete this data permenantly?',
       buttons: {
         confirm: {
           label: 'Yes',
           className: 'btn-danger'
         }
       },
       callback: result => {
         if (result) {
           let ajaxval = {
             id: id,
             [csrfName]: csrfHash
           };
           $.ajax({
            url: '<?php echo admin_url() ?>master_settings/delete_tax',
             type: 'post',
             data: ajaxval,
             success: function(response) {
							 if(response==1)
							 {
								 table.ajax.reload();
								 notify_msg("success","<h5>Success..!</h5> Data deleted successfully");
								}
							 else{
								 notify_msg("error","<h5>Error..!</h5>"+result);
							 }
             }
           });
         }
       }
     })
	 }
}
$("#verticalModal").on('hide.bs.modal', function(){
		crude_btn_manage(1);
    	$('#frm').trigger("reset");
  });

function crude_btn_manage(type=1)
{
	 if(type==1) $('#crude').html('<button onclick="savetax(1)" type="button" class="btn btn-primary btn-xs">Save</button>');
	 else if(type==2)  $('#crude').html('<button onclick="savetax(2)" type="button" class="btn btn-info btn-xs">Update</button>');
}




</script>
