<?php


session_start();
include('./routes/router.php');
include ('./classes/Profile.php');
include('./Classes/Database.php');
global $DB;
global $con;

      $Signup = new Profile();
      $DB = new Database(); //instantiation
      $DB->connectDB();
      if (isset($_REQUEST['btn'])) {
        $Signup->SignUpAccount($_REQUEST);
        exit();
      

      }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" href="./css/signupform.css"/>
</head>
<body>


    <div class="parent_container">

    <div class="left-container">
         <form action ="" method="POST">

            <div class="heading">
                        <div class="create">
                <h1>Create your Account.</h1>

                        </div>
                <div class="create " >
                  <a href="./logins.php" class="btn_tologin">Login</a>
                </div>


            </div>
                    <div class="wrapper">
        
                    <div class="div">
                    
                    
                            <?php if (isset($_GET['error'])) { ?>
                            <p class="error"> <?php echo $_GET['error']; ?></p>
                        <?php }?>

                        

                        <label>Username</label><br/>
                        <input type = "text" name="username" placeholder="username"><br/>
                        
                        <label>Password</label><br/>
                        <input type = "password" name="password" placeholder="password"><br/>

                        

                        <button class="login-btn" name="btn" id="btn">SUBMIT</button><br/>
                        
                      
                

                    </div>
                        

                    </div>    
        
            </form>
    </div>
    <div class="right-container">
     
    </div>

    
       



    </div>

    <script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('myForm').addEventListener('submit', function() {
        // Reset form fields after submission
        document.getElementById('myForm').reset();
    });
});
</script>
 
</body>
</html>