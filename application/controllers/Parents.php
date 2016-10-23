<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Parents extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    function __construct()
    {
        parent::__construct();
        $this->load->model("HomeModel", "tM", true);
    }

    public function index()
    {

    }
    public function get_tasks(){
        echo $this->tM->get_tasks_list('tasks');
    }

    public function add_task()
    {
        $data = $this->security->xss_clean($this->input->post());
        $ret = $this->tM->add_item($data);
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
        $data['status'] = $data['status'] == 'on' ? '1' : '0';
        $ret = $this->tM->edit_item($data,$task_id);
        if($ret > 0 ){
            $this
                ->output
                ->set_status_header(200)
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => true, 'msg' => 'Task successful updated!']));
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
        $data['task'] = $this->tM->getItemInfo('tasks', $task_id);
        $data['comments'] = $this->tM->get_comments_list('comments', $task_id);
        $this->load->view('task_content', $data);
    }
}
