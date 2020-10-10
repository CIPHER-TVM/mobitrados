<?php
    require_once('DistrictsObject.php');
    class DistrictsModel extends CI_Model
    {
        public function GetDistrictsByStateID($stateID)
        {
            $query = $this->db->query("select DistrictId, DistrictName, DisplayStatus, StateID from districts where StateID = '$stateID'");
            $districtList = array(); 

            foreach ($query->result() as $row)
            {
                $district = new DistrictsObject();
                $district->DistrictId = $row->DistrictId;
                $district->DistrictName = $row->DistrictName;
                $district->StateID = $row->StateID;
                $district->DisplayStatus = $row->DisplayStatus;

                array_push($districtList, $district);
            }

            return json_encode($districtList);
        }
    }
?>