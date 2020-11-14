  <main>
    <?php $this->template->datatables() ?>
    <?php
     $atributes=array('id'=>'frm', 'name'=>'frm' ,'autocomplete'=>'off');
      echo form_open('',$atributes);
    ?>
    <style>

    <style>
      .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.8);
        color: white;
      }
      .card-active
      {
        background-color: #dadada;
      }
      .btn-pading
      {
        padding-top:1%;
        padding-left:1%;
        padding-right:1%;
        padding-bottom:1%;
      }
      #pr_child_data2 tr:hover
      {
        background-color: rgba(0, 0, 0, 0.8);
        color: white;
      }

    </style>
    </style>
<input type="hidden" id="lstype" value="0" />
<!--ORDER DETAILS----------------------------->
<div class="modal fade" id="scrollableModal2" tabindex="-1" role="dialog" aria-labelledby="scrollableModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable  modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header shadow-sm">
        <h5 class="modal-title" id="scrollableModalLabel">Order Verification</h5>
        <button class="btn btn-icon btn-sm btn-text-secondary rounded-circle" type="button" data-dismiss="modal">
          <i class="material-icons">close</i>
        </button>
      </div>
      <div class="modal-body" id="mbody">
          <table class="table table-borderd">
              <thead>
                <tr>
                  <th>Sl No</th>
                  <th>Product</th>
                  <th>qty</th>
                  <th align="right">Unit Price</th>
                  <th align="right">Total</th>
                </tr>
              </thead>
              <tbody id="pr_child_data2">

              </tbody>
          </table>
        </div>
      <div class="modal-footer border-top">
      </div>
    </div>
  </div>
</div>
<!------------------------------------------------->
    <div class="border rounded mb-3">
          <div class="row no-gutters">
            <div class="col-6 col-lg-3">
              <div class="card border-0" onclick="loadtb(0)">
                <div class="card-body card-active" id="body_orders">
                  <h6 class="card-title">New Orders</h6>
                  <div class="d-flex align-items-center font-number mb-1">
                    <i class="material-icons mr-2">shopping_basket</i>
                    <h3 class="mb-0 mr-2" id="orders">Loading...</h3>
                    <span class="small text-success"><i class="material-icons font-size-base align-bottom">keyboard_arrow_up</i></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-6 col-lg-3">
              <div class="card border-0" onclick="loadtb(1)">
                <div class="card-body" id="body_paking">
                  <h6 class="card-title">Packing Pending</h6>
                  <div class="d-flex align-items-center font-number mb-1">
                    <i class="material-icons mr-2">card_travel</i>
                    <h3 class="mb-0 mr-2" id="paking">Loading...</h3>
                    <span class="small text-danger"><i class="material-icons font-size-base align-bottom">keyboard_arrow_up</i></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-6 col-lg-3">
              <div class="card border-0" onclick="loadtb(2)">
                <div class="card-body" id="body_ship">
                  <h6 class="card-title">Shipping Pending</h6>
                  <div class="d-flex align-items-center font-number mb-1">
                    <i class="material-icons mr-2">commute</i>
                    <h3 class="mb-0 mr-2" id="ship">Loading...</h3>
                    <span class="small text-danger"><i class="material-icons font-size-base align-bottom">keyboard_arrow_up</i></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-6 col-lg-3">
              <div class="card border-0" onclick="loadtb(3)">
                <div class="card-body" id="body_delivery">
                  <h6 class="card-title">Delivery Pending</h6>
                  <div class="d-flex align-items-center font-number mb-1">
                    <i class="material-icons mr-2">card_giftcard</i>
                    <h3 class="mb-0 mr-2" id="delivery">Loading...</h3>
                    <span class="small text-success"><i class="material-icons font-size-base align-bottom">keyboard_arrow_up</i></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

  <div class="tabel-responsive">
      <table id="example" class="table table-hover table-striped table-bordered table-sm dt-responsive nowrap w-100">
        <!-- Filter columns -->
        <thead>
          <tr>
            <th>View</th>
            <th>Action</th>
            <th>Order Total</th>
            <th>Payment</th>
            <th>Order Number</th>
            <th>Order date</th>
            <th>Customer Name</th>
            <th>Mobile</th>
            <th>Email</th>
            <th>Deliver Pincode</th>
            <!-- <th>View Order Details</th> -->

          </tr>
        </thead>
        <!-- /Filter columns -->

        <tbody>

          </tbody>
      </table>
    </div>


  </main>
<script>
var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

$(document).ready(function(){
fillcards();
});

