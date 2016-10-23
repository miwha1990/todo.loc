<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="section no-pad-bot" id="index-banner">
    <div class="container">
      <table class="highlight centered bordered">
        <thead>
          <tr>
              <th data-field="id">Status</th>
              <th data-field="name">Task title</th>
              <th data-field="price">Deadline</th>
          </tr>
        </thead>

        <tbody class="home_table">
        <?php echo $task["output"]; ?>
        </tbody>
      </table>
      <div class="row">
        <form class="col s6 offset-s3 comment_form">
          <div class="row">
            <div class="input-field col s6">
              <input id="input_text" type="text" name="name" minlength="3" maxlength="20"  pattern=".{3,20}" required  title="min chars - 3, max  - 20">
              <label for="input_text">Enter your name</label>
            </div>
            <div class="input-field col s6 submit_button">
             <input type="submit" class="btn-large waves-effect waves-light orange" value="Submit">
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <textarea id="textarea1" class="materialize-textarea" name="text"  minlength="2"  pattern=".{2,}" required title="min chars - 2"></textarea>
              <label for="textarea1">Enter your comment</label>
            </div>
          </div>
        </form>
      </div>
      <h4 class="center">Comments</h4>
      <section class="comments_section">
        <?php echo $comments;  //print data from get_tasks_list() ?>
      </section>
          
    </div>
  </div>
