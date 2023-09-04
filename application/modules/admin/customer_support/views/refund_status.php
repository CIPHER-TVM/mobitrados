<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<!-- <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet"> -->
<link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/date_picker/css/bootstrap-datepicker.css">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/date_picker/css/bootstrap-datepicker.min.css">
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
.box
{
    border:1px solid #CCCCCC;
}
</style>

<main>
<?php $this->template->datatables() ?>
<nav aria-label="breadcrumb" class="main-breadcrumb">
	<ol class="breadcrumb breadcrumb-style2">
		<li class="breadcrumb-item"><a href="#">Customer Support</a></li>
		<li class="breadcrumb-item active" aria-current="page">Refund Status</li>
	</ol>
</nav>
<?php
 $atributes=array('id'=>'frm', 'name'=>'frm' ,'autocomplete'=>'off');
  echo form_open('',$atributes);
?>




<div class="row">

   <div class="col-md-4">

        <div class="form-group">
          <label style="font-size : 15px">Enter Customer's Order Number / Email / Mobile No <span class="star">*</span></label>
          <span class="input-icon">
            <i style="font-size : 19px" class="material-icons">search</i>
            <input id="search_item" name="search_item"  type="text" class="form-control form-control-sm"
             onkeyup="loadOrders()"
             placeholder="Search Item, Min 3 letters">
            </span>
		</div>

        

       
        <div class="card h-100" id="new-customers">
          <div class="card-header py-1">
            <h6>Canceled Orders</h6>
            <button type="button" data-action="reload" class="btn btn-sm btn-text-success btn-icon ml-auto rounded-circle shadow-none">
              <i class="material-icons" onclick="loadOrders()">refresh</i>
            </button>
          </div>
          <ul class="list-group list-group-flush" id="customers">
          </ul>
        </div>
     


   </div>

        <div class="col-md-6">
             <div class="card h-100" id="order_details" style="margin-top:6%;display:none">
                <div class="card-header py-1">
                  <h6>Order Details</h6>
                </div>

                <div id="order_body">
             
                </div>

             </div>
            
        </div>
</div>

</form>

</main>
<script src="<?php echo base_url() ?>assets/plugins/date_picker/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/date_picker/js/bootstrap-datepicker.min.js.js"></script>
<script>
$(".select2").select2();
var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
	csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

	

$('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true
    });


  function loadOrders()
  {
      var search_item=$("#search_item").val();
      if(search_item!="")
      {
        if(search_item.length>=3)
        {
            $.ajax({
                type: "POST",
                url: '<?php echo admin_url() ?>customer_support/get_cancelled_orders',
                data: {[csrfName]: csrfHash,'search_item':search_item},
                success: function (response) {
                $("#customers").html(response);
             }
            });
        }
      }
      else{
        notify_msg("error","<h5>Please enter search term..!</h5> ");
      }
  }  

  function loadOrderDetails(ordid)
  {
    $.ajax({
            type: "POST",
            url: '<?php echo admin_url() ?>customer_support/get_refund_details',
            data: {[csrfName]: csrfHash,'ord_id':ordid},
            success: function (response) {
                $("#order_body").html(response);
                $("#order_details").show();

             }
            });
  }
  function checkRefundupdate(ordid)
  {
  //  alert(ordid);
    $.ajax({
            type: "POST",
            url: '<?php echo admin_url() ?>customer_support/update_refund_status',
            data: {[csrfName]: csrfHash,'ord_id':ordid},
            success: function (response) {
              notify_msg("success","<h5>update  checkig completed..!</h5> ");
              loadOrderDetails(ordid)
              
             }
            });
    
  }
</script>
