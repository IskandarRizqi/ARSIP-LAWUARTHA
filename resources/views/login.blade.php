<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="login/fonts/icomoon/style.css">
    <link rel="stylesheet" href="login/css/owl.carousel.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="login/css/bootstrap.min.css">
    
    <!-- Font Awesome for Eye Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Style -->
    <link rel="stylesheet" href="login/css/style.css">


  </head>
  
  <body>
  
    <form action="{{ route('actionlogin') }}" method="post" autocomplete="on" class='form'>
      @csrf
      <div class="d-lg-flex half">
            <div class="bg order-2 order-md-1" style="background-image: url('login/images/bg_1.png');"></div>
            <div class="contents order-1 order-md-2" style="background-color: white">
                <div class="container">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-md-7">
                            <h3 style="background: linear-gradient(to right,  black); 
                            -webkit-background-clip: text; 
                            color: black; 
                            mix-blend-mode: multiply; text-align: center;" >
                                <strong>ARSIP DIGITAL BANK</strong>
                            </h3>
                            <br>
                        

 
    
                            <div class="form-group first">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" placeholder="your email@gmail.com" name="email" required autocomplete="username" style="border-radius: 5px; padding: 10px; border: 1px solid #b0bec5;">
                            </div>

                            <div class="form-group last mb-3">
                                <label for="password">Password</label>
                                <div class="position-relative">
                                    <input type="password" class="form-control pr-5" id="password" placeholder="Your Password" name="password" required autocomplete="current-password" style="border-radius: 5px; padding: 10px; border: 1px solid #b0bec5;">
                                    <i class="fa fa-eye position-absolute" id="eyeIcon" onclick="togglePassword()" style="top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;"></i>
                                </div>
                            </div>

                            {{-- <div class="mb-3">
                                <div class="g-recaptcha" data-sitekey="6LdBoRMrAAAAAK_KWWfpEieEu2TE7mbFiVxrgRs5"></div>
                                @if ($errors->has('g-recaptcha-response'))
                                    <span class="invalid-feedback d-block">
                                        <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                    </span>
                                @endif
                            </div> --}}
                            
                            <div class="d-flex mb-5 align-items-center">
                                <label class="control control--checkbox mb-0">
                                    <span class="caption" style="color: black">Remember me</span>
                                    <input type="checkbox" name="remember" id="rememberMe"/>
                                    <div class="control__indicator"></div>
                                </label>
                                
                            </div>

                            <button style="background: linear-gradient(to right, #007bff, #0056b3); 
                                        color: rgb(255, 255, 255); 
                                        border: none;" 
                                    type="submit" 
                                    class="btn btn-block btn-primary">
                                Log In
                            </button>

                        </div>
                    </div>
                </div>
            </div>
      </div>
  </form>
  
    <script src="login/js/jquery-3.3.1.min.js"></script>
    <script src="login/js/popper.min.js"></script>
    <script src="login/js/bootstrap.min.js"></script>
    <script src="login/js/main.js"></script>
    <script src='https://www.google.com/recaptcha/api.js' async defer></script>

    <!-- JavaScript for Password Toggle & Remember Me -->
    <script>
        function togglePassword() {
            var passwordInput = document.getElementById("password");
            var eyeIcon = document.getElementById("eyeIcon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
            }
        }

        // Save "Remember Me" state in local storage
        document.addEventListener("DOMContentLoaded", function () {
            const rememberMeCheckbox = document.getElementById("rememberMe");
            const emailInput = document.getElementById("email");
            const passwordInput = document.getElementById("password");

            // Load saved values
            if (localStorage.getItem("rememberMe") === "true") {
                rememberMeCheckbox.checked = true;
                emailInput.value = localStorage.getItem("savedEmail");
                passwordInput.value = localStorage.getItem("savedPassword");
            }

            // Save values when checkbox is clicked
            rememberMeCheckbox.addEventListener("change", function () {
                if (this.checked) {
                    localStorage.setItem("rememberMe", "true");
                    localStorage.setItem("savedEmail", emailInput.value);
                    localStorage.setItem("savedPassword", passwordInput.value);
                } else {
                    localStorage.setItem("rememberMe", "false");
                    localStorage.removeItem("savedEmail");
                    localStorage.removeItem("savedPassword");
                }
            });
        });
    </script>
   

        <script>
            function checkRecaptcha() {
            var response = grecaptcha.getResponse();
            if(response.length == 0) {
                //reCaptcha not verified
                alert("no pass");
            }
            else {
                //reCaptch verified
                alert("pass");
            }
            }

            // implement on the backend
            function backend_API_challenge() {
                var response = grecaptcha.getResponse();
                $.ajax({
                    type: "POST",
                    url: 'https://www.google.com/recaptcha/api/siteverify',
                    data: {"secret" : "(your-secret-key)", "response" : response, "remoteip":"localhost"},
                    contentType: 'application/x-www-form-urlencoded',
                    success: function(data) { console.log(data); }
                });
            }
        </script>
  </body>
</html>
