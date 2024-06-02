<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <title>Logimo</title>
    <?php
    include('include/config.php');
    ?>
    <script src="style/js/jquery.js"></script>
    <link rel="stylesheet" href="style/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/7.1.96/css/materialdesignicons.min.css" integrity="sha512-NaaXI5f4rdmlThv3ZAVS44U9yNWJaUYWzPhvlg5SC7nMRvQYV9suauRK3gVbxh7qjE33ApTPD+hkOW78VSHyeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="style/js/login.js" defer></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <style>
        input{
            color: var(--secondary);
        }
    </style>
</head>
<body>
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="row w-100 m-0">
            <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
                <div class="card col-lg-4 mx-auto">
                    <div class="card-body px-5 py-5">
                        <div style="width: 100%; text-align: center;">
                            <h1>Logimo</h1>
                        </div>
                        <form>
                            <div class="form-group">
                                <label for="email_input">Email</label>
                                <input type="email" class="form-control p_input" id="email_input">
                                <div data-lastpass-icon-root="true"
                                     style="position: relative !important; height: 0px !important; width: 0px !important; float: left !important;"></div>
                                <div data-lastpass-icon-root="true"
                                     style="position: relative !important; height: 0px !important; width: 0px !important; float: left !important;"></div>
                            </div>
                            <div class="form-group">
                                <label for="password_input">Password</label>
                                <input type="password" class="form-control p_input" id="password_input">
                                <div data-lastpass-icon-root="true"
                                     style="position: relative !important; height: 0px !important; width: 0px !important; float: left !important;"></div>
                                <div data-lastpass-icon-root="true"
                                     style="position: relative !important; height: 0px !important; width: 0px !important; float: left !important;"></div>
                            </div>
                            <div class="captchaR" style="text-align: center">
                                <div class="g-recaptcha" data-sitekey="6Lcb2w0gAAAAAHuidaQ1moOAE1l5OAHobm1SDnYS" data-theme="dark" style="display: inline-block;"></div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-block enter-btn">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- row ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
</body>
</html>