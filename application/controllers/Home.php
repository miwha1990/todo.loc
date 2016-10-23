<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        $this->load->model("HomeModel", "tM", true); //setting model file for get access of its all methods
        $this->title = ' | Daily Tasks'; //set title variable for this controller
    }

	public function index()
	{
		$data['task'] = $this->tM->get_tasks_list('tasks');
        $data['title'] = 'Home'.$this->title ;
		$this->load->view('header', $data);
		$this->load->view('HomeView', $data);
		$this->load->view('footer');
	}
	public function get_tasks(){
        $ret = $this->tM->get_tasks_list('tasks');
        if($ret > 0 ){
            $this
                ->output
                ->set_status_header(200)
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => true, 'msg' => 'List all tasks', 'string' => $ret]));
        }
    }

    public function add_task()
    {
        $data = $this->security->xss_clean($this->input->post()); //secure post data by codeigniter built-in function
        $ret = $this->tM->add_item('tasks', $data);
        if($ret > 0 ){
            $this
                ->output
                ->set_status_header(200)
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => true, 'msg' => 'Task successfully added!', 'item' => $ret]));
        }
        else{
            $this
                ->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => false, 'msg' => 'Could not add task!']));
        }
    }
    public function add_comment($task_id)
    {
        $data = $this->security->xss_clean($this->input->post());
        $data['task_id'] = $task_id;
        $ret = $this->tM->add_comment('comments', $data);
        if($ret != "" ){
            $this
                ->output
                ->set_status_header(200)
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => true, 'msg' => 'Comment added!', 'item' => $ret]));
        }
        else{
            $this
                ->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => false, 'msg' => 'Could not add comment!']));
        }
    }

    public function delete_task()
    {
        $task_id = (int) $this->input->post('id');

        $ret = $this->tM->delete_item('tasks', $task_id);
        if($ret > 0 ){
            $this
                ->output
                ->set_status_header(200)
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => true, 'msg' => 'Task successfully deleted!']));
        }
        else{
            $this
                ->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => false, 'msg' => 'Could not delete task!']));
        }
    }

    public function edit_task($task_id)
    {
        $data = $this->security->xss_clean($this->input->post());
        $data['status'] = ($data['status'] == 'true') ? 0 : 1;
        
  
        $ret = $this->tM->edit_item('tasks',$data,$task_id);
        if($ret > 0 ){
            $this
                ->output
                ->set_status_header(200)
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => true, 'msg' => 'Task successful updated!', 'item' => $ret, 'data' => $data]));
        }
        else{
            $this
                ->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => false, 'msg' => 'Could not update task!']));
        }
    }


    public function task_page($task_id){
        $data['task'] = $this->tM->get_tasks_list('tasks', $task_id);
        $data['title'] = $data['task']['title'].$this->title;
        $data['comments'] = $this->tM->get_comments_list('comments', $task_id);
        $this->load->view('header', $data);
        $this->load->view('TaskView', $data);
        $this->load->view('footer');
    }
}
