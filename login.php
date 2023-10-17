<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Tanawan91 - Admin</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link href="css/custom.css" rel="stylesheet" />

</head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content" class="bg-login">
                <div class="col-lg-3">
                    <div class="p-4 shadow-lg border-0 rounded-lg mt-5 frm-login">
                        <div class="card-header text-center">
                        <img style="width: 70%;" src="assets/img/new-logo-tanawan91.png" alt="">
                        </div>
                        <div class="card-body">
                            <form id="frm-login" method="post">
                                <div class="form-floating mb-3">
                                    <input class="form-control custom-input-login" id="username" name="username" type="text" placeholder="" />
                                    <label for="username">Email address</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input class="form-control custom-input-login" id="password" name="password" type="password" placeholder="Password" />
                                    <label for="password">Password</label>
                                </div>
                                <p id="txtErr" style="color:red;display:none;text-align:center;"></p>
                                <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                    <a class="small" style="color: #e26330;" href="password.html">Forgot Password?</a>
                                    <button type="submit" class="btn btn-primary custom-btn-login">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="js/slidebar.js"></script>
        <script src="js/ckeditor/ckeditor5-build-classic/ckeditor.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="js/nevbar.js"></script>
        <script src="js/login.js"></script>
    </body>
</html>
