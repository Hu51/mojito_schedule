<?php

class Api extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		header('Content-Type: application/json');
	}

	public function getEventData()
	{
		$id    = $this->input->get("id");
		$event = $this->session->userdata('event');

		echo json_encode($event["events"][$id]);
	}
}
