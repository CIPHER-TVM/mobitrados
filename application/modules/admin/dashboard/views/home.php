<?php
 $atributes=array('id'=>'frm', 'name'=>'frm' ,'autocomplete'=>'off');
  echo form_open('',$atributes);
?>
  <main>

    <!-- Conversion Rate | Unique Purchases | Avg. Order Value | Order Quantity -->
    <div class="border rounded mb-3">
      <div class="row no-gutters">
        <div class="col-6 col-lg-3">
          <div class="card border-0">
            <div class="card-body"  style="background-color: #7579e7;color:#FFF">
              <h6 class="card-title">New Orders</h6>
              <div class="d-flex align-items-center font-number mb-1">
                <i class="material-icons mr-2">shopping_basket</i>
                <h3 class="mb-0 mr-2"><?= $orders_verify_pending ?></h3>

              </div>
              </div>
          </div>
        </div>
        <div class="col-6 col-lg-3">
          <div class="card border-0">
            <div class="card-body" style="background-color: #9ab3f5;color:#FFF">
              <h6 class="card-title">Packing Pending</h6>
              <div class="d-flex align-items-center font-number mb-1">
              <i class="material-icons mr-2">card_travel</i>
                <h3 class="mb-0 mr-2"><?= $orders_packing_pending ?></h3>
              </div>
            </div>
          </div>
        </div>

        <div class="col-6 col-lg-3">
          <div class="card border-0">
            <div class="card-body" style="background-color: #a3d8f4;color:#FFF">
              <h6 class="card-title">Shipping Pending</h6>
              <div class="d-flex align-items-center font-number mb-1">
                <i class="material-icons mr-2">commute</i>
                <h3 class="mb-0 mr-2"><?= $orders_shipping_pending ?></h3>

              </div>
              </div>
          </div>
        </div>

        <div class="col-6 col-lg-3">
          <div class="card border-0">
            <div class="card-body" style="background-color: #51adcf;color:#FFF">
              <h6 class="card-title">Delivery Pending</h6>
              <div class="d-flex align-items-center font-number mb-1">
                <i class="material-icons mr-2">card_giftcard</i>
                <h3 class="mb-0 mr-2"><?=  $orders_delivery_pending ?></h3>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /Conversion Rate | Unique Purchases | Avg. Order Value | Order Quantity -->

    <div class="row gutters-vertical gutters-half">

      <!-- Monthly Sales -->
      <div class="col-xl-9">
        <div class="card h-100">
          <div class="card-header py-1">
            <i class="material-icons mr-2">show_chart</i>
            <h6>
              <select class="form-control form-control-sm" onchange="loadChart(this.value)">
                  <option value="1">Weekly</option>
                  <option value="2">Monthly</option>
              </select>
            </h6>
            <button type="button" data-action="fullscreen" class="btn btn-sm btn-text-secondary btn-icon rounded-circle shadow-none ml-auto">
              <i class="material-icons">fullscreen</i>
            </button>
          </div>
          <div class="card-body" style="height: 410px">
            <canvas id="monthlySalesChart"></canvas>
          </div>
        </div>
      </div>
      <!-- /Monthly Sales -->

      <!-- Sales Revenue -->

      <!-- /Sales Revenue -->

      <!-- Today Sales -->

      <!-- /Today Sales -->

      <!-- Transaction History -->

      <!-- /Transaction History -->

      <!-- New Customers -->
      <?php
        $total_customer=getAfield('count(name)',"app_usres","where is_deleted=0 AND account_verified=1");
        if($total_customer>8) $show=8; else $show=$total_customer;
      ?>
      <div class="col-md-3 col-xl-3">
        <div class="card h-100" id="new-customers">
          <div class="card-header py-1">
            <h6>New Customers (<?=$show?>/<?php echo $total_customer; ?>)</h6>
            <button type="button" data-action="reload" class="btn btn-sm btn-text-success btn-icon ml-auto rounded-circle shadow-none">
              <i class="material-icons" onclick="loadCustomers()">refresh</i>
            </button>
          </div>
          <ul class="list-group list-group-flush" id="customers">
          </ul>
        </div>
      </div>


      <!-- /New Customers -->

    </div>

  </main>
</form>

  <!-- Plugins -->
  <script src="<?php echo base_url() ?>assets/admin_template/plugins/jquery-sparkline/jquery.sparkline.min.js"></script>
  <script src="<?php echo base_url() ?>assets/admin_template/plugins/chart.js/Chart.min.js"></script>
  <script src="<?php echo base_url() ?>assets/admin_template/plugins/jqvmap/jquery.vmap.min.js"></script>
  <script src="<?php echo base_url() ?>assets/admin_template/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
  <script>
  var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
  	csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

Chart.defaults.global.elements.rectangle.borderWidth = 1 // bar border width
Chart.defaults.global.elements.line.borderWidth = 1 // line border width
Chart.defaults.global.maintainAspectRatio = false // disable the maintain aspect ratio in options then it uses the available height

var chart = new Chart('monthlySalesChart', {
    type: 'line',
    data: {},
    options: {
      tooltips: {
            mode: 'index',
            intersect: false
        }
    }
});


    $(() => {
      document.querySelector('#new-customers').addEventListener('card:reload', function () {
        var thisCard = this
        // reload new customers..
        setTimeout(() => { // do nothing for a second (this is only for demo)
          App.stopCardLoader(thisCard) // when done, run this function
        }, 1000)
      })


    })



$( document ).ready(function() {
  loadChart();
  loadCustomers();
});
function loadChart(type=1)
{
  $.ajax({
    type: "POST",
    url: '<?php echo admin_url() ?>dashboard/chart_data',
    data: {[csrfName]: csrfHash,type:type},
    success: function (response) {
      response=JSON.parse(response);

    if(response.labels)
      {
        // response.datasets.backgroundColor=color;
        // response.datasets.borderColor=color;
        chart.data = {
              labels: response.labels,
              datasets: [response.datasets]
          };
          chart.update();
      }


    }
  });
}
function loadCustomers()
{

    $.ajax({
      type: "POST",
      url: '<?php echo admin_url() ?>dashboard/get_customers',
      data: {[csrfName]: csrfHash},
      success: function (response) {
        $("#customers").html(response);
      }
    });
}
  </script>
