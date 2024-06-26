<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
    <link rel="stylesheet" href="login.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <section class="vh-100">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                
                            <h1 class="mb-5 text-white">Log in</h1>
                            <form action="../php/login_proccess.php" method="post">
                                <div data-mdb-input-init class="form-outline mb-4">
                                    <input name="email" type="email" id="typeEmailX-2" class="form-control form-control-lg" placeholder="Enter Your Email" />
                                </div>
                    
                                <div data-mdb-input-init class="form-outline mb-4">
                                    <input name="password" type="password" id="typePasswordX-2" class="form-control form-control-lg" placeholder="Enter Your Password" />
                                </div>
                    
                                <button data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg btn-block" type="submit">Login</button>
                                </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
</body>
</html>
