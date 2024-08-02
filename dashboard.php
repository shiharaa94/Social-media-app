
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
    <style>
        #loader {
            text-align: center;
            margin: 20px 0;
        }
        .upload-container {
            border: 2px dashed #ccc;
            padding: 20px;
            text-align: center;
            width: 300px;
            margin: 0 auto;
            border-radius: 10px;
            position: relative;
            cursor: pointer;
        }

        .upload-container:hover {
            background-color: #f9f9f9;
        }

        .file-input {
            display: none;
        }

        .file-preview {
            margin-top: 10px;
        }

        .file-preview img, .file-preview video {
            max-width: 100%;
            max-height: 200px;
            margin-top: 10px;
            border-radius: 5px;
        }

        .remove-file {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: red;
            color: white;
            padding: 5px;
            border: none;
            border-radius: 50%;
            cursor: pointer;
        }
    </style>
    <title>Meta-X</title>
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
                <!--post creation area-->
                <div class="card glass-effect mb-2">
                    <div class="row">
                        <div class="col-md-2" style="min-width: 80px;text-align:center;margin-left:5px;">
                            <img src="img/Profilepic/<?php echo $_COOKIE['logged_profilePic'] ?>" alt="profile_Image"  class=" mt-1 mb-1 ml-4" style="width: 75px; border-radius:50%;">
                        </div>

                        <div class="col-md-9">
                        <button type="button" id="btn_newPost" class="form-control glass-effect mt-3"  data-bs-toggle="modal" data-bs-target="#create_Modal">What's on your mind, <?php echo $_COOKIE['logged_username']; ?> </button>
                        </div>
                    </div>
                        
                </div>
                <!--!post creation area-->

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
    
<!-- Post Create modal-->
<div class="modal fade" id="create_Modal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered " role="document">
    <div class="modal-content glass-effect text-white">
      <div class="modal-header">
        <h5 class="modal-title" id="createModalLabel">Create Post</h5>
        <button type="button" class=" btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"></span>
        </button>
      </div>
      <div class="modal-body">
        <form action="#" id="post_Create_Form" method="post" enctype="multipart/form-data">
            <textarea class="form-control mb-3 glass-effect" id="description" name="description" placeholder="What's on your mind, <?php echo $_COOKIE['logged_username']; ?>" rows="3"></textarea>
            <div class="upload-container" id="uploadContainer">
              <p>Drag & drop a photo or video, or click to select files</p>
              <input type="file" id="fileInput" name="file" class="file-input" accept="image/">
              <div class="file-preview" id="filePreview"></div>
            </div>
        
          </div>
          <div class="modal-footer">
            <input type="submit" id="btn_post" value="POST" class="btn btn-primary" width="100%">
          </div>
      </form>
    </div>
  </div>
</div>
<!-- !Post Create modal-->


<?php include 'libraries/script.php' ?>

<script src="js/post-process.js"></script>

<script>
    $(document).ready(function() {
  
        // Load friend list
        function fetchFriends() {
            $.ajax({
                url: 'php/fetch_friends.php',
                method: 'GET',
                success: function(response) {
                    try {
                        //console.log('Raw response:', response);
                        const friends = response;  // Parse response as JSON
                        //console.log('Parsed friends:', friends);

                        if (Array.isArray(friends)) {  // Check if friends is an array
                            if (friends.length > 0) {
                                let friendsHtml = '';
                                friends.forEach(friend => {  // Use singular variable name
                                    friendsHtml += `
                                        <div>
                                            <span class="text-white">
                                                <img src="img/Profilepic/${friend.profile_pic}" alt="profile-image" style="width: 50px; border-radius: 50%; margin-right: 10px">
                                                ${friend.firstname} ${friend.lastname}
                                            </span>
                                            <hr>
                                        </div>
                                    `;
                                });

                                $('#friends_area').html(friendsHtml);  // Replace content instead of appending
                                
                            } else {
                                // No friends to load, optionally show a message or handle this case
                                $('#friends_area').html('<p>No friends to show.</p>');
                            }
                        } else {
                            throw new TypeError('Expected an array but got ' + typeof friends);
                        }
                    } catch (e) {
                        console.error('Error parsing JSON response:', e);
                    }
                },
                error: function() {
                    console.error('Failed to fetch friends');
                }
            });
        }

        fetchFriends();
    });
</script>

<script>
    $(document).ready(function() {
        $(document).on('click', '.like-me', function(e) {
            e.preventDefault();
            var id = $(this).attr('id');
            $.ajax({
                url: 'php/post-like.php',
                method: 'POST',
                data: { id: id }, 
                cache: false,
                dataType: 'json',
                success: function(response) {
                    if (response.liked === "yes") {
                        $('#' + response.id).attr('src', 'img/system/liked.png');
                        $('#' + response.id + '_likeCount').text('Likes: ' + response.post_likes); 
                    } else {
                        $('#' + response.id).attr('src', 'img/system/like.png'); 
                        $('#' + response.id + '_likeCount').text('Likes: ' + response.post_likes); 
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Failed to fetch likes: ' + textStatus + ', ' + errorThrown);
                }
            });
        });
    });
</script>



<script src="js/post-create.js"></script>

<script>
    //post create photo container modifications
    const uploadContainer = document.getElementById('uploadContainer');
        const fileInput = document.getElementById('fileInput');
        const filePreview = document.getElementById('filePreview');

        uploadContainer.addEventListener('click', () => {
            fileInput.click();
        });

        uploadContainer.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadContainer.style.backgroundColor = '#f9f9f9';
        });

        uploadContainer.addEventListener('dragleave', () => {
            uploadContainer.style.backgroundColor = '';
        });

        uploadContainer.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadContainer.style.backgroundColor = '';
            const files = e.dataTransfer.files;
            handleFiles(files);
        });

        fileInput.addEventListener('change', () => {
            const files = fileInput.files;
            handleFiles(files);
        });

        function handleFiles(files) {
            filePreview.innerHTML = ''; // Clear existing preview
            const file = files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const fileUrl = e.target.result;
                    const fileType = file.type.split('/')[0];
                    let element;
                    if (fileType === 'image') {
                        element = document.createElement('img');
                        element.src = fileUrl;
                    } else if (fileType === 'video') {
                        element = document.createElement('video');
                        element.src = fileUrl;
                        element.controls = true;
                    }
                    filePreview.appendChild(element);

                    // Add remove button
                    const removeButton = document.createElement('button');
                    removeButton.innerText = '×';
                    removeButton.className = 'remove-file';
                    removeButton.onclick = () => {
                        filePreview.innerHTML = '';
                        fileInput.value = ''; // Clear input
                    };
                    uploadContainer.appendChild(removeButton);
                };
                reader.readAsDataURL(file);
            }
        }
</script>


</body>

</html>