<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function debug()
	{
		$this->load->view('header');
		$this->output->append_output('<pre>' . var_export($this->session->get_userdata('event'), true) . '</pre>');
		$this->load->view('footer');
	}

	public function index()
	{
		if (!$this->session->has_userdata('event')) {
			redirect('init');
		}

		$events = $this->session->userdata('event');

		if ($this->input->post("action") == "update") {
			$event = $events["events"][$this->input->post("id")];
			$event["title"]    = $this->input->post("title");
			$event["teachers"] = $this->input->post("teachers");
			$event["dance"]    = $this->input->post("dance");
			$event["level"]    = $this->input->post("level");
			$event["hour"]     = $this->input->post("hour");
			$event["hourEnd"]  = $this->input->post("hourEnd");
			$events["events"][$this->input->post("id")] = $event;

			$this->session->set_userdata('event', $events);
		}

		if ($this->input->post("action") == "delete") {
			unset($events["events"][$this->input->post("id")] );
			$this->session->set_userdata('event', $events);
		}

		$this->load->view('header');
		$this->load->view('edit', [
			'event' => $events
		]);
		$this->load->view('footer');
	}

	public function basic()
	{
		if (!$this->session->has_userdata('event')) {
			redirect('init');
		}

		$event = $this->session->userdata('event');
		if ($this->input->post("update")) {
			$event["title"] = $this->input->post("name");
			$event["url"]   = $this->input->post("url");

			$rooms    = [];
			$newRooms = $this->input->post("rooms");
			foreach ($newRooms as $id => $name) {
				$rooms[] = array(
					"id"    => $id,
					"title" => $this->input->post("rooms")[$id]
				);
			}
			$event["rooms"] = $rooms;

			$levels    = [];
			$newLevels = $this->input->post("levels_name");
			foreach ($newLevels as $id => $name) {
				$styles = $this->input->post("levels_style");
				$values = explode("\n", trim($styles[$id]));
				$style  = [];
				foreach ($values as $val) {
					$style[] = trim($val, "; \r\n");
				}
				$level    = array(
					"title" => $this->input->post("levels_name")[$id],
					"id" => (int)$this->input->post("levels_id")[$id],
					"info"  => $this->input->post("levels_info")[$id],
					"style" => $style
				);
				$levels[] = $level;
			}
			$event["levels"] = $levels;
			$this->session->set_userdata('event', $event);
		}

		$this->load->view('header');
		$this->load->view('basic', [
			'event' => $event
		]);
		$this->load->view('footer');
	}

	public function init_event()
	{
		if ($this->input->post("initType") == "new") {

			$days     = [];
			$fromDate = new DateTime($this->input->post("fromDate"));
			$dayCount = min(10, max(1, (int)$this->input->post("days")));
			for ($i = 0; $i < $dayCount; $i++) {
				$days[] = $fromDate->modify("+1 day")->format("Y-m-d");
			}

			$rooms = [];
			for ($i = 1; $i <= $this->input->post("rooms"); $i++) {
				$rooms[] = array(
					"id"    => $i,
					"title" => "Terem " . $i
				);
			}

			$defEvent = json_decode(file_get_contents(FCPATH ."empty.json"), true);
			$event = array_merge(array(
				"title"  => "Esemény",
				"url"    => "https://google.com",
				"days"   => $days,
				"rooms"  => $rooms,
				"events" => []
			), $defEvent);

			$this->session->set_userdata('event', $event);
		}
		if ($this->input->post("initType") == "restore") {
			$event = json_decode(file_get_contents($_FILES['jsonfile']['tmp_name']), true);
			if (is_array($event)) {
				$this->session->set_userdata('event', $event);
			}
		}
		$this->load->view('header');
		$this->load->view('init_event');
		$this->load->view('footer');
	}


	public function export()
	{
		header('Content-Type: application/json');
		header('Content-Disposition: attachment; filename="events.json"');
		header('Encoding: utf-8');
		echo json_encode($this->session->userdata('event'));

	}
}
