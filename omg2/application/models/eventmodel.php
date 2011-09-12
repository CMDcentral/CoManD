<?php

class Eventmodel extends CI_Model {

    function projectlist($status=3, $limit=0)
    {
	$this->db->where('project.company', $this->session->userdata('user')->company);
	$this->db->select("jobID, project.jobID as ID, project.name, client.company as client, CONCAT(employee.name, ' ' , employee.surname) as projectManager, budget, startDate, endDate", FALSE);
        $this->db->from('project');
        $this->db->join('employee', 'project.projectManager = employee.id');
        $this->db->join('client', 'project.client = client.id');
	$this->db->order_by('ADDED', 'DESC');
	if ($status !=0)
	 $this->db->where('status', $status);

	if ($limit !=0)
	 $this->db->limit(5);

        $query = $this->db->get();
	return $query->result_array();
    }

    function project_by_client($client)
    {
     	$this->db->where('project.company', $this->session->userdata('user')->company);
	$this->db->where('project.client', $client);
        $this->db->select("jobID, CONCAT('<a href=/event/view/',jobID,'>', project.jobID, '</a>') as ID, project.name, client.company as client,CONCAT(employee.name, ' ' , employee.surname) 
as projectManager, budget, startDate, endDate, STATUS.desc", FALSE);
        $this->db->from('project');
        $this->db->join('employee', 'project.projectManager = employee.id');
        $this->db->join('client', 'project.client = client.id');
        $this->db->join('STATUS', 'project.status = STATUS.statusID');
        $this->db->order_by('ADDED', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }


    function projectlistac($term="")
    {	
     $c = $this->session->userdata('user')->company;
     $query = $this->db->query("SELECT * FROM project WHERE company = $c AND (name LIKE '%$term%' OR jobID LIKE '%$term%')");
     //$this->db->where('project.company', $this->session->userdata('user')->company);
     //$this->db->like('name', $term);
     //$this->db->or_like('jobID', $term);
     //$query = $this->db->get('project');
     return $query->result();
    }

    function clientList($term="")
    {
     $this->db->like('company', $term);
     $this->db->where('companyid', $this->session->userdata('user')->company);
     $query = $this->db->get('client');
     foreach ($query->result_array() as $row)
     {
      $options[$row['id']] = $row['company'];
     }
     return json_encode($query->result_array());
    }

    function employeeList($id=0)
    {
     if ($id == 0) {
      $this->db->where('company', $this->session->userdata('user')->company);
      $this->db->where('active',1);
      $query = $this->db->get('employee');
     }
     else {
      $query = $this->db->query("SELECT `name`, `surname`, `id` FROM (`employee`) WHERE active = 1 AND employee.id NOT IN (SELECT EMPID FROM jobcrew WHERE JOBID = ". $id. ") ORDER BY name ASC"); 
     }
     foreach ($query->result_array() as $row)
     {
      $options[$row['id']] = $row['name'] . " " . $row['surname'];
     }
     return $options;
    }

    function employeeListByProject($id=0, $date)
    {
     $options = array();
     $query = $this->db->query("SELECT `name`, `surname`, `id` FROM (`employee`) WHERE employee.id IN (SELECT EMPID FROM jobcrew WHERE JOBID = ". $id. " AND `date` = '".$date."') ORDER BY name ASC");
     foreach ($query->result_array() as $row)
     {
      $options[$row['id']] = $row['name'] . " " . $row['surname'];
     }
     return $options;
    }


    function statusList()
    {
     $query = $this->db->get('STATUS');
     foreach ($query->result_array() as $row)
     {
      $options[$row['statusID']] = $row['desc'];
     }
     return $options;
    }

    function update($data)
    {
	$this->db->where('company', $data['company']);
	$this->db->where('jobID', $data['jobID']);
        $this->db->update('project', $data);
    }

    function add($data)
    {
	if (empty($data['clientID']))
	{
	 $client['company'] = $data['client'];
	 $data['client'] = $this->Clientmodel->add($client);
	 $contact['companyid'] = $data['client'];
	 $client = $data['client'];
	}
	if (empty($data['clientContactID']))
	{
	 if (!isset($client))
		$client = $data['clientID'];
	 $contact['companyid'] = $client;
         $name = $data['clientContact'];
         $parts = split(" ", $name);   
         $contact['name'] = $parts[0];
     	 $contact['surname'] = $parts[1];
         $data['clientContact'] = $this->Clientmodel->add_contact($contact);
	}

	if (isset($data['clientID']))
	 $data['client'] = $data['clientID'];
	if (!empty($data['clientContactID']))
         $data['clientContact'] = $data['clientContactID'];

        unset($data['clientID']);
        unset($data['clientContactID']);

	if (isset($data['jobID'])) {
	 $this->db->where('jobID', $data['jobID']);
	 $this->db->where('company', $this->session->userdata('user')->company);
	 $this->db->update('project', $data); 
	 return $data['jobID'];
	} else {
	 $id = $this->get_last_id();
	 $data['jobID'] = $id+1;
	 $data['company'] = $this->session->userdata('user')->company;
	 $data['owner'] = $this->session->userdata('user')->id;
	 $this->db->insert('project', $data);
	 return $data['jobID'];
	}
    }

    function get_last_id() {
	$company = $this->session->userdata('user')->company;
	$result = $this->db->query("SELECT jobID FROM project WHERE company = $company ORDER BY jobID DESC LIMIT 1");
	$id = $result->result();
	if (sizeof($id) == 0 )
		return 0;
	else
		return $id[0]->jobID;
    }


    function getCount($status=3)
    {
	$this->db->where('status', $status);
	$this->db->from('project');
	return $this->db->count_all_results();
    }

    function getStatus()
    {
     	$query = $this->db->get('STATUS');
        return $query->result();
    }

    function get($id, $company=0)
    {
	$this->db->where('jobID', $id);
	if ($company ==0)
	 $this->db->where('project.company', $this->session->userdata('user')->company);
	else
	 $this->db->where('project.company', $company);
	$query = $this->db->get('project');
        return $query->result();
	//print_r($query->result());
    }

    function get_quotes($id)
    {
        $this->db->where('jobid', $id);
        $query = $this->db->get('quote');
        return $query->result();
    }

    function get_itinerary($id)
    {
	$this->db->order_by('date', "ASC");
        $this->db->where('project', $id);
        $query = $this->db->get('itinerary');
        return $query->result_array();
    }

	function get_event($date) {
	 $query = $this->db->query("SELECT * FROM jos_eventlist_events WHERE '$date' 
				    BETWEEN dates AND enddates 
				    ORDER BY id DESC");
	 return $query->result();
	}
	
	function feedback($jobid) { 
	 $this->db->where('project', $jobid);
	 $this->db->where('company', $this->session->userdata('user')->company);
	 $this->db->order_by('added', 'DESC');
	 $query = $this->db->get('feedback');
         return $query->result();
        }

}
?>
