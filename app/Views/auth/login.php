<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/css/styles.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('/bootstrap/css/bootstrap.min.css') ?>">
    <title>Document</title>
</head>

<body style="background-color: #236FB6">
    <div class= "login-logo">
    <img src="/img/logo.png" alt="" width="auto" height="80">
    <a class="text-light" style="text-decoration:none"> Rumah Sakit Gigi dan Mulut Universitas Jember </a> 
	  </div>
    <div class="login-container">
        <?php if (session()->getFlashdata('msg')) : ?>
            <div class="alert alert-danger" role="alert">
                <?= session()->getFlashdata('msg') ?>
            </div>
        <?php endif; ?>
        <div class="card-header" style="text-align:center">
            <a class="navbar-brand text-dark"href="#"><b>  
            LOGIN
            </a> </b>
        </div>
        <form action="<?php echo base_url('/auth') ?>" method="post">
            <div class="input-container">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-container">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script type="text/javascript" src="<?php echo base_url('bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
</body>

</html>