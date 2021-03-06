<?php  
session_start();
if (isset($_SESSION['loggedinTutor']))
{  
    $title = 'My Profile';
    include 'TutorNavBar.php'; 
    include '..\connect.php'; 
    $action = isset($_GET['action'])? $_GET['action'] :'Edit'; 
    $ID = isset($_GET['id']) && is_numeric($_GET['id'])  ?  intval($_GET['id'])  : 0 ;

    $stmt= $con->prepare("SELECT * FROM Tutors WHERE TutorID = ?");
    $stmt->execute(array($ID));
    $row = $stmt->fetch();
    $count = $stmt->rowCount(); 
    
} else  {
  header('location: login.php');
}


  if ($action == 'Edit'){if ($count > 0)
  { 
    ?>

    <h1 class="b text-center">Edit Profile</h1>
    <form action="page5.php?action=Update" method="POST">
    <div class="container">
        <table class="table table-impo table-bordered table-dark wow bounceIn" data-wow-offset="10" data-wow-delay=".3s">
          <thead>
            <tr>
              <th>User Name</th>
              <input type="hidden" name="ID" value="<?php echo $ID  ?>"/>
              <th><input class="e" type="text" name="userName" value="<?php echo $row['UserName'] ?>" autocomplete="off"/></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>FullName</td>
              <td><input class="a" type="text" name="fullname" value="<?php echo $row['FullName'] ?>" autocomplete="off" /></td>
            </tr>
            <tr>
              <th>Password</th>
              <th><input class="e" type="password" name="newpass"  autocomplete="new-password"/></th>
            </tr>
            <tr>
              <td>Confirm Password</td>
              <input type="hidden" name="oldpass" value="<?php echo $row['Password'] ?>"/>
              <td><input class="a" type="password" name="confirmpass" autocomplete="new-password"/></td>
            </tr>
            <tr>
              <th>E-mail</th>
              <th><input class="e" type="email"  value="<?php echo $row['Email'] ?>" name="email"/></th>
            </tr>
            <tr>
              <td>School</td>
              <td><input class="a" type="text" value="<?php echo $row['SchoolName'] ?>" name="school"/></td>
            </tr>
            <tr>
              <th>Mobile Number</th>
              <th><input class="e" type="text"  value="<?php echo $row['MobileNum'] ?>" name="number"/></th>
            </tr>
          </tbody>
        </table>
        <div class="text-center">
        <input type="submit" value="Update" class="btn col-sm-1 wow flash info"/>
        </div>
    </div>
    </form> <?php }} 


        
        //update informationt
        elseif ($action == 'Update')
        {
          if ($_SERVER['REQUEST_METHOD'] == 'POST')
          {  // get var from the form
            $userID = $_POST['ID']; 
            $username = $_POST['userName']; 
            $fullname = $_POST['fullname']; 
            $email = $_POST['email']; 
            $school = $_POST['school']; 
            $number = $_POST['number'];

            //pass trick
            $pass = empty($_POST['confirmpass']) || empty($_POST['newpass']) || $_POST['newpass'] != $_POST['confirmpass'] ?  $_POST['oldpass']  :  sha1($_POST['confirmpass'])  ;
              
            //update database
            $stmt = $con->prepare("UPDATE Tutors SET UserName = ?, FullName = ?, Email =?, MobileNum = ?, SchoolName=?, Password =? WHERE TutorID = ? ");
            $stmt->execute(array($username, $fullname, $email, $number,$school, $pass, $userID));
            
            //success message  
            $msg = "<div class='container alert alert-success'>" .$stmt->rowCount().  " Record  Updated </div>";
            redirect($msg,'back');
            }else{
              $msg = "<div class='container alert alert-danger'>sorry you can't browse this page directly</div>";
              redirect($msg,'back');
            } 
        } ?>


    </header>
    
    
    
    <script src="js/fontawesome-all.min.js"></script>
    <script src="js/jquery.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/wow.min.js"></script>
    <script>
        new WOW().init();

    </script>
    <script src="js/custom.js"></script>
</body>
</html>