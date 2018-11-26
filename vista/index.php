<?php 

?>

                  
 <nav class="navbar navbar-expand-lg navbar-dark indigo">
  <div class="container">
  
  
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02"
    aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
    <ul class="navbar-nav mr-auto mt-lg-0">
      
      <li class="nav-item">
      <a class="nav-link  btn-elegant " data-toggle="modal" data-target="#basicExampleModal">
     User - Setting
      </a>
      </li>
      
    </ul>
  </div>
  <span class="navbar-text white-text">
  <a class="nav-link  btn-elegant " href="logout.php">Log out</a>
       

    </span>
  </div>
  
</nav>    

<div class="container">

<div class="row align-items-center justify-content-center center" >
    <h3>Loggin Attempt</h3>
<table class="table">


  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">IP</th>
      <th scope="col">Time</th>
      <th scope="col">Attempt</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach($this['Attempt'] as $Attempt): ?>
    <tr <?php  if($Attempt['valid']=='1')  echo ('class="table-success"');
        else  echo ('class="table-danger"') ?> >
    <th scope="row"><?php echo $Attempt['id'] ?></th>
      <td><?php echo $Attempt['ip'] ?></td>
      <td><?php echo $Attempt['ts'] ?></td>
      <td><?php if($Attempt['valid']=='1')  echo 'Valid';
        else  echo ('Denied') ?></td>

    </tr>
  <?php endforeach ?>
  </tbody>
</table>
</div>


</div>


<!-- Modal -->
<div class="modal fade" id="basicExampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Settings</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
  <!-- Form -->
  <span id='statusMsg' ></span>
  <form class="text-center" style="color: #757575;" id='updateform'>
      <!-- Email -->
      <div class="md-form">
        <input type="email" id="Email" class="form-control" onkeyup="email(this)" value="<?php echo($_SESSION['userdata']['email']) ?>">
        <label for="Email">E-mail</label>
      </div>

      <!-- Password -->
      <div class="md-form">
        <input type="password" id="Password" class="form-control" value="<?php echo($_SESSION['userdata']['password']) ?>">
        <label for="Password">Password</label>
      </div>

        <input type="hidden" id="hash" value ="<?php echo($_SESSION['userdata']['hash']) ?>">
        <input type="hidden" id="id" value ="<?php echo($_SESSION['userdata']['id']) ?>">
        <span id='emailmsg' ></span>
    </form>
    <!-- Form -->
      </div>
  
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" onclick='UpdateData()' id="submitBtn" class="btn btn-primary">Save changes</button>

      </div>
    </div>
  </div>
</div>

<script>  
function email(data)
{

  let re = /\S+@\S+\.\S+/;
  let email = re.test(data.value);


    if(!email)
    {
      $('#submitBtn').attr("disabled","disabled");
      $('#emailmsg').html('<span style="font-size:18px;color:red">Used a valid email</span>');
    }else{
      $("#submitBtn").removeAttr("disabled");
      $('#emailmsg').html('');
    }
}


function UpdateData() {
  
  let  email      = $('#Email').val();
  let  password  = $('#Password').val();
  let  id = $('#id').val();
  let  hash = $('#hash').val();
 

    console.log(id);

    //creamos array de parámetros que mandaremos por POST
    let params = {
      "email" : email,
      "password": password,
      "id" : id,
      "hash" : hash
    };
    console.log(params);

      $.ajax({
            type: 'POST',
            url: 'update.php',
            data: params,
         
            beforeSend: function(){
                $('#submitBtn').attr("disabled","disabled");
                $('#updateform').css("opacity",".5");
            },
            success: function(msg){
                $('#statusMsg').html('');
                if(msg == 'Sent'){
                    $('#updateform')[0].reset();
                    $('#statusMsg').html('<span style="font-size:18px;color:#34A853">Check your email to validate the update.</span>');
                }else{
                    $('#statusMsg').html('<span style="font-size:18px;color:#EA4335">Some problem occurred, please try again.</span>');
                }
                $('#updateform').css("opacity","");
                $("#submitBtn").removeAttr("disabled");
            }
         
        });
}

</script>