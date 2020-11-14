<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<!-- <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet"> -->
<style>
.table-hover tbody tr:hover {
	background-color: rgba(0, 0, 0, 0.8);
	color: white;
}
.left-col {
    float: left;
    width: 25%;
}

.center-col {
    float: left;
    width: 50%;
}

.right-col {
    float: left;
    width: 25%;
}
</style>

<main>
<?php $this->template->datatables() ?>
<nav aria-label="breadcrumb" class="main-breadcrumb">
	<ol class="breadcrumb breadcrumb-style2">
		<li class="breadcrumb-item"><a href="#">Report</a></li>
		<li class="breadcrumb-item active" aria-current="page">Current Stock</li>
	</ol>
</nav>
<?php
 $atributes=array('id'=>'frm', 'name'=>'frm' ,'autocomplete'=>'off');
  echo form_open('',$atributes);
?>

<div class="row">
  <div class="col-md-2">
    <label>Category</label>
    <select class="form-control form-control-sm select2" id="category">
        <option value="0">Select All</option>
        <?php LoadCombo("product_catogory","pcid","product_catogory_name",'',"where is_deleted=0 and display_status=1","order by product_catogory_name ASC"); ?>
    </select>
  </div>
  <div class="col-md-2">
      <label>Product Name</label>
      <input type="text" class="form-control form-control-sm" id="product_name" />
  </div>
  <div class="col-md-2">
      <label>Status</label>
      <select class="form-control form-control-sm select2" id="status">
          <option value="">Select All</option>
          <option value="1">Active</option>
          <option value="0">Inactive</option>
      </select>
  </div>
  <div class="col-md-2">
  <br />   <input type="button" class="btn btn-success" style="padding: 6px 11px 4px 12px;"  value="SHOW" onclick="generatetable()"/>
  </div>

</div>

<br />

<div class="row">
   <div class="col-md-12">
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
			//dom: 'BlTfgitp',
    //  dom: 'Bfrtipl',
    dom: "Bfr<'row'<'col-sm-12'tr>>t" +
         "<'row'<'col-sm-2'l><'col-sm-2'i><'col-sm-8'p>>",
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
			'ajax': {
					url: '<?php echo admin_url() ?>reports/get_current_stock',
					type: 'POST',
          "data": function(d) {
              d.csrf_cipher_mobtrads_name=csrfHash;
              d.category=$("#category").val();
              d.product_name=$("#product_name").val();
              d.status=$("#status").val();
              i=1;
          }
			},
			"columns": [
        {
          "data": "pr_id",render: function (data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;}
        },
					{ "data": "product_name" },
					{ "data": "product_catogory_name" },
					{ "data": "mrp" },
					{ "data": "selling_price" },
					{ "data": "available_stock"},
					{
            "data": "display_status",render: function (data, type, row, meta) {
                  if(data==1) return "Active"; else return "Inactive";
                }
          },
				]
	});


});
function generatetable()
{
    table.ajax.reload();
}

</script>
