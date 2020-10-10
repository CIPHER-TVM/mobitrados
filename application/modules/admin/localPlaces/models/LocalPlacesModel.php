<?php
    require_once('LocalPlacesObject.php');
    class LocalPlacesModel extends CI_Model
    {
        public function GetPlacesByDistrictID($districtID) {
            $query = $this->db->query("select PlaceID, PlaceName, DisplayStatus, DistrictID, pincode from places where DistrictID = '$districtID' and DisplayStatus = '1' and is_deleted = 0");
            $localPlacesList = array();

            foreach ($query->result() as $row)
            {
                $LocalPlaces = new LocalPlacesObject();
                $LocalPlaces->PlaceID = $row->PlaceID;
                $LocalPlaces->PlaceName = $row->PlaceName;
                $LocalPlaces->DisplayStatus = $row->DisplayStatus;
                $LocalPlaces->DistrictID = $row->DistrictID;
                $LocalPlaces->pincode = $row->pincode;

                array_push($localPlacesList, $LocalPlaces);
            }

            return json_encode($localPlacesList);
        }

        public function GetAllDistricts() {
            $query = $this->db->query("
                SELECT p.PlaceName
                    , p.PlaceID
                    , p.pincode
                    , p.DisplayStatus
                    , d.DistrictName
                    , s.StateName
                FROM
                    places p
                INNER JOIN
                    districts d
                    on p.DistrictID = d.DistrictId
                INNER join state s
                    ON s.StateID = d.StateID
                WHERE p.DisplayStatus = 1 AND p.is_deleted = 0
            ");
            $localPlacesList = array();
            $i = 0;
            foreach ($query->result() as $row)
            {
                $i++;

                $LocalPlaces['SerialNo'] = $i;
                $LocalPlaces['PlaceName'] = $row->PlaceName;
                $LocalPlaces['DistrictName'] = $row->DistrictName;
                $LocalPlaces['StateName'] = $row->StateName;
                $LocalPlaces['PlaceID'] = $row->PlaceID;
                $LocalPlaces['pincode'] = $row->pincode;
                $LocalPlaces['DisplayStatus'] = ($row->DisplayStatus == 1) ? "Active" : "De Active" ;
                $LocalPlaces['EditInnerHTML'] = '<button id="Edit" type="button" class="btn btn-success has-icon btn-xs"><i class="material-icons mr-1">create</i>Edit</button>';
                $LocalPlaces['DeleteInnerHTML'] = '<button id="delete" type="button" class="btn btn-danger has-icon btn-xs"><i class="material-icons mr-1">delete</i>Delete</button>';

                array_push($localPlacesList, $LocalPlaces);
            }

            return json_encode($localPlacesList);
        }
        public function GetAllDistrictsForDT() {
            $query = $this->db->query("
                SELECT p.PlaceName
                    , p.PlaceID
                    , p.pincode
                    , p.DisplayStatus
                    , d.DistrictName
                    , s.StateName
                    , p.delivery_fee
                    ,p.expected_delivery_time
                FROM
                    places p
                INNER JOIN
                    districts d
                    on p.DistrictID = d.DistrictId
                INNER join state s
                    ON s.StateID = d.StateID
                WHERE p.is_deleted = 0
                ORDER BY p.PlaceID DESC
            ");
            $localPlacesList = array();
            $i = 0;
            foreach ($query->result() as $row)
            {
                $i++;

                $LocalPlaces['SerialNo'] = $i;
                $LocalPlaces['PlaceName'] = $row->PlaceName;
                $LocalPlaces['DistrictName'] = $row->DistrictName;
                $LocalPlaces['StateName'] = $row->StateName;
                $LocalPlaces['PlaceID'] = $row->PlaceID;
                $LocalPlaces['pincode'] = $row->pincode;
                $LocalPlaces['delivery_fee'] = $row->delivery_fee;
                $LocalPlaces['expected_delivery_time'] = $row->expected_delivery_time;
                $LocalPlaces['DisplayStatus'] = ($row->DisplayStatus == 1) ? "Active" : "De Active" ;
                $LocalPlaces['EditInnerHTML'] = '<button id="Edit" type="button" class="btn btn-success has-icon btn-xs"><i class="material-icons mr-1">create</i>Edit</button>';
                $LocalPlaces['DeleteInnerHTML'] = '<button id="delete" type="button" class="btn btn-danger has-icon btn-xs"><i class="material-icons mr-1">delete</i>Delete</button>';

                array_push($localPlacesList, $LocalPlaces);
            }

            return json_encode(array('data' => $localPlacesList));
        }

        public function GetAllPlaceById($placeID) {
            $this->db->where(array( 'PlaceId' => $placeID ));
            $query = $this->db->query("SELECT p.PlaceID
                                            , p.PlaceName
                                            , p.DistrictID
                                            , p.DisplayStatus
                                            , p.pincode
                                            , s.StateID
                                            , p.delivery_fee
                                            , p.expected_delivery_time
                                        FROM `places` p
                                        INNER JOIN districts d
                                            ON p.DistrictID = d.DistrictId
                                        INNER JOIN state s
                                            ON s.StateID = d.StateID
                                        WHERE
                                            p.PlaceID = $placeID");

            foreach($query->result() as $row) {

                $Places['PlaceID'] = $row->PlaceID;
                $Places['PlaceName'] = $row->PlaceName;
                $Places['DistrictID'] = $row->DistrictID;
                $Places['DisplayStatus'] = $row->DisplayStatus;
                $Places['StateID'] = $row->StateID;
                $Places['pincode'] = $row->pincode;
                $Places['delivery_fee'] = $row->delivery_fee;
                $Places['expected_delivery_time'] = $row->expected_delivery_time;
                return json_encode($Places);
            }
        }

        public function SavePlace($dataToSave) {
            if($this->PlaceExist($dataToSave['PlaceName']))
                return 3; //"Data already exist";
            if($this->db->insert('places',$dataToSave))
                return 1; //"Data Saved Successfully";
            else
                return 2; //"Failed to save ";
        }

        public function PlaceExist($PlaceName) {
            $query = $this->db->get_where('places', array('PlaceName' => $PlaceName, 'is_deleted =' => 0 ));
            if($query->num_rows() > 0)
                return true;
            else
                return false;
        }

        public function CheckPlaceExistForUpdation($PlaceName, $PlaceID) {
            $this->db->where(array('PlaceName =' => $PlaceName, 'PlaceID !=' => $PlaceID, 'is_deleted =' => 0));
            $query = $this->db->get('places');
            if($query->num_rows() > 0)
                return true;
            else
                return false;
        }

        public function DeletePlace($placeID) {
            $this->db->where('PlaceID', $placeID);
            if($this->db->update('places',array('is_deleted' => 1))) {
                return true;
            }
            else {
                return false;
            }
        }

        public function UpdatePlace($dataToUpdate, $placeID) {
            if($this->CheckPlaceExistForUpdation($dataToUpdate['PlaceName'], $placeID))
                return 3; //"Data already exist";
            $this->db->where('PlaceID', $placeID);
            if($this->db->update('places',$dataToUpdate)) {
                return 1; //"Data updated Successfully";
            }
            else {
                return 2; //"update failed";
            }
        }
    }
?>
