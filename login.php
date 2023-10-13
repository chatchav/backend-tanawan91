<!DOCTYPE html>
<html lang="en">
    <?php include_once "assets/includes/header.html";?>
    
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
        <?php include_once "assets/includes/footer.html";?>
        <script src="/js/login.js"></script>
    </body>
</html>
