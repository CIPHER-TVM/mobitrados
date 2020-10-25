<!DOCTYPE html>
<html>

<head>
	<title>Invoice</title>
	<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,700&subset=latin,latin-ext'
		rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
	<!-- <link rel="stylesheet" href="sass/main.css" media="screen" charset="utf-8"/> -->
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<meta http-equiv="content-type" content="text-html; charset=utf-8">
<style>
@page {
		/* background: url('<?php echo base_url() ?>assets/pdf.jpg') no-repeat 0 0; */
		opacity:0.2;
		background-image-resize: 6;
	}
  .logo
  {
    width:10%;
  }
  body{
  font-family: Calibri, Candara, Segoe, Segoe UI, Optima, Arial, sans-serif;
  font-weight: 300;
  font-size: 12px;
  margin: 0;
  padding: 0;
  color: #777777;
  }
  .invoice
  {
    border-radius: 20%;
    border:1px solid #777777;
    background: #777777;
    color:#FFF;
    font-size:15px;
    width:70%;
    margin-left:15%;
    font-weight:700;
    padding-top: 5px;
    padding-bottom: 5px;
  }
  .tb1{
    margin-top:1%;
    width:100%;
    border-top:1px solid #777777;
    border-bottom:1px solid #777777;
    color:#000;
    font-size:10px;
  }
  .tb2{
    width:100%;
    border:1px dotted #000;
    border-bottom: 0px;
    color:#000;

  }
  .td1
  {
    background-color: #CCC;
    padding-top: 3px;
    padding-bottom: 3px;
  }
  .div1
  {
    margin-top:1%;
    height: 555px;
    border: 1px solid #CCC;
    border-bottom: 1px dotted #ccc;
  }
  .p_list td{
    padding-top:5px;
    padding-bottom: 5px;
    border-right:0.8px solid #CCC;
  }
  .div2
  {
    color:#000;
    padding: 5px 5px 5px 5px;
  }
  .tb3 td
  {
    /* border-right:1px solid #CCC; */
  }
  .tax_table td
  {
    text-align: right;
     padding: 5px;
  }
</style>
</head>
<?php
$order_date=$order_details->order_placed_date;
$date = DateTime::createFromFormat('Y-m-d',$order_date );
$order_date=$date->format('d/m/Y');
$inv_date=getAfield("created_date","order_delivery_management","where order_master_id=$order_id AND status=1");
$date = date_create($inv_date);
$inv_date=date_format($date, 'd/m/Y');
 ?>
  <body>
