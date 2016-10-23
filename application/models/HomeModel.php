<?php
class HomeModel extends CI_Model {

    function __construct(){
        parent::__construct();
    }

    //insert helper
    function save($table, $data){
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    //update helper
    function update($table, $data,$id,$field){
        $this
            ->db
            ->where($field, $id)
            ->update($table, $data);
    }

    // delete task by id (soft delete)
    function delete_item($table,$item_id){
        $this->update(DB_PREFIX.$table, '1', $item_id, "del_status");
    }

    // edit item by id
    function edit_item($table, $data, $task_id){

       $this->update(DB_PREFIX.$table, $data, $task_id, "id");

        $this
            ->db
            ->select('id')
            ->from(DB_PREFIX.$table);

        $query = $this->db->get();
        if ( $query->num_rows() > 0 )
        {
           $result = $query->result_array();
        } else {
            $result = false;
        }
        return $data;

    }
    //add new task
    function add_item($table, $data)
    {
        if($data['title']=="" || $data['deadline']=="") return 0;
        // collecting data
        $new_data = [
            'title' => $data['title'],
            'deadline' =>$data['deadline'],
            'status' => 0,
            'del_status' => '0'
        ];

        $task_id = $this->tM->save(DB_PREFIX.$table, $new_data);

         $query = $this
                        ->db
                        ->select('*')
                        ->from(DB_PREFIX . $table)
                        ->where('id', $task_id)
                        ->get();

        $result = [];
        $records["output"] = "";
        if ( $query->num_rows() > 0 )
        {
            $result = $query->result_array();
            foreach ($result as $item) {
                foreach($item as $key=>$value){
                    $title = "<a class='task_link'  data-id='{$item["id"]}' href='".BASE_URL."/home/task_page/".$item['id']."'>{$item['title']}</a>";
                    $checked = $item['status'] == 1 ? 'checked="checked"' : '';
                    $tr_class = $item['status'] == 1 ? 'class="cross"' : '';
                    $checkbox = "<input type='checkbox' id='check".$item['id']."' {$checked}/><label class='checks' data-id='".$item['id']."' for='check".$item['id']."'></label>";
                }
                $records["output"] .= "<tr ".$tr_class."><td>".$checkbox."</td><td>".$title."</td><td>".$item['deadline']."</td></tr>";
            } 
             $records["total"]  =    $query->num_rows();      
        }
        
        return $records;

    }
    //add new comment
    function add_comment($table, $data)
    {
        $records="";
        if($data['name']=="" || $data['text']=="") return 0;
        $date = new DateTime();
        $data['date'] = $date->format('Y-m-d H:i:sP');

        $comment_id = $this->tM->save(DB_PREFIX.$table, $data);

        $query = $this
                        ->db
                        ->select('*')
                        ->from(DB_PREFIX . $table)
                        ->where('id', $comment_id)
                        ->get();

        if ( $query->num_rows() > 0 )
        {
            $result = $query->result_array();
            foreach ($result as $item) {
                foreach($item as $key=>$value){
                    $name = "<h5><i class='small material-icons'>perm_identity</i> {$item['name']}</h5>";
                    $date_m = "<p><i class='tiny material-icons'>today</i> {$item['date']}</p>";
                    $text = "<p>{$item['text']}</p>";
                }
                $records .= "<article class='row'><div class='col s3'>{$name}{$date_m}</div><div class='col s9'>{$text}</div></article>";
            }            
        }
        
        return $records;

    }

    // get all tasks
    function get_tasks_list($table, $id = null)
    {
        $this->db->select('*');
        $this->db->from(DB_PREFIX . $table);
        $this->db->where('del_status', '0');
        $iTotalRecords = $this->db->count_all_results();

        $records["total"] = $iTotalRecords;
        $records["output"] = "";

        if($iTotalRecords < 1) {return $records;}

        $query = $this
        ->db
        ->order_by('id', 'DESC')
        ->get(DB_PREFIX . $table);
        if($id) {
            $query = $this
                    ->db
                    ->where('id', $id)
                    ->order_by('id', 'DESC')
                    ->get(DB_PREFIX . $table);
        }
        $records['query'] = $id;
        $result = [];
        if ( $query->num_rows() > 0 )
        {
            $result = $query->result_array();
            foreach ($result as $item) {
                foreach($item as $key=>$value){
                    if ($id) {
                        $title = "<h3>".$item['title']."</h3>";
                    } else {
                        $title = "<a class='task_link'  data-id='{$item["id"]}' href='".BASE_URL."/home/task_page/".$item['id']."'>{$item['title']}</a>";
                    }
                    $checked = $item['status'] == 1 ? 'checked="checked"' : '';
                    $tr_class = $item['status'] == 1 ? 'class="cross"' : '';
                    $checkbox = "<input type='checkbox' id='check".$item['id']."' {$checked}/><label class='checks' data-id='".$item['id']."' for='check".$item['id']."'></label>";
                    //
                }
                $records["output"] .= "<tr ".$tr_class."><td>".$checkbox."</td><td>".$title."</td><td>".$item['deadline']."</td></tr>";
                if ($id) $records["title"] = $item['title'];
            }            
        }
        
        return $records;
    }
    // get all commments per task
    function get_comments_list($table, $task_id = null)
    {
        $records = "";
        $result = [];

        $this
            ->db
            ->select('*')
            ->from(DB_PREFIX . $table)
            ->where('task_id', $task_id)
            ->order_by('date', 'ASC');

        $query = $this->db->get();

        
        if ( $query->num_rows() > 0 )
        {
            $result = $query->result_array();
            foreach ($result as $item) {
                foreach($item as $key=>$value){
                    $name = "<h5><i class='small material-icons'>perm_identity</i> {$item['name']}</h5>";
                    $date_m = "<p><i class='tiny material-icons'>today</i> {$item['date']}</p>";
                    $text = "<p>{$item['text']}</p>";
                }
                $records .= "<article class='row'><div class='col s3'>{$name}{$date_m}</div><div class='col s9'>{$text}</div></article>";
            }            
        }
        
        return $records;
    }
}