view='<a href="javascript:void(0)" class="btn btn-text-secondary btn-icon view_data rounded-circle"><i class="material-icons" stile="color:blue;font-size:12px;">visibility</i></a>';
table = $('#example').DataTable({
      //dom: '<"html5buttons" B>lTfgitp',
      'ajax': {
          url: '<?php echo admin_url() ?>order_management/get_orders',
          type: 'POST',
          "data": function(d) {
              d.csrf_cipher_mobtrads_name=csrfHash;
              d.lstype=$("#lstype").val();
              i=1;
          }
      },
      "columns": [
          {
            "data" : ""
          },
          {
            "data": "order_status",
            "render": function(data, type, full, meta)
            {
                    if(data==0){
                      var btn='<button type="button" class="btn btn-success btn-pading mark-confirm" value="1">Confirm Order</button>';
                    }
                    if(data==1){
                      var btn='<button type="button" class="btn btn-warning btn-pading mark-packed" value="2">Mark as Packed</button>';
                    }
                    else if(data==2){
                      var btn='<button type="button" class="btn btn-danger btn-pading mark-shipped" value="3">Mark as Shipped</button>';
                    }
                    else if(data==3){
                      var btn='<button type="button" class="btn btn-success btn-pading mark-deliverd" value="4">Mark as Deliverd</button>';
                    }
                    return btn;
            }

         },
          { "data": 'order_total'},
          {
            "data" : "payment_type",
              "render": function(data, type, full, meta)
              {
                if(data==1) return "<b>COD</b>"; else return "Online";
              }
          },
          { "data": "order_number" },
          { "data": "order_date" },
          { "data": "name" },
          { "data": "mobile_number" },
          { "data": "email" },
          { "data": "pincode" },
          // { "data": "" },

        ],
        "columnDefs": [ {
             "targets": 0,
             "data": null,
             "defaultContent": view
         } ],
  });

  $('#example').on('click', '.mark-confirm, .mark-packed, .mark-shipped, .mark-deliverd', function() {

    var data = table.row($(this).parents('tr')).data();
    order_id=data.order_master_id;
    paytype=data.payment_type;

    value=$(this).val();
    msg="Are you sure to change the status of this order?";
    if(value==4 && paytype==1)
    {
      msg=msg+" Since the order is cash on delivery, confirming will mark payment success ";
    }

 		 const confirmRemove = bootbox.confirm({
        message: msg,
        buttons: {
          confirm: {
            label: 'Yes',
            className: 'btn-warning'
          }
        },
        callback: result => {
          if (result) {
              ajaxval = {order_id : order_id, next_order_status:value, [csrfName]: csrfHash};
              $.ajax({
                  url: '<?php echo admin_url() ?>order_management/update_order_status',
                  type : 'post',
                  data : ajaxval,
                  success : function(response) {
                    notify_msg("success","<h5>Status changed successfully..!</h5> ");
                    table.ajax.reload();
                    fillcards();
                  }
              });
          }
        }
      })

  });

  $('#example').on('click', '.view_data ', function() {
        var data = table.row($(this).parents('tr')).data();
        order_id=data.order_master_id;
        console.log(order_id);
        let ajaxval = {order_id : order_id,[csrfName]: csrfHash};
        $.ajax({
            url: '<?php echo admin_url() ?>order_management/get_order_details_child',
            type : 'post',
            data : ajaxval,
            success : function(response) {
              $("#pr_child_data2").html(response);
              $('#scrollableModal2').modal('show');
            }
        });


        //myModal
  });



function fillcards()
{
  let ajaxval = {
    [csrfName]: csrfHash
  };

  $.ajax({
    type: "POST",
    url: '<?php echo admin_url() ?>order_management/counts_of_pendings',
    data:ajaxval,
    success: function(result){
        var obj = JSON.parse(result);
        $("#orders").html(obj.orders_confirm_pending);
        $("#paking").html(obj.orders_packing_pending);
        $("#ship").html(obj.orders_shipping_pending);
        $("#delivery").html(obj.orders_delivery_pending);
      }
  });
}

function loadtb(val)
{
  if(val==0)
  {
    $("#body_orders").addClass( "card-active" );
    $("#body_paking").removeClass( "card-active");
    $("#body_ship").removeClass( "card-active");
    $("#body_delivery").removeClass( "card-active");
  }
  else if(val==1)
  {
    $("#body_paking").addClass( "card-active");
    $("#body_orders").removeClass( "card-active" );
    $("#body_ship").removeClass( "card-active");
    $("#body_delivery").removeClass( "card-active");
  }
  else if(val==2)
  {
    $("#body_ship").addClass( "card-active");
    $("#body_paking").removeClass( "card-active");
    $("#body_orders").removeClass( "card-active" );
    $("#body_delivery").removeClass( "card-active");
  }
  else if(val==3)
  {
    $("#body_ship").removeClass( "card-active");
    $("#body_paking").removeClass( "card-active");
    $("#body_orders").removeClass( "card-active" );
    $("#body_delivery").addClass( "card-active");
  }
  else {
    $("#body_orders").removeClass( "card-active" );
    $("#body_paking").removeClass( "card-active");
  }
  $("#lstype").val(val);
  table.ajax.reload();

}
</script>
