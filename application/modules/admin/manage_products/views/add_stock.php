<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
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
		<li class="breadcrumb-item active" aria-current="page">Add STcok</li>
	</ol>
</nav>
<?php
 $atributes=array('id'=>'frm', 'name'=>'frm' ,'autocomplete'=>'off');
  echo form_open('',$atributes);
?>


<div class="row">
   <div class="col-md-12">


<!-- MODAL -->

<div class="row">
  <div class="col-md-12">

    <div class="row">
      	<div class="col-md-3">
          <label>Product Category <span class="star">*</span></label>
          <select id="catagory" name="catagory" class="form-control bs-select form-control-sm select2" title="Choose Catagory"  data-live-search="true" style="width: 100%" onchange="load_product(this.value)">
            <option value="">Select Catagory</option>
            <?php LoadCombo("product_catogory","pcid","product_catogory_name",'',"where is_deleted=0 and display_status=1","order by product_catogory_name ASC"); ?>
          </select>
      </div>

      <div class="col-md-3">
        <label>Select Product <span class="star">*</span></label>
        <select id="pr_id" name="pr_id" class="form-control bs-select form-control-sm select2" title="Choose Catagory"  data-live-search="true" style="width: 100%" onchange="get_stock_data(this.value)">
          <option value="">Select Product</option>
          </select>
    </div>

    <!-- <div class="col-md-3">
      <br />
      <button type="button" class="btn btn-primary" onclick="search()">Search</button>
    </div> -->

    </div>
    <hr />
    <div class="row" id="c_stock" style="display: none">
       <div class="col-md-3">
         <label>Current Stock</label>
         <input type="text" readonly name="curent_stock"  id="curent_stock" class="form-control form-control-sm"/>
       </div>
       <div class="col-md-3">
         <label>Add Qty</label>
         <input type="number"  name="new_qty"  id="new_qty" class="form-control form-control-sm"/>
       </div>
       <div class="col-md-3">
         <br />
         <button type="button" class="btn btn-success" onclick="savestock()">Save Stock</button>
       </div>

    </div>

  </div>
</div>

<!-- IMAGE VIEW -->
<br />
<h5>Added Stock</h5>
<br>

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
							<th>Added Date</th>
							<th>Added Qty</th>
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
$(".select2").select2();
var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
	csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

	$(document).ready(function() {

		table = $('#example').DataTable({
			//dom: '<"html5buttons" B>lTfgitp',
			'ajax': {
					url: '<?php echo admin_url() ?>manage_products/get_stock_history',
					type: 'POST',
				//	data: {[csrfName]: csrfHash ,  pr_id:$("#pr_id").val()},
				"data": function(d) {
						d.pr_id= $('#pr_id').val();
						d.<?php echo $this->security->get_csrf_token_name(); ?>=csrfHash;

					}
			},
			"columns": [
					{ "data": "no" },
					{ "data": "product_name" },
					{ "data": "product_catogory_name" },
					{ "data": "stock_date" },
					{ "data": "stock" },
					{ "data": "delete" },
]
	});

	$('#example tbody').on('click', '.delete', function() {
			 var data = table.row($(this).parents('tr')).data();
				id=data.stock_id;
				stock=data.stock;
				product_id=data.product_id;
				delete_data(id,stock,product_id);
			});


});
function search()
{
   table.ajax.reload();
}

function savestock(crude=1)
{

	if(crude==1) msg="Stock added successfully";

	var new_qty=$("#new_qty").val();
	var pid=$("#pr_id").val();
	if(new_qty=="" || new_qty==0){
			notify_msg("error","<h5>Error..!</h5> Please enter qty");
			return false;
	}
	if(pid=="" || pid==0){
			notify_msg("error","<h5>Error..!</h5> You must select a product");
			return false;
	}
  let ajaxval = {
    pid: pid,
    new_qty:new_qty,
    [csrfName]: csrfHash
  };
	  $.ajax({
	   type: "POST",
	   url: '<?php echo admin_url() ?>manage_products/save_product_stock',
	   data: ajaxval,
		 success: function(result){
			 		if(result==1)
					{
						table.ajax.reload();
	          notify_msg("success","<h5>Success..!</h5> Stock added successfully");
          //  $("#curent_stock").val("");
            $("#new_qty").val("");
            get_stock_data(pid)
	          }
					else{
						notify_msg("error","<h5>Error..!</h5>"+result);
					}

	     }
	 });
}
$("#verticalModal").on('hide.bs.modal', function(){
		crude_btn_manage(1);
    	$('#frm').trigger("reset");
  });



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
      url: '<?php echo admin_url() ?>manage_products/get_product_stock',
      type: 'post',
      data: ajaxval,
      success: function(response) {
        //alert(response);
        $("#curent_stock").val(response);
        $("#c_stock").show();
				search();
      }
    });
}
function delete_data(id=0,stock=0,product_id=0)
{
	 if(id>0)
	 {
		 const confirmRemove = bootbox.confirm({
       message: 'Are you sure to delete this data permenantly? Deletion will affect current stock!!!',
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
						 stock:stock,
						 product_id:product_id,
             [csrfName]: csrfHash
           };
           $.ajax({
            url: '<?php echo admin_url() ?>manage_products/delete_stock',
             type: 'post',
             data: ajaxval,
             success: function(response) {
							 if(response==1)
							 {

								 get_stock_data(product_id)
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
</script>
