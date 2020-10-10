
  <main>

    <!-- Conversion Rate | Unique Purchases | Avg. Order Value | Order Quantity -->
    <div class="border rounded mb-3">
      <div class="row no-gutters">
        <div class="col-6 col-lg-3">
          <div class="card border-0">
            <div class="card-body">
              <h6 class="card-title">New Orders</h6>
              <div class="d-flex align-items-center font-number mb-1">
                <i class="material-icons mr-2">shopping_basket</i>
                <h3 class="mb-0 mr-2">250</h3>
                <span class="small text-success">1.2%<i class="material-icons font-size-base align-bottom">keyboard_arrow_up</i></span>
              </div>
              <div class="sparkline-data" data-value="0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,10,0,0,0,45,0,0,37,0,39,0,0,0,5,0,31,0,43,0,0,30,0,0,0,0,0,0,0,0,0"></div>
            </div>
          </div>
        </div>
        <div class="col-6 col-lg-3">
          <div class="card border-0">
            <div class="card-body">
              <h6 class="card-title">Shipping Pending</h6>
              <div class="d-flex align-items-center font-number mb-1">
                <i class="material-icons mr-2">bar_chart</i>
                <h3 class="mb-0 mr-2">57%</h3>
                <span class="small text-danger">0.7%<i class="material-icons font-size-base align-bottom">keyboard_arrow_down</i></span>
              </div>
              <div class="sparkline-data" data-value="0,0,0,0,0,0,0,0,0,0,0,40,0,5,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,45,1,0,0,35,0,0,40,0,0,45,0,0,0,5,0,0,20,0,5,0,0,0,0,0,0,0,0,0,0"></div>
            </div>
          </div>
        </div>
        <div class="col-6 col-lg-3">
          <div class="card border-0">
            <div class="card-body">
              <h6 class="card-title">Packing Pending</h6>
              <div class="d-flex align-items-center font-number mb-1">
                <i class="material-icons mr-2">person</i>
                <h3 class="mb-0 mr-2">48</h3>
                <span class="small text-danger">0.3%<i class="material-icons font-size-base align-bottom">keyboard_arrow_down</i></span>
              </div>
              <div class="sparkline-data" data-value="0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,40,0,0,10,0,0,0,0,0,0,0,0,0,0,0,50,0,40,0,5,0,0,10,0,0,25,0,0,0,5,0,0,0,0,25,0,0,0,0,40,0,0,0,0,0"></div>
            </div>
          </div>
        </div>
        <div class="col-6 col-lg-3">
          <div class="card border-0">
            <div class="card-body">
              <h6 class="card-title">Delivery Pending</h6>
              <div class="d-flex align-items-center font-number mb-1">
                <i class="material-icons mr-2">pie_chart</i>
                <h3 class="mb-0 mr-2">69</h3>
                <span class="small text-success">2.1%<i class="material-icons font-size-base align-bottom">keyboard_arrow_up</i></span>
              </div>
              <div class="sparkline-data" data-value="0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,10,0,0,0,45,0,0,37,0,39,0,0,0,5,0,31,0,43,0,0,30,0,0,0,0,0,0,0,0,0"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /Conversion Rate | Unique Purchases | Avg. Order Value | Order Quantity -->

    <div class="row gutters-vertical gutters-half">

      <!-- Monthly Sales -->
      <div class="col-xl-7">
        <div class="card h-100">
          <div class="card-header py-1">
            <i class="material-icons mr-2">show_chart</i>
            <h6>Monthly Sales</h6>
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
      <div class="col-md-6 col-xl-5">
        <div class="card">
          <div class="card-header">
            <h6>Sales Revenue</h6>
            <div class="dropdown ml-auto">
              <a href="#" role="button" class="dropdown-toggle text-muted small" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">USA</a>
              <div class="dropdown-menu dropdown-menu-right font-size-sm">
                <button class="dropdown-item" type="button">Algeria</button>
                <button class="dropdown-item" type="button">Argentina</button>
                <button class="dropdown-item" type="button">Brazil</button>
                <button class="dropdown-item" type="button">Canada</button>
                <button class="dropdown-item" type="button">France</button>
                <button class="dropdown-item" type="button">Germany</button>
                <button class="dropdown-item" type="button">Greece</button>
                <button class="dropdown-item" type="button">Iran</button>
                <button class="dropdown-item" type="button">Iraq</button>
                <button class="dropdown-item" type="button">Russia</button>
                <button class="dropdown-item" type="button">Tunisia</button>
                <button class="dropdown-item" type="button">Turkey</button>
                <button class="dropdown-item active" type="button">USA</button>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div id="vmap" style="height: 200px"></div>
            <table class="table table-sm table-borderless mt-3 mb-0">
              <thead>
                <tr>
                  <th>States</th>
                  <th class="text-right">Orders</th>
                  <th class="text-right">Earnings</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>California</td>
                  <td class="text-right">12,201</td>
                  <td class="text-right font-number">$150,200.80</td>
                </tr>
                <tr>
                  <td>Texas</td>
                  <td class="text-right">11,950</td>
                  <td class="text-right font-number">$138,910.20</td>
                </tr>
                <tr>
                  <td>Wyoming</td>
                  <td class="text-right">11,198</td>
                  <td class="text-right font-number">$132,050.00</td>
                </tr>
                <tr>
                  <td>Florida</td>
                  <td class="text-right">9,885</td>
                  <td class="text-right font-number">$127,762.10</td>
                </tr>
                <tr>
                  <td>New York</td>
                  <td class="text-right">8,560</td>
                  <td class="text-right font-number">$117,087.50</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <!-- /Sales Revenue -->

      <!-- Today Sales -->
      <div class="col-md-6 col-xl-4">
        <div class="card h-100" id="today-sales">
          <div class="card-header py-1">
            <h6>Today Sales</h6>
            <div class="list-with-gap ml-auto">
              <button type="button" data-action="reload" class="btn btn-sm btn-text-success btn-icon rounded-circle shadow-none">
                <i class="material-icons">refresh</i>
              </button>
              <div class="custom-control custom-control-nolabel custom-switch">
                <input type="checkbox" class="custom-control-input" id="customSwitch">
                <label class="custom-control-label" for="customSwitch"></label>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <h5 class="font-number mb-0 mr-2">$150,200</h5>
                  <span class="small text-success">0.20%<i class="material-icons font-size-base align-middle">keyboard_arrow_up</i></span>
                </div>
                <span class="small text-muted">Total Sales</span>
              </div>
              <div class="col-6">
                <div class="d-flex align-items-center">
                  <h5 class="font-number mb-0 mr-2">$21,880</h5>
                  <span class="small text-danger">1.04%<i class="material-icons font-size-base align-middle">keyboard_arrow_down</i></span>
                </div>
                <span class="small text-muted">Avg. Sales Per Day</span>
              </div>
            </div>
            <div style="height: 250px" class="mt-3">
              <canvas id="barChart2"></canvas>
            </div>
          </div>
        </div>
      </div>
      <!-- /Today Sales -->

      <!-- Transaction History -->
      <div class="col-md-6 col-xl-4">
        <div class="card h-100" id="transaction-history">
          <div class="card-header py-1">
            <h6>Transaction History</h6>
            <button type="button" data-action="reload" class="btn btn-sm btn-text-success btn-icon ml-auto rounded-circle shadow-none">
              <i class="material-icons">refresh</i>
            </button>
            <div class="dropdown">
              <button class="btn btn-text-secondary btn-icon btn-sm rounded-circle dropdown-toggle no-caret" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="material-icons">more_vert</i>
              </button>
              <div class="dropdown-menu dropdown-menu-right font-size-sm">
                <button class="dropdown-item" type="button">Action</button>
                <button class="dropdown-item" type="button">Another action</button>
              </div>
            </div>
          </div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex">
              <div class="media">
                <span class="flex-center bg-success-faded text-success rounded-circle p-2">
                  <i class="material-icons">check</i>
                </span>
                <div class="media-body ml-2">
                  <h6 class="font-size-sm mb-0">Payment from #10322</h6>
                  <span class="small text-muted">Mar 21, 2019, 3:30pm</span>
                </div>
              </div>
              <div class="ml-auto text-right">
                <h6 class="font-number mb-0">+ $250.00</h6>
                <span class="small text-success">Completed</span>
              </div>
            </li>
            <li class="list-group-item d-flex">
              <div class="media">
                <span class="flex-center bg-info-faded text-info rounded-circle p-2">
                  <i class="material-icons">subdirectory_arrow_left</i>
                </span>
                <div class="media-body ml-2">
                  <h6 class="font-size-sm mb-0">Process refund to #00910</h6>
                  <span class="small text-muted">Mar 21, 2019, 1:00pm</span>
                </div>
              </div>
              <div class="ml-auto text-right">
                <h6 class="font-number mb-0">-$16.50</h6>
                <span class="small text-success">Completed</span>
              </div>
            </li>
            <li class="list-group-item d-flex">
              <div class="media">
                <span class="flex-center bg-warning-faded text-warning rounded-circle p-2">
                  <i class="material-icons">local_shipping</i>
                </span>
                <div class="media-body ml-2">
                  <h6 class="font-size-sm mb-0">Process delivery to #44333</h6>
                  <span class="small text-muted">Mar 20, 2019, 11:40am</span>
                </div>
              </div>
              <div class="ml-auto text-right">
                <h6 class="font-number mb-0">3 Items</h6>
                <span class="small text-info">For pickup</span>
              </div>
            </li>
            <li class="list-group-item d-flex">
              <div class="media">
                <span class="flex-center bg-success-faded text-success rounded-circle p-2">
                  <i class="material-icons">check</i>
                </span>
                <div class="media-body ml-2">
                  <h6 class="font-size-sm mb-0">Payment from #023328</h6>
                  <span class="small text-muted">Mar 20, 2019, 10:30pm</span>
                </div>
              </div>
              <div class="ml-auto text-right">
                <h6 class="font-number mb-0">+ $129.50</h6>
                <span class="small text-success">Completed</span>
              </div>
            </li>
            <li class="list-group-item d-flex">
              <div class="media">
                <span class="flex-center bg-secondary-faded text-secondary rounded-circle p-2">
                  <i class="material-icons">close</i>
                </span>
                <div class="media-body ml-2">
                  <h6 class="font-size-sm mb-0">Payment failed from #087651</h6>
                  <span class="small text-muted">Mar 19, 2019, 12:54pm</span>
                </div>
              </div>
              <div class="ml-auto text-right">
                <h6 class="font-number mb-0">$150.00</h6>
                <span class="small text-danger">Declined</span>
              </div>
            </li>
          </ul>
        </div>
      </div>
      <!-- /Transaction History -->

      <!-- New Customers -->
      <div class="col-md-6 col-xl-4">
        <div class="card h-100" id="new-customers">
          <div class="card-header py-1">
            <h6>New Customers</h6>
            <button type="button" data-action="reload" class="btn btn-sm btn-text-success btn-icon ml-auto rounded-circle shadow-none">
              <i class="material-icons">refresh</i>
            </button>
            <div class="dropdown">
              <button class="btn btn-text-secondary btn-icon btn-sm rounded-circle dropdown-toggle no-caret" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="material-icons">more_vert</i>
              </button>
              <div class="dropdown-menu dropdown-menu-right font-size-sm">
                <button class="dropdown-item" type="button">Action</button>
                <button class="dropdown-item" type="button">Another action</button>
              </div>
            </div>
          </div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex align-items-center">
              <div class="media">
                <img src="<?php echo base_url() ?>assets/admin_template/dist/img/user1.svg" alt="user" class="rounded-circle" width="40">
                <div class="media-body ml-2">
                  <h6 class="font-size-sm mb-0">Socrates Itumay</h6>
                  <span class="small text-muted">Customer ID#00222</span>
                </div>
              </div>
              <div class="btn-group btn-group-sm ml-auto" role="group">
                <a href="javascript:void(0)" class="btn btn-text-secondary btn-icon rounded-circle shadow-none"><i class="material-icons">account_circle</i></a>
                <a href="javascript:void(0)" class="btn btn-text-secondary btn-icon rounded-circle shadow-none"><i class="material-icons">mail_outline</i></a>
                <a href="javascript:void(0)" class="btn btn-text-danger btn-icon rounded-circle shadow-none"><i class="material-icons">block</i></a>
              </div>
            </li>
            <li class="list-group-item d-flex align-items-center">
              <div class="media">
                <img src="<?php echo base_url() ?>assets/admin_template/dist/img/user2.svg" alt="user" class="rounded-circle" width="40">
                <div class="media-body ml-2">
                  <h6 class="font-size-sm mb-0">Reynante Labares</h6>
                  <span class="small text-muted">Customer ID#00221</span>
                </div>
              </div>
              <div class="btn-group btn-group-sm ml-auto" role="group">
                <a href="javascript:void(0)" class="btn btn-text-secondary btn-icon rounded-circle shadow-none"><i class="material-icons">account_circle</i></a>
                <a href="javascript:void(0)" class="btn btn-text-secondary btn-icon rounded-circle shadow-none"><i class="material-icons">mail_outline</i></a>
                <a href="javascript:void(0)" class="btn btn-text-danger btn-icon rounded-circle shadow-none"><i class="material-icons">block</i></a>
              </div>
            </li>
            <li class="list-group-item d-flex align-items-center">
              <div class="media">
                <img src="<?php echo base_url() ?>assets/admin_template/dist/img/user3.svg" alt="user" class="rounded-circle" width="40">
                <div class="media-body ml-2">
                  <h6 class="font-size-sm mb-0">Marianne Audrey</h6>
                  <span class="small text-muted">Customer ID#00220</span>
                </div>
              </div>
              <div class="btn-group btn-group-sm ml-auto" role="group">
                <a href="javascript:void(0)" class="btn btn-text-secondary btn-icon rounded-circle shadow-none"><i class="material-icons">account_circle</i></a>
                <a href="javascript:void(0)" class="btn btn-text-secondary btn-icon rounded-circle shadow-none"><i class="material-icons">mail_outline</i></a>
                <a href="javascript:void(0)" class="btn btn-text-danger btn-icon rounded-circle shadow-none"><i class="material-icons">block</i></a>
              </div>
            </li>
            <li class="list-group-item d-flex align-items-center">
              <div class="media">
                <img src="<?php echo base_url() ?>assets/admin_template/dist/img/user4.svg" alt="user" class="rounded-circle" width="40">
                <div class="media-body ml-2">
                  <h6 class="font-size-sm mb-0">Owen Bongcaras</h6>
                  <span class="small text-muted">Customer ID#00219</span>
                </div>
              </div>
              <div class="btn-group btn-group-sm ml-auto" role="group">
                <a href="javascript:void(0)" class="btn btn-text-secondary btn-icon rounded-circle shadow-none"><i class="material-icons">account_circle</i></a>
                <a href="javascript:void(0)" class="btn btn-text-secondary btn-icon rounded-circle shadow-none"><i class="material-icons">mail_outline</i></a>
                <a href="javascript:void(0)" class="btn btn-text-danger btn-icon rounded-circle shadow-none"><i class="material-icons">block</i></a>
              </div>
            </li>
            <li class="list-group-item d-flex align-items-center">
              <div class="media">
                <img src="<?php echo base_url() ?>assets/admin_template/dist/img/user5.svg" alt="user" class="rounded-circle" width="40">
                <div class="media-body ml-2">
                  <h6 class="font-size-sm mb-0">Kirby Avendula</h6>
                  <span class="small text-muted">Customer ID#00218</span>
                </div>
              </div>
              <div class="btn-group btn-group-sm ml-auto" role="group">
                <a href="javascript:void(0)" class="btn btn-text-secondary btn-icon rounded-circle shadow-none"><i class="material-icons">account_circle</i></a>
                <a href="javascript:void(0)" class="btn btn-text-secondary btn-icon rounded-circle shadow-none"><i class="material-icons">mail_outline</i></a>
                <a href="javascript:void(0)" class="btn btn-text-danger btn-icon rounded-circle shadow-none"><i class="material-icons">block</i></a>
              </div>
            </li>
          </ul>
        </div>
      </div>
      <!-- /New Customers -->

    </div>

  </main>







  <!-- Plugins -->
  <script src="<?php echo base_url() ?>assets/admin_template/plugins/jquery-sparkline/jquery.sparkline.min.js"></script>
  <script src="<?php echo base_url() ?>assets/admin_template/plugins/chart.js/Chart.min.js"></script>
  <script src="<?php echo base_url() ?>assets/admin_template/plugins/jqvmap/jquery.vmap.min.js"></script>
  <script src="<?php echo base_url() ?>assets/admin_template/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
  <script>
    $(() => {

      function run_sparkline() {
        $('.sparkline-data').text('').sparkline('html', {
          width: '100%',
          height: 20,
          lineColor: gray,
          fillColor: false,
          tagValuesAttribute: 'data-value'
        })
      }
      // Run sparkline when the document view (window) has been resized
      App.resize(() => {
        run_sparkline()
      })()
      // Run sparkline when the sidebar updated (toggle collapse)
      document.addEventListener('sidebar:update', () => {
        run_sparkline()
      })

      // Global Chart configuration
      Chart.defaults.global.elements.rectangle.borderWidth = 1 // bar border width
      Chart.defaults.global.elements.line.borderWidth = 1 // line border width
      Chart.defaults.global.maintainAspectRatio = false // disable the maintain aspect ratio in options then it uses the available height

      // Monthly Sales
      new Chart('monthlySalesChart', {
        type: 'line',
        data: {
          labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
          datasets: [
            {
              label: 'Last year',
              backgroundColor: Chart.helpers.color(gray).alpha(0.1).rgbString(),
              borderColor: gray,
              fill: 'start',
              data: [65, 59, 80, 81, 56, 55, 40]
            },
            {
              label: 'This year',
              backgroundColor: Chart.helpers.color(blue).alpha(0.1).rgbString(),
              borderColor: blue,
              fill: 'start',
              data: [28, 48, 40, 19, 86, 27, 90]
            }
          ]
        },
        options: {
          tooltips: {
            mode: 'index',
            intersect: false
            // Interactions configuration: https://www.chartjs.org/docs/latest/general/interactions/
          }
        }
      })

      // Sales Revenue Map
      $('#vmap').vectorMap({
        map: 'usa_en',
        showTooltip: true,
        backgroundColor: '#fff',
        color: '#d1e6fa',
        colors: {
          fl: blue,
          ca: blue,
          tx: blue,
          wy: blue,
          ny: blue
        },
        selectedColor: '#00cccc',
        enableZoom: false,
        borderWidth: 1,
        borderColor: '#fff',
        hoverOpacity: .85
      })

      // Today Sales
      new Chart('barChart2', {
        type: 'horizontalBar',
        data: {
          labels: ['6am', '10am', '1pm', '4pm', '7pm', '10pm'],
          datasets: [
            {
              label: 'Today',
              backgroundColor: Chart.helpers.color(cyan).alpha(0.3).rgbString(),
              borderColor: cyan,
              data: [20, 60, 50, 45, 50, 60]
            },
            {
              label: 'Yesterday',
              backgroundColor: Chart.helpers.color(yellow).alpha(0.3).rgbString(),
              borderColor: yellow,
              data: [10, 40, 30, 40, 55, 25]
            }
          ]
        },
        options: {
          tooltips: {
            mode: 'index',
            intersect: false
          },
          scales: {
            xAxes: [{
              ticks: {
                beginAtZero: true
              }
            }]
          }
        }
      })

      // Reload card event
      document.querySelector('#transaction-history').addEventListener('card:reload', function () {
        var thisCard = this
        // reload transaction history...
        setTimeout(() => { // do nothing for a second (this is only for demo)
          App.stopCardLoader(thisCard) // when done, run this function
        }, 1000)
      })
      document.querySelector('#new-customers').addEventListener('card:reload', function () {
        var thisCard = this
        // reload new customers..
        setTimeout(() => { // do nothing for a second (this is only for demo)
          App.stopCardLoader(thisCard) // when done, run this function
        }, 1000)
      })
      document.querySelector('#today-sales').addEventListener('card:reload', function () {
        var thisCard = this
        // reload today sales..
        setTimeout(() => { // do nothing for a second (this is only for demo)
          App.stopCardLoader(thisCard) // when done, run this function
        }, 1000)
      })

    })
  </script>
