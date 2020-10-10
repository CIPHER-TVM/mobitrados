<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<!-- <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet"> -->
		<link href="<?php echo base_url() ?>assets/plugins/file_upload/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>


		<link href="<?php echo base_url() ?>assets/plugins/file_upload/themes/explorer-fas/theme.css" media="all" rel="stylesheet" type="text/css"/>

		<script src="<?php echo base_url() ?>assets/plugins/file_upload/js/plugins/piexif.js" type="text/javascript"></script>
		<script src="<?php echo base_url() ?>assets/plugins/file_upload/js/plugins/sortable.js" type="text/javascript"></script>
		<script src="<?php echo base_url() ?>assets/plugins/file_upload/js/fileinput.js" type="text/javascript"></script>
		<script src="<?php echo base_url() ?>assets/plugins/file_upload/js/locales/fr.js" type="text/javascript"></script>
		<script src="<?php echo base_url() ?>assets/plugins/file_upload/js/locales/es.js" type="text/javascript"></script>
		<script src="<?php echo base_url() ?>assets/plugins/file_upload/themes/fas/theme.js" type="text/javascript"></script>
		<script src="<?php echo base_url() ?>assets/plugins/file_upload/themes/explorer-fas/theme.js" type="text/javascript"></script>
<style>
.table-hover tbody tr:hover {
	background-color: rgba(0, 0, 0, 0.8);
	color: white;
}
</style>
<main>
<?php $this->template->datatables() ?>
<nav aria-label="breadcrumb" class="main-breadcrumb">
	<ol class="breadcrumb breadcrumb-style2">
		<li class="breadcrumb-item"><a href="#">Product Management</a></li>
		<li class="breadcrumb-item active" aria-current="page">Add Product</li>
	</ol>
</nav>
<?php
 $atributes=array('id'=>'frm', 'name'=>'frm' ,'autocomplete'=>'off');
  echo form_open('',$atributes);
?>


<div class="row">
   <div class="col-md-12">
     <h5>Product Details
			 <button type="button" data-toggle="modal" data-target="#verticalModal" class="btn btn-success has-icon myBtn" id="add_tax" style=" float: right; "><i class="material-icons mr-1">playlist_add</i> Add </button>
		</h5>
		 <br>

<!-- MODAL -->

<div class="modal fade" id="verticalModal" tabindex="-1" role="dialog" aria-labelledby="scrollableModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h6 class="modal-title" id="verticalModalLabel"><strong> <u>Add Product </strong> </u></h6>
						<button class="btn btn-icon btn-sm btn-text-secondary rounded-circle" type="button" data-dismiss="modal">
							<i class="material-icons">close</i>
						</button>
					</div>
					<div class="modal-body">

						<div class="form-group">
							<div class="row">

									<div class="col-md-4">
										<label>Product Category <span class="star">*</span></label>
										<select id="catagory" name="catagory" class="form-control bs-select form-control-sm select2" title="Choose Catagory"  data-live-search="true" style="width: 100%">
									<option value="">Select Catagory</option>
									<?php LoadCombo("product_catogory","pcid","product_catogory_name",'',"where is_deleted=0 and display_status=1","order by product_catogory_name ASC"); ?>
								</select>
									</div>
									<div class="col-md-4">
										<label style="font-size : 15px">Product name <span class="star">*</span></label>
										<span class="input-icon">
											<i style="font-size : 19px" class="material-icons">shopping_cart</i>
											<input id="pro_name" name="pro_name" type="text" class="form-control form-control-sm"
												placeholder="Product name">
										</span>
									</div>

									<div class="col-md-4">
										<label>Tax % <span class="star">*</span></label>
										<select id="tax" name="tax" class="form-control bs-select form-control-sm select2" title="Choose Tax"  data-live-search="true" style="width: 100%">
											<option value="">Select Tax</option>
										<?php LoadCombo("tax_master","id","tax_value",'',"where is_deleted=0 and display_status=1","order by tax_value ASC"); ?>
								</select>
									</div>

							</div>
						</div>

