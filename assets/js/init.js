(function($){
  $(function(){

    $('.button-collapse').sideNav();


    $('.datepicker').pickadate({ selectMonths: true, format: 'yyyy-mm-dd' });
    $( "form.home_form" ).on( "submit", function( event ) {
        event.preventDefault(); //prevent autoosubmit
        var data =  $( this ).serialize(); // collect data as string for sending data
        var data_array =  $( this ).serializeArray(); // collect data as array for checking
        var title = data_array[0].value;
        var date_e = data_array[1].value;
        $.ajax({
            type: 'POST',
            url: jq_url+'/home/add_task',
            data: data,
            beforeSend: function(xhr, opts){ //if no input data - abort sending request and display error
                if ((title == "") || (date_e == "")) {
                   xhr.abort();
                   Materialize.toast('Please enter the Task title and date!', 4000)
                };
            },
            success: function(response) { // if all good - output response
              Materialize.toast(response.msg, 4000)
              $( ".home_table" ).prepend(response.item.output);
              $( ".total_tasks" ).html($( ".total_tasks" ).text()*1 + response.item.total)
            },
            error: function(error){ //if server could not make a request display error
              Materialize.toast(error.msg, 4000)
            }

        });
    });

    //Done - undone the task
    $(document).on('click', '.checks',function( event ) {
      
        $(this).prev().toggle(this.checked);
        $(this).parent().parent().toggleClass('cross');
        var state =  $(this).prev().prop( "checked" );
        var id = $(this).data('id');
        data = 'status='+state;
        console.log(jq_url+'/home/edit_task/'+id)
        $.ajax({
              type: 'POST',
              url: jq_url+'/home/edit_task/'+id,
              data: data,
              success: function(response) {
                Materialize.toast(response.msg, 4000)
              },
              error: function(error){
                Materialize.toast(error.msg, 4000)
              }
        });
      
    })

    //adding comment to the task
    $( "form.comment_form" ).on( "submit", function( event ) {
        event.preventDefault();
        var data =  $( this ).serialize();
        var data_array =  $( this ).serializeArray();
        var name = data_array[0].value;
        var text = data_array[1].value;
        var id = $('.checks').data('id');
        $.ajax({
            type: 'POST',
            url: jq_url+'/home/add_comment/'+id,
            data: data,
            beforeSend: function(xhr, opts){
                if ((name == "") || (text == "")) {
                   xhr.abort();
                   Materialize.toast('Please enter all comment fields!', 4000)
                };
            },
            success: function(response) {
              Materialize.toast(response.msg, 4000)
              $( ".comments_section" ).prepend(response.item);
            },
            error: function(error){
              Materialize.toast(error.msg, 4000)
            }

        });
    });

  }); // end of document ready
})(jQuery); // end of jQuery name space