
<html>
    <head>
      <meta name="csrf_token" content="{{ csrf_token()}}">
      <?php include('../libraries/style.php') ?>
        <style>
            .gradient-custom {
            background: #6a11cb;
            background: -webkit-linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1));
            background: linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1))
            }
            .form-label {
            text-align: left;
            display: block;
        }
        </style>
        <title>Meta-X</title>
    </head>
    <body>
        <section class="vh-100 gradient-custom">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                  <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                      <div class="card-body p-5 text-center">
            
                        <div class="mb-md-5 mt-md-4 pb-5">
                            <img src="../img/system/logo.png" alt="logo" width="70px" class="mb-2">
                            <h2 class="fw-bold mb-4 text-uppercase">Meta-X</h2>
                          <h5 class="fw-bold mb-2  text-uppercase">Sign Up</h5>
                          <p class="text-white-50 mb-5">Please enter your details to create Account</p>    

                    <form id="register_form" action="#" method="post" enctype="multipart/form-data">
                    
                      <div class="row align-items-start">
                            <div class="mb-3 col-md-6" >
                                <label for="firstname" class="form-label">First name</label>
                                <input type="text" class="form-control" id="firstname" name="firstname" >
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="lastname" class="form-label">Last Name</label>
                                <input type="text" class="form-control" name="lastname" id="lastname" required>
                            </div>
                      </div>
                        <div class="mb-3 col-md-12">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" name="username" id="username" required >
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="email" required>
                        </div>
                        <div class="row mb-1">
                            <div class="mb-3 col-md-6">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" id="password" required >
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="conPassword" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" name="conPassword" id="conPassword" required>
                            </div>
                        </div>
                        <label for="gender" class="form-label">Gender</label>
                        <div class="row mb-4">
                            <div class="col-md-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="male" value="male" required>
                                    <label class="form-check-label" for="male">Male</label>
                                </div>
                                        
                            </div>
                            <div class="col-md-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="female" value="female" required>
                                    <label class="form-check-label" for="female">Female</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-5">
                            <div class="mb-3">
                                <label for="profile_pic" class="form-label">Profile Picture</label>
                                <input class="form-control" type="file" id="profile_pic" name="profile_pic">
                            </div>
                        </div>
                        
                          <Button id="btnSubmit" class="btn btn-outline-light btn-lg px-5 mb-0" type="submit">Sign Up</button>
                        </div>
                    </form>
                    <p class="mb-0">Do you have an account? <a href="./login.php" class="text-white-50 fw-bold">Login</a>
                    </p>
                        <div>  
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </section>

         
           <?php include('../libraries/script.php') ?>
      

            

            <script>
                $(document).ready(function() {
                    $('#register_form').submit(function(e) {
                        e.preventDefault();
        
                        var password = $('#password').val();
                        var conPassword = $('#conPassword').val();
                        var isValid = false;
        
                        if (password.trim() === conPassword.trim()) {
                            isValid = true;
                        }
        
                        if (isValid) {
                            const fd = new FormData(this);
        
                            $.ajax({
                                url: '../php/signup-process.php',
                                method: 'post',
                                data: fd,
                                cache: false,
                                contentType: false,
                                processData: false,
                                dataType: 'json',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Ensure CSRF token is included
                                },
                                success: function(response) {
                                    if (response.status === 200) {
                                        Swal.fire({
                                            position: "center",
                                            icon: "success",
                                            title: "Registration Successful!",
                                            showConfirmButton: false,
                                            timer: 1500
                                        }).then(() => {
                                            window.location.replace("../");
                                        });
                                    } else if(response.status === 201){
                                        Swal.fire({
                                            icon: "error",
                                            title: "Oops...",
                                            text: "This email already exist. Try with another email.!",
                                        });
                                    } else if(response.status === 202){
                                        Swal.fire({
                                            icon: "error",
                                            title: "Oops...",
                                            text: "This username already exist. Try with another username.!",
                                        });
                                    } else if(response.status === 203){
                                        Swal.fire({
                                            icon: "error",
                                            title: "Oops...",
                                            text: "Registration Error.!",
                                        });
                                    }
                                },
                                error: function(response) {
                                    Swal.fire({
                                        icon: "error",
                                        title: "Oops...",
                                        text: response.responseText,
                                    });
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "Password and Confirm Password doesn't match.!",
                            });
                        }
                    });
                });
            </script>
    </body>
</html>

    