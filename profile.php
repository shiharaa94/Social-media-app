
<?php 
require('config/db-config.php');

if(!isset($_COOKIE['logged_user'])) {
    header("location:$domain_name/");
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/style.css"> 
   
    <title>Profile - Meta-X</title>
</head>
<body style="background-color: #26282B">
   
    <!-- navbar -->
     <?php require 'components/navbar.php' ?>
    <!-- !navbar -->

    <div class="container-fluid">
      <div class="row">
          <!-- Left sidebar -->
          <div class="col-md-2 fixed-div left-div   d-none d-md-block glass-effect">
              
              <?php require 'components/left_sidebar.php' ?>

          </div>
          <!-- !Left sidebar -->

          <!-- center area -->
          <div class="col-md-5 center-div " >
                <!--Profile area-->
                <div class="card mb-2">
                    <div class="card card-header " style="height: 150px;background-image: url(img/system/thumbnail.jpg);width:auto;">

                    </div>
                    <div id="profile_area" class="card card-body profile-container" >
                    <!-- profile data will be visible here-->
                        
                    </div>
                </div>
                <!--!profile area-->

                    <!--post area-->
                    <div id="post_area"></div>
                    <button id="loader" class="glass-effect " style="color: white;width:100%;">Load more..</button>
                    <!--post area-->

          </div>
          <!-- !center area -->
          

          <!-- Right sidebar-->
          <div class="col-md-2 fixed-div right-div  glass-effect d-none d-md-block">
              
            <?php require 'components/right_sidebar.php' ?>

          </div>
          <!-- Right sidebar-->

      </div>
      <!-- !Row -->
  </div>
<!-- !Container -->
    
<!-- profile edit modal-->
<div class="modal fade" id="edit_Modal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered " role="document">
    <div class="modal-content glass-effect text-white">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit Profile</h5>
        <button type="button" class=" btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"></span>
        </button>
      </div>
      <div class="modal-body text-white">
        <form action="#" id="profile_edit_Form" method="post" enctype="multipart/form-data">

            
      </form>
    </div>
  </div>
</div>
<!-- !profile edit modal-->


<?php include 'libraries/script.php' ?>

<script src="js/timeline-process.js"></script>

<script src="js/post-like.js" ></script>

<script src="js/profile.js"></script>

</body>

</html>