<div class="form-group">
	<div class="row">
		<div class="col-md-4">
			<label style="font-size : 15px">MRP <span class="star">*</span></label>
			<span class="input-icon">
				<i style="font-size : 19px" class="material-icons">money</i>
				<input id="mrp" name="mrp" type="number" class="form-control form-control-sm" placeholder="MRP" onkeyup="set_sp(this.value)">
			</span>
		</div>

		<div class="col-md-4">
			<label style="font-size : 15px">Selling price <span class="star">*</span></label>
			<span class="input-icon">
				<i style="font-size : 19px" class="material-icons">add_box</i>
				<input id="selling_price" name="selling_price" type="number" class="form-control form-control-sm" placeholder="Selling price" >
			</span>
		</div>

		<div class="col-md-4">
			<label style="font-size : 15px">Initial Stock <span class="star">*</span></label>
			<span class="input-icon">
				<i style="font-size : 19px" class="material-icons">add_box</i>
				<input id="stock" name="stock" type="number" class="form-control form-control-sm" placeholder="Stock" value="0">
			</span>
</div>
	</div>

</div>

<div class="form-group">
	<div class="row">
		<div class="col-md-6">
							<label style="font-size : 14px" for="emailGrid">Product Info</label>
							<span class="input-icon">
								<i style="font-size : 19px" class="material-icons">description</i>
								<textarea id="product_description" name="product_description" style="padding-left: 2.2rem"
									class="form-control form-control-sm" rows="4" placeholder="Product Description"></textarea>
							</span>
						</div>

						<div class="col-md-6">
							<label style="font-size : 14px" for="emailGrid">Keywords</label>
							<span class="input-icon">
								<i style="font-size : 19px" class="material-icons">sync</i>
								<textarea id="keywords" name="keywords" style="padding-left: 2.2rem"
									class="form-control form-control-sm" rows="4" placeholder="Keywords"></textarea>
							</span>
						</div>
	</div>
</div>

<div class="form-group">
	<div class="row">
		<div class="col-md-12">
							<label style="font-size : 14px" for="emailGrid">Product Details</label>
							<span class="input-icon">
								<i style="font-size : 19px" class="material-icons">subject</i>
								<textarea id="product_Details" name="product_Details" rows="2"></textarea>
							</span>
						</div>
	</div>
</div>

<div class="form-group">
	<div class="row">
		<div class="col-md-12">
			<label>Add Product Images</label>
			<div class="file-loading">
    <input id="input-44" name="input44[]" type="file" multiple>
</div>
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
	            <button onclick="save_product(1)" type="button" class="btn btn-primary btn-xs">Save</button>
	          </div>
	        </div>
				</div>
		</div>
</div>
<!--  End of modal -->
<!-- IMAGE VIEW -->

<div class="modal fade" id="scrollableModal" tabindex="-1" role="dialog" aria-labelledby="scrollableModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable  modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header shadow-sm">
        <h5 class="modal-title" id="scrollableModalLabel">Image View</h5>
        <button class="btn btn-icon btn-sm btn-text-secondary rounded-circle" type="button" data-dismiss="modal">
          <i class="material-icons">close</i>
        </button>
      </div>
      <div class="modal-body" id="mbody">
          <table class="table table-borderd">
              <thead>
                <tr>
                  <th>Sl No</th>
                  <th>Image</th>
                  <th>Delete</th>
                </tr>
              </thead>
              <tbody id="pr_imags">

              </tbody>
          </table>
        </div>
      <div class="modal-footer border-top">
      </div>
    </div>
  </div>
</div>
<!--- END OF MODEL -->

        <div class="table-responsive">
          <table id="example" class="table table-striped table-bordered table-sm dt-responsive nowrap w-100 table-hover">
            <thead>
              <tr>
							<th>Sl No</th>
              <th>Product Name</th>
              <th>Category</th>
							<th>MRP</th>
							<th>Selling Price</th>
							<th>Current Stock</th>
							<th>Active Status</th>
							<th>Vew/Delete Photos</th>
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
<script src="<?php echo base_url(); ?>assets/plugins/ckeditor/ckeditor.js"></script>
<script>
$(document).ready(function() {
	$("#input-44").fileinput({
			 uploadUrl: '#',
			 maxFilePreviewSize: 10240,
			 showUpload: false,
			 fileActionSettings: {
					showUpload: false,},
			 allowedFileExtensions: ["jpg", "gif", "png", "jpeg"]
	 });
});
</script>

