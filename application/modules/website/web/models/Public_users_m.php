<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Public_users_m extends CI_Model
{

    public function get($id = '')
    {
        $q = $this->db->get_where('public_users', array('public_user_id' => $id));
        if (($q) && (($q->num_rows()))) {
            return $q->result();
        }
        return false;
    }
    public function getShops_pagination($start=1,$limit=10,$search='',$placeId='',$sort='')
    {
			$dt = date('Y-m-d');
			// $this->db->select('*');
			// $this->db->from('shop_registration');
			// $this->db->where('displayStatus','1');
			// $this->db->where('isDelete','0');
			// $this->db->where('licence_expiry_date >',$dt);
			// if($search) { $this->db->like('shopName',$search); }
			// if($search) { $this->db->or_like('metaKeywords',$search); }
			// if($placeId) { $this->db->where('places',$placeId); }
			// $this->db->limit($limit,$start);
			// $query = $this->db->get();
			$sql="SELECT *
			FROM `shop_registration`
			WHERE `displayStatus` = '1'
			AND `isDelete` = '0'
			AND `licence_expiry_date` > ? ";

			if($search){
				$sql .=" AND (`shopName` LIKE '%$search%' ESCAPE '!'
				OR  `metaKeywords` LIKE '%$search%' ESCAPE '!') ";
			}
			if($placeId){

				$sql .=" AND `places` = '$placeId' ";
			}
			if($sort==1){

				$sql .=" order by `shopName` asc ";
			}
			else if($sort==2){

				$sql .=" order by  shopName  desc ";
			}
			if(!$start){

				$sql .="  LIMIT $limit";
			}else{

				$sql .="  LIMIT $limit,$start";
			}
			$query = $this->db->query($sql,array($dt));
			$x= $this->db->last_query();
			$res =  $query->result();
			
			if($res){
				foreach ($res as &$item) {
					$item->shop_logo = $this->check_img(base_url('uploads/'.$item->shop_logo ));
				}
			}
      return $res;
		}
    public function getShops_count($search='',$placeId='')
    {
			$dt = date('Y-m-d');
			// $this->db->select('*');
			// $this->db->from('shop_registration');
			// $this->db->where('displayStatus','1');
			// $this->db->where('isDelete','0');
			// $this->db->where('licence_expiry_date >',$dt);
			// if($search) { $this->db->like('shopName',$search); }
			// if($search) { $this->db->or_like('metaKeywords',$search); }
			// if($placeId) { $this->db->where('places',$placeId); }
      // $query = $this->db->get();
			$sql="SELECT *
			FROM `shop_registration`
			WHERE `displayStatus` = '1'
			AND `isDelete` = '0'
			AND `licence_expiry_date` > ? ";

			if($search){
				$sql .=" AND (`shopName` LIKE '%$search%' ESCAPE '!'
				OR  `metaKeywords` LIKE '%$search%' ESCAPE '!') ";
			}
			if($placeId){

				$sql .=" AND `places` = '$placeId' ";
			}
			$query = $this->db->query($sql,array($dt));
      return $query->num_rows();
		}
    public function getProducts_pagination($start=1,$limit=10,$search='',$placeId='',$category='',$shop='')
    {
			$dt = date('Y-m-d');
			// $this->db->select('p.*,s.shopName');
			// $this->db->from('shop_products p');
			// $this->db->join('shop_registration s','p.shid = s.shid');
			// $this->db->where('p.status','1');
			// $this->db->where('s.displayStatus','1');
			// $this->db->where('s.isDelete','0');
			// $this->db->where('s.licence_expiry_date >',$dt);
			// if($search) { $this->db->like('p.keywords',$search); }
			// if($search) { $this->db->or_like('p.productName',$search); }
			// if($placeId) { $this->db->where('s.places',$placeId); }
			// $this->db->limit($limit,$start);
			// $query = $this->db->get();
			$sql = "SELECT `p`.*, `s`.`shopName`
			FROM `shop_products` `p`
			JOIN `shop_registration` `s` ON `p`.`shid` = `s`.`shid`
			WHERE `p`.`status` = '1'
			AND `s`.`displayStatus` = '1'
			AND `s`.`isDelete` = '0'
			AND `s`.`licence_expiry_date` > ? ";

			if($search){
				$sql .= " AND  (`p`.`keywords` LIKE '%$search%'
			OR  `p`.`productName` LIKE '%$search%' ESCAPE '!' )";
			}

			if($placeId){
				$sql .= " AND `s`.`places` = '$placeId' ";
			}

			if($shop){
				$sql .= " AND `p`.`shid` = '$shop' ";
			}

			if($category){
				$sql .= " AND `p`.`product_catogory` = '$category' ";
			}

			if(!$start){
				$sql .="  LIMIT $limit";
			}else{
				$sql .="  LIMIT $limit,$start";
			}
			$query = $this->db->query($sql,array($dt));
			$x= $this->db->last_query();
			$res  =$query->result();
			if($res){
				foreach ($res as &$item) {
					$item->imageFile1 = $this->check_img(base_url('product_uploads/'.$item->imageFile1 ));
				}
			}
      return $res;
		}
		
		public function check_img($img)
		{
			$default = base_url('assets/noimage.jpg');
			if($img){
				if (@getimagesize($img)) {
					return $img;	
				}
		}
		return $default;
	}
    public function getProducts_count($search='',$placeId='',$category='',$shop='')
    {
			$dt = date('Y-m-d');
			// $this->db->select('p.*,s.shopName');
			// $this->db->from('shop_products p');
			// $this->db->join('shop_registration s','p.shid = s.shid');
			// $this->db->where('p.status','1');
			// $this->db->where('s.displayStatus','1');
			// $this->db->where('s.isDelete','0');
			// $this->db->where('s.licence_expiry_date >',$dt);
			// if($search) { $this->db->like('p.keywords',$search); }
			// if($search) { $this->db->or_like('p.productName',$search); }
			// if($placeId) { $this->db->where('s.places',$placeId); }
      // $query = $this->db->get();
			$sql = "SELECT `p`.*, `s`.`shopName`
			FROM `shop_products` `p`
			JOIN `shop_registration` `s` ON `p`.`shid` = `s`.`shid`
			WHERE `p`.`status` = '1'
			AND `s`.`displayStatus` = '1'
			AND `s`.`isDelete` = '0'
			AND `s`.`licence_expiry_date` > ? ";

			if($search){
				$sql .= " AND  (`p`.`keywords` LIKE '%$search%' ESCAPE '!'
			OR  `p`.`productName` LIKE '%$search%' ESCAPE '!' )";
			}

			if($placeId){
				$sql .= " AND `s`.`places` = '$placeId' ";
			}

			if($shop){
				$sql .= " AND `p`.`shid` = '$shop' ";
			}

			if($category){
				$sql .= " AND `p`.`product_catogory` = '$category' ";
			}

			$query = $this->db->query($sql,array($dt));
      return $query->num_rows();
		}

    public function getShopsByPlaceId($placeId)
    {
        $query = $this->db->query("SELECT * FROM `shop_registration` where places = '$placeId' and displayStatus = '1' and isDelete = '0'");
        return json_encode($query->result());
    }
    public function cu($data)
    {
        $id = '';
        if (isset($data['public_user_id'])) {
            $id = $data['public_user_id'];
            unset($data['public_user_id']);
        }
        if (!$id) {
            $this->db->insert('public_users', $data);
        } else {
            $this->db->where('public_user_id', $id);
            //$res= $this->db->update($table, $data);
            $id = $this->db->insert_id();
        }
        $x = $this->db->error();
        if ($this->db->affected_rows()) {
            return true;
        }
        return false;
    }

    public function login($data)
    {
        $this->db->where($data);
        $qd = $this->db->get('public_users');
        $q = $this->db->get('public_users')->num_rows();
        if ($q) {
            return $qd->row_array();
        }
        return false;
    }
    public function autocompletePlacePincode($value)
    {
        if (ctype_alpha($value)) {
            $query = $this->db->query("SELECT
                                        PlaceName,
                                        pincode,
                                        PlaceID
                                    FROM `places`
                                        where PlaceName LIKE '$value%'");
        } elseif (ctype_digit($value)) {
            $query = $this->db->query("SELECT
                                        PlaceName,
                                        pincode,
                                        PlaceID
                                    FROM `places`
                                        where pincode LIKE '$value%'");
        }
        $places = array();
        foreach ($query->result() as $row) {
            $place = array();
            $place['placeName'] = $row->PlaceName;
            $place['pincode'] = $row->pincode;
            $place['placeID'] = $row->PlaceID;
            array_push($places, $place);
        }
        return json_encode($places);
    }
    public function getPlace($location)
    {
        $query = $this->db->query("select * from places where PlaceID ='$location'");
        return $query->result();
    }
    public function getPlaceByLocation($location)
    {
        $query = $this->db->query("select * from places where PlaceName ='$location'");
        return $query->result();
    }
    public function getPlaceByPincode($pincode)
    {
        $query = $this->db->query("select * from places where pincode ='$pincode'");
        return $query->result();
    }
    public function getProducts_category($search='')
    {
			$sql = "select * from product_catogory where display_status =1 and is_deleted = 0";
			if($search){
				$sql .= " and product_catogory_name like '%$search%'";
			}
        $query = $this->db->query($sql);
        return $query->result();
    }
}
