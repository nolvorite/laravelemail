<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="/js/parsley.min.js"></script>
    <title>Send An Email!</title>
  </head>
  <body>
    

    <form method="POST" action="/submit_email" id="email_form" enctype="multipart/form-data">

      <div class="container">
          <div class="row">
          <div class="col-sm-12"><h1>Send An Email!</h1></div>
        <div class="col-md-4">
          <div class="form-group">

            <label>Email Subject</label>
            <input class="form-control" name="subject" data-parsley-required>

            <label>Email Recipient</label>
            <input class="form-control" name="recipient" data-parsley-type="email" data-parsley-required>

            <label>Email CC</label>
            <input class="form-control" name="cc" placeholder="CC. Separate by commas">

          </div>
        </div>
        <div class="col-md-8">
          <div class="form-group">
            <label>Content</label>
            <textarea name="content" class="form-control" rows="10" data-parsley-required></textarea>
          </div>
          <div class="form-group">
            <input type="submit" class="btn btn-primary" id="submit_mail" value="Submit Email!">
          </div>
        </div>
      </div>
      </div>
    </form>

    <script type="text/javascript">
      $(document).ready(function (e) {
        $("#email_form").on('submit',function(e) {
          e.preventDefault();

          //form validation first and foremost

          isValid = true;

          reqs = $("input[name=subject],input[name=recipient],textarea[name=content]"); 
          checks = reqs.parsley();

          allErrors = [];


          for(i = 0; i < checks.length; i++){ console.log(checks[i].isValid());
            if(!checks[i].isValid()){
              isValid = false;
              errors = checks[i].getErrorsMessages();
              for(j = 0; j < errors.length; j++){
                allErrors[allErrors.length] = errors[j];
              }
            }
          }

          $("#modal-alert").modal();

          if(isValid){

            data = new FormData($("form#email_form")[0]);

            

            $.ajax({
              url: $(this).attr("action"),
              type: "POST",
              data:  data,
              contentType: false,
              cache: false,
              dataType: 'json',
              processData: false,
              success: function(data){
                console.log(data);
                $("#modal-alert .modal-body").html(data.message);
                $("#modal-alert .modal-footer").removeClass("d-none");
              },
              error: function(errormsg){
                $("#modal-alert .modal-body").html("Error Sending Email.");
                $("#modal-alert .modal-footer").removeClass("d-none");
              }
            });         

          }else{
            message = "<ul>";
            console.log(allErrors);
            for(i = 0; i < allErrors.length; i++){

              message += "<li>"+allErrors[i]+"</li>";
            }
            message += "</ul>";
            $("#modal-alert .modal-body").html("Validation Errors:" +message);
            $("#modal-alert .modal-footer").removeClass("d-none");
          }

        });

        $("#modal-alert").on("hidden.bs.modal",function(){
          $(this).find(".modal-body").html("Loading...");
          $(this).find(".modal-footer").addClass("d-none");
        });

      });      

    </script>

    <div class="modal" tabindex="-1" role="dialog" id="modal-alert">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Notice</h5>
          </div>
          <div class="modal-body">
            Loading... 
          </div>
          <div class="modal-footer d-none">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>


  </body>
</html>