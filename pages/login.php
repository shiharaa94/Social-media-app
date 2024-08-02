
<html>
    <head>
      <meta name="csrf_token" content="{{ csrf_token()}}">
    <?php include('./libraries/style.php') ?>
        <style>
            .gradient-custom {
            background: #6a11cb;
            background: -webkit-linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1));
            background: linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1))
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
                            <img src="./img/system/logo.png" alt="logo" width="70px" class="mb-2">
                            <h2 class="fw-bold mb-4 text-uppercase">Meta-X</h2>
                          <h5 class="fw-bold mb-2  text-uppercase">Login</h5>
                          <p class="text-white-50 mb-5">Please enter your Email and password!</p>    

                    <form id="login_form" action="#" method="post">
                      
                          <div  class="form-outline form-white mb-4">
                            <p id="Email_validation" class="text-danger"></p>
                            <input type="email" id="email" name="email" class="form-control form-control-lg"  required/>
                            <label class="form-label" for="email">Email</label>
                          </div>
            
                          <div class="form-outline form-white mb-4">
                            <p id="password_validation" class="text-danger"></p>
                            <input type="password" id="password" name="password" class="form-control form-control-lg" required/>
                            <label class="form-label" for="password">Password</label>
                          </div>
            
                          <p class="small mb-3 pb-lg-2"><a class="text-white-50" href="#!">Forgot password?</a></p>
            
                          <button id="btnSubmit" class="btn btn-outline-light btn-lg px-5" type="submit">Login</button>
                        </div>
                    </form>
                        <div>
                          <p class="mb-0">Don't have an account? <a href="./pages/register.php" class="text-white-50 fw-bold">Sign Up</a>
                          </p>
                        </div>
            
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </section>
          <?php 
            include('./libraries/script.php') 
            ?>

            <script>
$(document).ready(function() {
    $('#login_form').submit(function(e) {
        e.preventDefault();

        var emailValue = $('#email').val();
        var passwordValue = $('#password').val();
        var isValid = true;

        $('#Email_validation').html("");  // Clear previous validation message
        $('#password_validation').html("");  // Clear previous validation message

        if (emailValue.trim() === '') {
            $('#Email_validation').html("Email is Required.!");
            isValid = false;
        }
        if (passwordValue.trim() === '') {
            $('#password_validation').html("Password is Required.!");
            isValid = false;
        }

        if (isValid) {
            const fd = new FormData(this);

            $.ajax({
                url: './php/login-process.php',
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
                            title: "Login Successful.!",
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.replace("dashboard.php");
                        });
                        
                    } else if(response.status === 201){
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Username or Password is wrong.!",
                        });
                    } else{
                      Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "internal server error.!",
                        });
                    }
                }
            });
        }
    });
});

            </script>
    </body>
</html>

    