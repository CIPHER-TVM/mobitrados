<?php
    require_once('StatesObject.php');
    class StatesModel extends CI_Model
    {
        public function GetAllStates()
        {
            $query = $this->db->get('state');
            $statesList = array(); 
            $serialNo = 0;

            foreach ($query->result() as $row)
            {
                $serialNo++;
                $states = new StatesObject();
                $states->SerialNo = $serialNo;
                $states->StateID = $row->StateID;
                $states->StateName = $row->StateName;
                $states->CountryID = $row->CountryID;
                $states->DisplayStatus = ($row->DisplayStatus == 1) ? "Active" : "De-Active" ;
                $states->EditInnerHTML = '<button id="delete" type="button" class="btn btn-success has-icon btn-xs"><i class="material-icons mr-1">create</i>Edit</button>' ;
                $states->DeleteInnerHTML = '<button id="delete" type="button" class="btn btn-danger has-icon btn-xs"><i class="material-icons mr-1">delete</i>Delete</button>' ;

                array_push($statesList, $states);
            }

            return json_encode($statesList);
        }
        public function GetAllStatesForDataTables()
        {
            $query = $this->db->get('state');
            $statesList = array(); 
            $serialNo = 0;

            foreach ($query->result() as $row)
            {
                $serialNo++;
                $states = new StatesObject();
                $states->SerialNo = $serialNo;
                $states->StateID = $row->StateID;
                $states->StateName = $row->StateName;
                $states->CountryID = $row->CountryID;
                $states->DisplayStatus = ($row->DisplayStatus == 1) ? "Active" : "De-Active" ;
                $states->EditInnerHTML = '<button id="delete" type="button" class="btn btn-success has-icon btn-xs"><i class="material-icons mr-1">create</i>Edit</button>' ;
                $states->DeleteInnerHTML = '<button id="delete" type="button" class="btn btn-danger has-icon btn-xs"><i class="material-icons mr-1">delete</i>Delete</button>' ;

                array_push($statesList, $states);
            }
            return json_encode(array("data" => $statesList));
        }
    }
?>