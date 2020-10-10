<?php
class CatagoryModel extends CI_Model
{
    private function ExistCatagory_ForSave($product_catogory_name)
    {
        $query = $this->db->get_where('product_catogory', array('product_catogory_name' => $product_catogory_name, 'is_deleted' => 0));
        if ($query->num_rows() > 0)
            return true;
        else
            return false;
    }

    private function ExistCatagory_ForUpdate($product_catogory_name, $pcid)
    {
        $query = $this->db->query("select * from
                                            product_catogory
                                        where product_catogory_name = '$product_catogory_name'
                                                and pcid != '$pcid' and is_deleted = '0'");
        if ($query->num_rows() > 0)
            return true;
        else
            return false;
    }

    public function GetAllCatagory()
    {
        $query = $this->db->get_where('product_catogory', array('display_status' => 1, 'is_deleted' => 0));
        $i = 0;
        $Catagorys = array();
        foreach ($query->result() as $row) {
            $i++;
            $Catagory['pcid'] = $row->pcid;
            $Catagory['serialNo'] = $i;
            $Catagory['product_catogory_name'] = $row->product_catogory_name;
            $Catagory['scid'] = $row->scid;
            $Catagory['created'] = $row->created;
            $Catagory['editInnerHTML'] = '<button id="Edit" type="button" class="btn btn-success has-icon btn-xs"><i class="material-icons mr-1">create</i>Edit</button>';
            $Catagory['deleteInnerHTML'] = '<button id="delete" type="button" class="btn btn-danger has-icon btn-xs"><i class="material-icons mr-1">delete</i>Delete</button>';
            array_push($Catagorys, $Catagory);
        }
        return json_encode($Catagorys);
    }
    public function GetAllCatagoryDT()
    {
        $query = $this->db->order_by('pcid', 'DESC')->get_where('product_catogory', array('is_deleted' => 0));
        $i = 0;
        $Catagorys = array();
        foreach ($query->result() as $row) {
            $i++;
            $Catagory['pcid'] = $row->pcid;
            $Catagory['serialNo'] = $i;
            $Catagory['product_catogory_name'] = $row->product_catogory_name;
            $Catagory['scid'] = $row->scid;
            $Catagory['created'] = $row->created;
            $Catagory['display_status'] = $row->display_status ? 'Active' : 'Deactive';
            $Catagory['editInnerHTML'] = '<button id="Edit" type="button" class="btn btn-success has-icon btn-xs"><i class="material-icons mr-1">create</i>Edit</button>';
            $Catagory['deleteInnerHTML'] = '<button id="delete" type="button" class="btn btn-danger has-icon btn-xs"><i class="material-icons mr-1">delete</i>Delete</button>';
            array_push($Catagorys, $Catagory);
        }
        return json_encode(array("data" =>  $Catagorys,"csrfName"=>$this->security->get_csrf_token_name(), "csrfHash"=>$this->security->get_csrf_hash()));
    }
    public function GetCatagoryById($pcid)
    {
        $query = $this->db->get_where('product_catogory', array('pcid' => $pcid));
        $Catagorys = array();
        foreach ($query->result() as $row) {
            $Catagory['pcid'] = $row->pcid;
            $Catagory['product_catogory_name'] = $row->product_catogory_name;
            $Catagory['scid'] = $row->scid;
            $Catagory['created'] = $row->created;
            $Catagory['editInnerHTML'] = '<button id="Edit" type="button" class="btn btn-success has-icon btn-xs"><i class="material-icons mr-1">create</i>Edit</button>';
            $Catagory['deleteInnerHTML'] = '<button id="delete" type="button" class="btn btn-danger has-icon btn-xs"><i class="material-icons mr-1">delete</i>Delete</button>';
            array_push($Catagorys, $Catagory);
        }
        return json_encode($Catagorys);
    }
    public function AddCatagory($dataToSave)
    {
        if ($this->ExistCatagory_ForSave($dataToSave['product_catogory_name']))
            return 3; //"Data Already Exist";
        if ($this->db->insert('product_catogory', $dataToSave))
            return 1; //"Data Saved Sucessfully";
        else
            return 2; //"Failed to save";
    }
    public function UpdateCatagory($dataToUpdate, $pcid)
    {
        if ($this->ExistCatagory_ForUpdate($dataToUpdate['product_catogory_name'], $pcid))
            return 3; //"Data Already Exist";
        $this->db->where(array('pcid' => $pcid));
        if ($this->db->update('product_catogory', $dataToUpdate))
            return 1; //"Data Saved Sucessfully";
        else
            return 2; //"Failed to save";
    }
    public function DeleteCatagory($pcid)
    {
        $this->db->where(array('pcid' => $pcid));
        if ($this->db->update('product_catogory', array('is_deleted' => 1)))
            return "Data Deleted Sucessfully";
        else
            return "Operation Failed";
    }
}
