<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="section no-pad-bot" id="index-banner">
    <div class="container">
      <div class="row">
        <form class="col s12 home_form">
          <div class="row">
            <div class="input-field col s4 offset-s1">
              <input id="last_name" name="title" type="text" class="validate"  minlength="3" maxlength="20"  pattern=".{3,20}" required  title="min chars - 3, max  - 20">
              <label for="last_name">Task title</label>
            </div>
            <div class="input-field col s4">
              <input id="deadline" name="deadline" type="date" class="datepicker validate" required>
              <label for="deadline">Deadline</label>
            </div>
            <div class="input-field col s3 add_task">
              <input type="submit" class="btn-large waves-effect waves-light orange" value="Addtask">
            </div>
          </div>
        </form>
      </div>
      <h4 class="center">Total tasks: <span class="total_tasks"><?php echo $task["total"]; ?></span></h4>
      <table class="highlight centered bordered">
        <thead>
          <tr>
              <th data-field="id">Status</th>
              <th data-field="name">Task title</th>
              <th data-field="price">Deadline</th>
          </tr>
        </thead>
        <tbody class="home_table">
          <?php echo $task["output"]; //print data from get_tasks_list() ?>
        </tbody>
      </table>
    </div>
  </div>
