<?php
   session_start();
   if(isset($_SESSION["logged"]) and $_SESSION["logged"]){ 
     header("Location: users.php");
     die();
   }
 if($_SERVER["REQUEST_METHOD"] === "POST"){
 include_once("includes/conn.php");
 if(isset($_POST["registration"])){
 try{
    $sql="INSERT INTO `users`(  `fullName`, `userName`, `email`, `password`) VALUES (?,?,?,?)";
    $fullname=$_POST["name"];
    $userName=$_POST["username"];
    $email=$_POST["email"];
    $password =password_hash($_POST["password"], PASSWORD_DEFAULT) ;
    $stmt=$conn->prepare($sql);
    $stmt->execute([$fullname,$userName,$email,$password]);
    header("Location: login.php");
    die();
    
}catch(PDOException $e){
   echo "Connection failed: " . $e->getMessage();
}
}
elseif(isset($_POST["login"])) {
    try{
      $sql = "SELECT `password` FROM `users` WHERE `userName` = ?";
      $username = $_POST["user"];
      $password = $_POST["pass"];
      $stmt = $conn->prepare($sql);
      $stmt->execute([$username]);
      if($stmt->rowcount() > 0){
        $result = $stmt->fetch();
        $hash = $result["password"];
        $verify = password_verify($password, $hash);
        if($verify){
          $_SESSION["logged"] = true;
          header("Location:News.php");
          die();
        }else{
          echo  '<div class="alert alert-warning alert-dismissible fade show"  role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
          <strong>Holy guacamole!</strong> please enter correct password.
        </div>';
        }
      }else{
        echo  '<div class="alert alert-danger">please enter correct email </div>';
      }
    }catch(PDOException $e){
        echo "Connection failed: " . $e->getMessage();
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <style>
       
    </style>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>News Admin | Login/Register</title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
              <h1>Login Form</h1>
              <div>
                <input type="text" class="form-control" name="user" placeholder="Username" required="" />
              </div>
              <div>
                <input type="password" class="form-control" name="pass" placeholder="Password" required="" />
              </div>
              <div>
              <button type="submit"  name="login">Submit</button>
                <a class="reset_pass" href="#">Lost your password?</a>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">New to site?
                  <a href="#signup" class="to_register"> Create Account </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-newspaper-o"></i></i> News Admin</h1>
                  <p>©2016 All Rights Reserved. News Admin is a Bootstrap 4 template. Privacy and Terms</p>
                </div>
              </div>
            </form>
          </section>
        </div>

        <div id="register" class="animate form registration_form">
          <section class="login_content">
            <form  action="" method="POST">
              <h1>Create Account</h1>
              <div>
                <input type="text" class="form-control"  name="name" placeholder="Fullname" required="" />
              </div>
              <div>
                <input type="text" class="form-control"   name="username" placeholder="Username" required="" />
              </div>
              <div>
                <input type="email" class="form-control"  name="email" placeholder="Email" required="" />
              </div>
              <div>
                <input type="password" class="form-control"   name="password" placeholder="Password" required="" />
              </div>
              <div>
              <button type="submit" name="registration">Submit</button>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">Already a member ?
                  <a href="#signin" class="to_register"> Log in </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-newspaper-o"></i></i> News Admin</h1>
                  <p>©2016 All Rights Reserved. News Admin is a Bootstrap 4 template. Privacy and Terms</p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
  </body>
</html>
