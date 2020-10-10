<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Manage_products extends MY_Controller {

  public function __construct()
  {
  	parent::__construct();
    	$this->load->model('Manage_products_m','mproducts');
  }
  public function add_product()
  {
    $data['page'] = 'add_product';
    $data['mainpage'] = 'product_settings';
    $data['page_title'] = 'Product Master';
    $this->template->page_maker('manage_products/product_master',$data);
  }

  public function save_product()
  {
    if (!$this->input->is_ajax_request()) { 	exit('No direct script access allowed');  }
     $createduser=$this->session->userdata('userid');
	   $this->form_validation->set_rules('catagory','Category','required');
     $this->form_validation->set_rules('pro_name','Product name','trim|required|min_length[3]');
     $this->form_validation->set_rules('tax','Tax','required');
     $this->form_validation->set_rules('mrp','MRP','required|numeric');
     $this->form_validation->set_rules('selling_price','Selling price','required|numeric');
     $crude=$this->input->post('crude');
     $id=$this->input->post('hidid');
     $catagory=$this->input->post('catagory');
     $pro_name=$this->input->post('pro_name');

     if($this->form_validation->run())
     {
       $mrp=$this->input->post('mrp');
       $selling_price=$this->input->post('selling_price');
       if($selling_price>$mrp){ echo "Selling price cannot be larger than MRP"; exit; }

       // check exist
       $active=$this->input->post('display_status');
       if($active) $active=1; else $active=0;

       if($crude==1){ $chk=checkexist("pr_id","products","where is_deleted=0 and product_catogory='$catagory' AND product_name='$pro_name'"); }
       else if($crude==2) { $chk=checkexist("pr_id","products","where is_deleted=0 and product_catogory='$catagory' AND product_name='$pro_name' and pr_id !=$id"); }
       if($chk==0)
       {
         $data=array(
           'product_catogory'=>$catagory,
           'product_name'=>$pro_name,
           'product_dispn'=>$this->input->post('product_description'),
           'mrp'=>$mrp,
           'selling_price'=>$selling_price,
           'display_status'=>$active,
           'detailed_dpn'=>$this->input->post('product_Details'),
           'keywords'=>$this->input->post('keywords'),
           'stock'=>$this->input->post('stock'),
           'created_by'=>$createduser,
           'tax_id'=>$this->input->post('tax'),


         );

         if($crude==1)
         {
           $data['available_stock']=$this->input->post('stock');

           $ins=insertInDb("products",$data);
           if($ins)
           {
          //   echo 1;
             $ins_id=getAfield("pr_id","products","where product_catogory='$catagory' and product_name='$pro_name' order by pr_id desc limit 1");
             // intial stock entry
             $st_data=array(
               'is_intial_stock'=>1,
               'product_id'=>$ins_id,
               'stock'=>$this->input->post('stock')
             );
             $ins2=insertInDb("stock_history",$st_data);
           }
           else echo "Unable to save, please try after some time!";
         }
         else {
           $where=array('pr_id'=>$id);
           $ins_id=$id;
           $ins=update("products",$data,$where);

            // intial stock updateion
            $updating_stock=$this->input->post('stock');
            $exist_stock=getAfield("stock","stock_history","where product_id='$ins_id' AND is_intial_stock=1");
            $dec_stock=$this->product_stock_updates('-',$exist_stock,$ins_id);

            $ins_stock_data=array('stock'=>$updating_stock); $sins_stock_where=array('product_id'=>$ins_id,'is_intial_stock'=>1);
            $ins_st_ups=update("stock_history",$ins_stock_data,$sins_stock_where);

            $add_stcok=$this->product_stock_updates('+',$updating_stock,$ins_id);


          // if($ins) echo 1; else echo "Unable to update, please try after some time!";
         }
///////////////////////////// ///////////////////////////////////////////////////
          if($ins)
          {
            if (isset($_FILES['input44']) &&  $ins_id>0)
                  {
                    if (!empty($_FILES['input44']['name'][0])) {

                          $config = array(
                          'upload_path'   => './assets/product_images/',
                          'allowed_types' => 'jpg|gif|png|jpeg',
                          'overwrite'     => 1,
                          );
                          $this->load->library('upload', $config);
                          $images = array();
                          $files=$_FILES['input44'];

                      foreach ($files['name'] as $key => $image) {
                       $_FILES['images[]']['name']= $files['name'][$key];
                       $_FILES['images[]']['type']= $files['type'][$key];
                       $_FILES['images[]']['tmp_name']= $files['tmp_name'][$key];
                       $_FILES['images[]']['error']= $files['error'][$key];
                       $_FILES['images[]']['size']= $files['size'][$key];



                       $name = rand(10000, 1000000);
                       $name=md5($name);
                       $images[] = $name;
                       $config['file_name'] = $name;

                       $this->upload->initialize($config);

                       if ($this->upload->do_upload('images[]')) {
                          $upload_data= $this->upload->data();
                          $file_name_1 = $upload_data['file_name'];
                          $path1 = "assets/product_images/" . $file_name_1;
                          $data2=array(
                            'product_id'=>$ins_id,
                            'image_path'=>$path1
                          );
                          $ins2=insertInDb("product_images",$data2);

                       } else {
                           return false;
                       }
                   }  // FOREACH


                 }  // IF IMAGE

               }  // IF POST  nd insid>0
               echo 1;
          }
          else {
            echo "Unable to update, please try after some time!";
          }
/////////////////////////////////////////////////////////////////////////////////////
       }
       else {
         echo "Product already exists under selected category";

       }

     }
     else
     {
       echo strip_tags(validation_errors());
     }



  }

public function product_stock_updates($operator,$stock,$prod_id)
{
  $existstoc=getAfield("available_stock","products","where pr_id='$prod_id'");
  if($operator=='-')
  {
        $newstock=$existstoc-$stock;
  }
  else if($operator=="+")
  {
     $newstock=$existstoc+$stock;
  }
  $update=array('available_stock'=>$newstock);
  $where=array('pr_id'=>$prod_id);
  $ins=update("products",$update,$where);
  if($ins) return true; else return false;
}
  public function get_product_data()
  {
    if (!$this->input->is_ajax_request()) { 	exit('No direct script access allowed');  }
    $data = array();
    $filldata = $this->mproducts->product_data();
    $edit='<button id="edit" type="button" class="edit btn btn-success has-icon btn-xs"><i class="material-icons mr-1">create</i>Edit&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>';
    $delete='<button id="delete" type="button" class="delete btn btn-danger has-icon btn-xs"><i class="material-icons mr-1">delete</i>Delete</button>';
    $view='<a href="javascript:void(0)" class="btn btn-text-secondary btn-icon view_data rounded-circle"><i class="material-icons" stile="color:blue;font-size:12px;">visibility</i></a>';
    $sl=0;
    foreach($filldata->result() as $row)
    {
      $sl++;
      if($row->display_status==1) $display="Active"; else $display="Inactive";
      $data[] = array(
          'no' => $sl,
          'id' => $row->pr_id ,
          'product_catogory_name' => $row->product_catogory_name,
          'product_catogory'=>$row->product_catogory,
          'product_name'=>$row->product_name,
          'product_dispn'=>$row->product_dispn,
          'mrp'=>$row->mrp,
          'selling_price'=>$row->selling_price,
          'detailed_dpn'=>$row->detailed_dpn,
          'keywords'=>$row->keywords,
          'stock'=>$row->stock,
          'tax_id'=>$row->tax_id,
          'display_status' => $row->display_status,
          'edit' => $edit,
          'delete'=>$delete,
          'display'=>$display,
          'view'=>$view,
          'display'=>$display,
          'available_stock'=>$row->available_stock,
        );
    }
    $output = array(
      "recordsTotal" => $filldata->num_rows(),
      "recordsFiltered" => $filldata->num_rows(),
      "data" => $data
    );
    echo json_encode($output);
  }
  public function get_product_images()
  {
      if (!$this->input->is_ajax_request()) { 	exit('No direct script access allowed');  }
      $pro_id=$this->input->post('pr_id');
      if($pro_id>0)
      {
        $images=$this->mproducts->product_images($pro_id);
        $op="";
        $sl=0;
        foreach($images->result() as $row)
        {
          $sl++;
          $image_id=$row->img_id;
          $image_path=$row->image_path;
          $image_path=base_url().$image_path;
          $op.='
            <tr>
            <td>'.$sl.'</td>
            <td><img src="'.$image_path.'" width="70%" /></td>
            <td><button type="button" class="btn btn-danger has-icon btn-xs" onclick="delete_image('.$image_id.')"><i class="material-icons mr-1">delete</i>Delete</button></td>
            </tr>
          ';
        }
        print $op;
      }
  }
  public function delete_product_image()
  {
    if (!$this->input->is_ajax_request()) { 	exit('No direct script access allowed');  }
    $delid=$this->input->post('id');
    if($delid>0)
    {
      $data=array('is_deleted'=>1);
      $where=array('img_id '=>$delid);
      $ins=update("product_images",$data,$where);
      if($ins) echo 1; else echo "Unable to delete, please try after some time!";
    }
  }
  public function delete_product()
  {
    if (!$this->input->is_ajax_request()) { 	exit('No direct script access allowed');  }
    $id=$this->input->post('id');
    if($id>0)
    {
      $data=array('is_deleted'=>1);
      $where=array('pr_id '=>$id);
      $ins=update("products",$data,$where);
      if($ins) echo 1; else echo "Unable to delete, please try after some time!";
    }
  }

  public function add_stock()
  {
    $data['page'] = 'add_stock';
    $data['mainpage'] = 'product_settings';
    $data['page_title'] = 'Product Stock';
    $this->template->page_maker('manage_products/add_stock',$data);
  }
  public function get_product_by_category()
  {
    if (!$this->input->is_ajax_request()) { 	exit('No direct script access allowed');  }
    $cat_id=$this->input->post('cat_id');
    echo "<option value=''>Select Product </option>";
    if($cat_id>0)
    {
      LoadCombo("products","pr_id","product_name",'',"where product_catogory=$cat_id and is_deleted=0 AND display_status=1","order by product_name asc");
    }
  }
  public function get_stock_history()
  {
    if (!$this->input->is_ajax_request()) { 	exit('No direct script access allowed');  }
    $pr_id=$this->input->post('pr_id');
//    echo "pid =$pr_id";
      if($pr_id>0)
      {
        $data = array();
        $filldata = $this->mproducts->product_stock_history($pr_id);
        $delete='<button id="delete" type="button" class="delete btn btn-danger has-icon btn-xs"><i class="material-icons mr-1">delete</i>Delete</button>';
        $sl=0;
        foreach($filldata->result() as $row)
        {
          $sl++;
          $created_date=$row->created_date;
          $date=date_create($created_date);
          $stock_date=date_format($date,"d/m/Y");
          $data[] = array(
              'no' => $sl,
              'stock_id'=>$row->stock_id,
              'stock'=>$row->stock,
              'stock_date'=>$stock_date,
              'delete'=>$delete,
              'product_name'=>$row->product_name,
              'product_catogory_name'=>$row->product_catogory_name,
              'product_id'=>$row->product_id,
            );
        }
        $output = array(
          "recordsTotal" => $filldata->num_rows(),
          "recordsFiltered" => $filldata->num_rows(),
          "data" => $data
        );
      }
      else
      {
        $output = array(
          "recordsTotal" => 0,
          "recordsFiltered" => 0,
          "data" => array()
        );

      }
      echo json_encode($output);
  }
  public function get_product_stock()
  {
      if (!$this->input->is_ajax_request()) { 	exit('No direct script access allowed');  }
      $pid=$this->input->post('pid');
      $availablestock=getAfield("available_stock","products","where pr_id=$pid");
      echo $availablestock;
  }
  public function save_product_stock()
  {
      if (!$this->input->is_ajax_request()) { 	exit('No direct script access allowed');  }
      $pid=$this->input->post('pid');
      $new_qty=$this->input->post('new_qty');


      $data=array(
        'is_intial_stock'=>0,
        'product_id'=>$pid,
        'stock'=>$new_qty,
      );
       $ins=insertInDb("stock_history",$data);
       if($ins){
         $dec_stock=$this->product_stock_updates('+',$new_qty,$pid);
         echo 1;
       }
       else
       {
         echo "Unable to save, try again later";
       }
  }
  public function delete_stock()
  {
      if (!$this->input->is_ajax_request()) { 	exit('No direct script access allowed');  }
      $id=$this->input->post('id');
      $stock=$this->input->post('stock');
      $product_id=$this->input->post('product_id');
        $del_data=array('is_deleted'=>1); $where=array('stock_id'=>$id);
        $ins=update("stock_history",$del_data,$where);
        if($ins){
            $dec_stock=$this->product_stock_updates('-',$stock,$product_id);
            echo 1;
        }
        else
        {
          echo "Unable to delete, please try again later";
        }
  }
}
?>