<div style="border: 1px dotted #000">


    <div style="text-align: center">
        <img src="<?php base_url() ?>assets/logo.png" class="logo"> <br />
         <b style="font-size:14px">MOBI TRADOS</b> <br />
           19/20H, Kattaikadu Ammandivilai <br />
           Kanyakumari 629204 <br />
           Mob: 7358167613 | Email : mobitrados@gmail.com | Web: www.mobitrados.com
           <br />
           <br />

           <div class="invoice">
             GST INVOICE
           </div>



         </div>

         <table class="tb1">
           <tr>
             <td style="width: 36%">
               <b>Order Number :  <?= $order_details->order_number ?></b> <br />
               Order Date : <?= $order_date ?> <br />
               Invoice Date : <?= $inv_date?> <br />
               GST NO : XXXXXXXXXXX <br />
             </td>
             <td style="width: 32%">
               <b>Billed To</b>  <br />
               <b> <?= $address_details->name ?> </b> <br />
               <?= nl2br($address_details->full_address) ?> <br />
               <?= nl2br($address_details->locality) ?>   <br />
               <?= nl2br($address_details->city_town) ?>
               <?= nl2br($address_details->pincode) ?> <br />
               Mobile: <?= nl2br($address_details->mobile_number) ?> <br />


             </td>
             <td style="width: 32%">
               <b>Shipped To</b> : <br />
               <b> <?= $address_details->name ?> </b> <br />
               <?= nl2br($address_details->full_address) ?> <br />
               <?= nl2br($address_details->locality) ?>   <br />
               <?= nl2br($address_details->city_town) ?>
               <?= nl2br($address_details->pincode) ?> <br />
               Mobile: <?= nl2br($address_details->mobile_number) ?> <br />
             </td>
           </tr>
         </table>

  <div class="div1">
    <table class="tb2" style="border-collapse: collapse" border="0">

      <tr style="padding-top:2px;padding-bottom: 2px;background-color: #CCC">
         <td width="5%" class="td1">Sl No</td>
         <td width="28%" class="td1">Product(s)</td>
         <td width="8%" class="td1" align="center">QTY</td>
         <td width="11%" class="td1" align="center">Unit Rate</td>
         <td width="17%" class="td1" align="center">Taxable Amount</td>
         <td width="15%" class="td1" align="center">GST AMT</td>
         <td width="17%" class="td1" align="center">Total</td>
      </tr>
      <?php
        $sl=0;
        $netamount=0;
        $total_tax=0;
        foreach ($order_child as $key) {
          $sl++;
          $product_name=$key->product_name;
          $unit_rate=$key->unit_rate;
          $qty=$key->qty;
          $taxable_value=$key->taxable_value;
          $tax_amount=$key->tax_amount;
          $total_amount=$key->total_amount;


          /**********ROUDN OFF***********/
          $taxable_value=round($taxable_value,2);
          $tax_amount=round($tax_amount,2);
          $total_amount=round($total_amount,2);
          $netamount=$netamount+$total_amount;
          $total_tax=$total_tax+$tax_amount;
          $taxable_value=number_format("$taxable_value",2);
          $unit_rate=number_format("$unit_rate",2);
          $tax_amount=number_format("$tax_amount",2);
          $total_amount=number_format("$total_amount",2);
          ?>
          <tr class="p_list">
            <td><?= $sl ?></td>
            <td><?= $product_name ?></td>
            <td align="center"><?= $qty ?></td>
            <td align="right"><?= $unit_rate ?></td>
            <td align="right"><?= $taxable_value ?></td>
            <td align="right"><?= $tax_amount ?></td>
            <td align="right"><?= $total_amount ?></td>
          </tr>
          <?php
        }
       ?>
    </table>

  </div>
  <div class="div2">
    <table style="border-collapse: collapse;color:#000;" border="0" class="tb3">

      <tr>
        <td style="width: 20%;border-right: 1px solid #ccc">
          Generated On : <br /> <?php echo date("d-m-Y h:i:A") ?>
          <br /> Sign :
        </td>
        <td style="width: 50%;border-right: 1px solid #ccc">

          <table style="border-collapse: collapse;color:#000;width: 100%;" class="tax_table" >
            <tr>
                <td width="10%">GST% </td>
                <td width="30%">Taxable Amount</td>
                <td width="20%">SGST</td>
                <td width="20%">CGST</td>
                <td width="20%">IGST</td>
            </tr>
            <?php
              foreach ($tax_summery as $tax ) {
                $tax_value=$tax->tax_value;
                $taxable_value=$tax->taxable_value;
                $sgst=$tax->sgst;
                $cgst=$tax->cgst;
                $igst=$tax->igst;

                $taxable_value=round($taxable_value,2);
                $sgst=round($sgst,2);
                $cgst=round($cgst,2);
                $igst=round($igst,2);

                $taxable_value=number_format("$taxable_value",2);
                $sgst=number_format("$sgst",2);
                $cgst=number_format("$cgst",2);
                $igst=number_format("$igst",2);
                ?>
                <tr>
                  <td><?= $tax_value  ?></td>
                  <td><?= $taxable_value  ?></td>
                  <td><?= $sgst  ?></td>
                  <td><?= $cgst  ?></td>
                  <td><?= $igst  ?></td>
                </tr>
                <?php
                }
             ?>
          </table>

        </td>
        <?php
          $netamount=number_format("$netamount",2);
          $total_tax=number_format("$total_tax",2);
         ?>
        <td style="width: 30%;border-right: 1px solid #ccc">
          <table style="border-collapse: collapse;color:#000;width: 100%;" class="tax_table">
            <tr>
              <td>Amount:</td>
              <td><?= $netamount ?></td>
            </tr>
            <tr>
              <td>DISC:</td>
              <td>0.00</td>
            </tr>

            <tr>
              <td>OC:</td>
              <td>0.00</td>
            </tr>
            <tr>
              <td>GST AMOUNT:</td>
              <td><?=$total_tax?></td>
            </tr>
            <tr >
              <td style="font-size: 14px;font-weight: bolder"><h5>NET AMOUNT:</h5></td>
              <td style="font-size: 14px;font-weight: bolder"><h5><?= $netamount ?></h5></td>
            </tr>
          </table>
        </td>
      </tr>

    </table>
  </div>
  <div class="div2" style="border-top:1px dotted #000">
      <h5>Have A Nice Day</h5>
  </div>
</div>
  </body>

</html>