<script>
$(".select2").select2();
CKEDITOR.replace('product_Details');
	CKEDITOR.config.height = '5em';
var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
	csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

	$(document).ready(function() {

		table = $('#example').DataTable({
			//dom: '<"html5buttons" B>lTfgitp',
			'ajax': {
					url: '<?php echo admin_url() ?>manage_products/get_product_data',
					type: 'POST',
					data: {[csrfName]: csrfHash},
			},
			"columns": [
					{ "data": "no" },
					{ "data": "product_name" },
					{ "data": "product_catogory_name" },
					{ "data": "mrp" },
					{ "data": "selling_price" },
					{ "data": "available_stock"},
					{ "data": "display" },
					{ "data": "view" },
					{ "data": "edit" },
					{ "data": "delete" },

				]
	});



	$('#example').on('click', '.view_data ', function() {
	      var data = table.row($(this).parents('tr')).data();
	      id=data.id;


	      let ajaxval = {pr_id : id ,  [csrfName]: csrfHash};
	      $.ajax({
	        	url: '<?php echo admin_url() ?>manage_products/get_product_images',
	          type : 'post',
	          data : ajaxval,
	          success : function(response) {
							$("#pr_imags").html(response);
							$('#scrollableModal').modal('show');

	          }
	      });


	      //myModal
	});

$('#example tbody').on('click', '.edit', function() {
     var data = table.row($(this).parents('tr')).data();
     $("#hidid").val(data.id);

		 $("#catagory").val(data.product_catogory).trigger('change');;
		 $("#pro_name").val(data.product_name);
		 $("#tax").val(data.tax_id).trigger('change');
		 $("#mrp").val(data.mrp);
		 $("#selling_price").val(data.selling_price);
		 $("#stock").val(data.stock);
		 $("#product_description").val(data.product_dispn);
		 $("#keywords").val(data.keywords);
		 CKEDITOR.instances.product_Details.setData(data.detailed_dpn)

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
function delete_image(imgid)
{
	const confirmRemove = bootbox.confirm({
		message: 'Are you sure to delete this image permanently?',
		buttons: {
			confirm: {
				label: 'Yes',
				className: 'btn-danger'
			}
		},
		callback: result => {
			if (result) {
				let ajaxval = {
					id: imgid,
					[csrfName]: csrfHash
				};
				$.ajax({
				 url: '<?php echo admin_url() ?>manage_products/delete_product_image',
					type: 'post',
					data: ajaxval,
					success: function(response) {
						if(response==1)
						{
							$('#scrollableModal').modal('hide');
						 	$("#pr_imags").html(response);
							notify_msg("success","<h5>Success..!</h5> Image deleted successfully");
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
function save_product(crude=1)
{

	if(crude==1) msg="Data saved successfully"; else msg="Data updated successfully";

	var sp=$("#selling_price").val();
	var mrp=$("#mrp").val();
	if(mrp=="" || mrp==0){
			notify_msg("error","<h5>Error..!</h5> Please enter MRP");
			return false;
	}
	if(sp=="" || sp==0){
			notify_msg("error","<h5>Error..!</h5> Please enter Selling price");
			return false;
	}
	for (instance in CKEDITOR.instances)
	  {
	    CKEDITOR.instances[instance].updateElement();
	  }
	var form = $('#frm')[0];
	var formData = new FormData(form);
		formData.append('crude', crude);
	  $.ajax({
	   type: "POST",
	   url: '<?php echo admin_url() ?>manage_products/save_product',
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
						$("#catagory").val("");
						$("#tax").val("");
						$(".select2").trigger("change");
						CKEDITOR.instances.product_Details.setData('');
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
            url: '<?php echo admin_url() ?>manage_products/delete_product',
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
	 if(type==1) $('#crude').html('<button onclick="save_product(1)" type="button" class="btn btn-primary btn-xs">Save</button>');
	 else if(type==2)  $('#crude').html('<button onclick="save_product(2)" type="button" class="btn btn-info btn-xs">Update</button>');
}


function set_sp(mrp)
{
	//alert(mrp);
	$("#selling_price").val(mrp);
}

</script>
