<main>
<?php $this->template->datatables() ?>
<nav aria-label="breadcrumb" class="main-breadcrumb">
	<ol class="breadcrumb breadcrumb-style2">
		<li class="breadcrumb-item"><a href="#">App Management</a></li>
		<li class="breadcrumb-item active" aria-current="page">New Arrival</li>
	</ol>
</nav>
<?php
 $atributes=array('id'=>'frm', 'name'=>'frm' ,'autocomplete'=>'off');
  echo form_open('',$atributes);
?>


<div class="row">
   <div class="col-md-12">
     <h5>Newly Arrived Products
			 <button type="button" data-toggle="modal" data-target="#verticalModal" class="btn btn-success has-icon myBtn" id="add_offer" style=" float: right; "><i class="material-icons mr-1">playlist_add</i> Add </button>
		</h5>
		 <br>

<!-- MODAL -->

<div class="modal fade" id="verticalModal" tabindex="-1" role="dialog" aria-labelledby="verticalModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h6 class="modal-title" id="verticalModalLabel"><strong> <u>Add New Arrivals </strong> </u></h6>
						<button class="btn btn-icon btn-sm btn-text-secondary rounded-circle" type="button" data-dismiss="modal">
							<i class="material-icons">close</i>
						</button>
					</div>
					<div class="modal-body">

            <div class="form-group">
              <div class="row">
                <div class="col-md-12">
                  <label>Product Category <span class="star">*</span></label>
                  <select id="catagory" name="catagory" class="form-control bs-select form-control-sm select2" title="Choose Catagory"  data-live-search="true" style="width: 100%" onchange="load_product(this.value)">
                    <option value="">Select Catagory</option>
                    <?php LoadCombo("product_catogory","pcid","product_catogory_name",'',"where is_deleted=0 and display_status=1","order by product_catogory_name ASC"); ?>
                  </select>
              </div>
              </div>

            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-12">
                  <label>Select Product <span class="star">*</span></label>
                  <select id="pr_id" name="pr_id" class="form-control bs-select form-control-sm select2" title="Choose Catagory"  data-live-search="true" style="width: 100%" onchange="get_stock_data(this.value)">
                    <option value="">Select Product</option>
                    </select>
              </div>
              </div>

            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-4">
                   <label>MRP</label>
                   <input type="text" class="form-control form-control-sm"  name="mrp" id="mrp" readonly/>
                </div>
                <div class="col-md-4">
                   <label>Selling Price</label>
                   <input type="text" class="form-control form-control-sm"  name="sp" id="sp" readonly/>
                </div>
                <div class="col-md-4">
                   <label>Current Stock</label>
                   <input type="text" class="form-control form-control-sm"  name="stock" id="stock" readonly/>
                </div>
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
	            <button onclick="save_offer(2)" type="button" class="btn btn-primary btn-xs">Save</button>
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
							<th>Product Name</th>
              <th>Status</th>
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
					url: '<?php echo admin_url() ?>manage_app/get_offers/2',
					type: 'POST',
					data: {[csrfName]: csrfHash},
			},
			"columns": [
					{ "data": "no" },
					{ "data": "product_name" },
					{ "data": "disp" },
					{ "data": "delete" },

				]
	});

//tg
$('#example tbody').on('click', '.tg', function() {
     var data = table.row($(this).parents('tr')).data();
      id=data.id;
      dstatus=data.display_status;
      if(dstatus==1) { dstatus=0 } else  { dstatus=1; }
      chnage_status(id,dstatus);
    });

		$('#example tbody').on('click', '.delete', function() {
		     var data = table.row($(this).parents('tr')).data();
		    	id=data.id;
					delete_data(id);
				});
});
function save_offer(crude=2)
{
 msg="Data saved successfully";
  var form = $('#frm')[0];
  var formData = new FormData(form);
  formData.append('crude', crude);
	  $.ajax({
	   type: "POST",
	   url: '<?php echo admin_url() ?>manage_app/save_product_display',
     data: formData,
		 processData: false,
		 contentType: false,
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
function chnage_status(id,dstatus)
{
  if(dstatus==1) msg="status activated successfully"; else msg="status deactivated successfully";
  let ajaxval = {
    id: id,
    dstatus:dstatus,
    [csrfName]: csrfHash
  };
  $.ajax({
   url: '<?php echo admin_url() ?>manage_app/change_offer_status',
    type: 'post',
    data: ajaxval,
    success: function(response) {
      if(response==1)
      {
        table.ajax.reload();
        notify_msg("success","<h5>Success..!</h5> "+msg);
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
       message: 'Are you sure to delete this data permanently?',
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
            url: '<?php echo admin_url() ?>manage_app/delete_product_display',
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
	 if(type==1) $('#crude').html('<button onclick="save_offer(2)" type="button" class="btn btn-primary btn-xs">Save</button>');
	 else if(type==2)  $('#crude').html('<button onclick="save_offer(2)" type="button" class="btn btn-info btn-xs">Update</button>');
}

function load_product(cat_id)
{
  let ajaxval = {
    cat_id: cat_id,
    [csrfName]: csrfHash
  };
  $.ajax({
    url: '<?php echo admin_url() ?>manage_products/get_product_by_category',
    type: 'post',
    data: ajaxval,
    success: function(response) {
      //alert(response);
      $("#pr_id").html(response);
    }
  });
}

function get_stock_data(pid)
{

    let ajaxval = {
      pid: pid,
      [csrfName]: csrfHash
    };
    $.ajax({
      url: '<?php echo admin_url() ?>manage_app/get_product_stock',
      type: 'post',
      data: ajaxval,
      success: function(response) {
        var res=response.split("~");
        $("#mrp").val(res['1']);
        $("#sp").val(res['2']);
        $("#stock").val(res['0']);
      }
    });
}
</script>
