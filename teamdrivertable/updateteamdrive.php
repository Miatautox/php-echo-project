<?php
  //checks if error message exist and if so alerts user
  session_start();
  if (isset($_SESSION['dateError'])){
    echo "{$_SESSION['dateError']}";
    session_destroy(); // close session so the values are erased.
  }
  //checks if there is a session open for driverId in order to bring back the value used from the original selection, from the return page.
   if(isset($_SESSION['teamId'])){
    $teamID = $_SESSION['teamId'];
  };

  include ("../functions.php"); //includes global functions
  if(isset ($_POST["rowID"])) $teamID = $_POST["rowID"];
  //echo "variables have {$rowID}"; //debugging only


  //connect to db
  $dsn = "mysql:host=localhost;dbname=racingleague";
  $userName = "admin";
  $password = "Pa11word";

  try
  {
    $conn = new PDO($dsn,$userName,$password);
    //echo 'Connected to database<br>'; // only to confirm if connected
    // Prepare and execute the statement
    $query = "SELECT * FROM teamdriver WHERE TeamID = {$teamID}";

    foreach ($conn->query($query) as $val)
    {

      $teamID = $val['TeamID'];
      $driverID = $val['DriverID'];


    };

   // echo "<p>ID: {$rowID} - Driver Name: {$driverName} -  DriverDOB {$driverDob}</p>"; // to test input from database

  }
  catch(PDOException $e)
  {
    echo $e->getMessage(); //error message if connection fails
  }



  $conn=null; // close the connection
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Update Team Driver Information</title>
    <meta charset="utf-8">
    <link href="../stylesheets/mainstyle.css" rel="stylesheet" type="text/css"/>
  </head>
  <body>
    <h1>Update Team Driver Information</h1>
    <p>Please enter the information you wish to update below and Submit.</p>
    <table>
      <tr>
        <th>Team ID</th>
        <th>Driver ID</th>
      </tr>
      <tr>
        <!-- <td><?php echo $teamID; ?></td> -->
        <td><?php echo $teamID;?></td>
        <td><?php echo $driverID;?></td>

      </tr>
      <tr>
        <!-- form used to pass information to the confirmupddriver page for varification and update of the database.  -->
        <form id="frmUpdate" action="confirmupdteamdrive.php" method="post">
          <td><input type="hidden" name="inpTeamID" value="<?php echo $teamID ?>">New Values: </td>
          <td><input type="text" name="inpDriverID" placeholder="Driver ID" form="frmUpdate"></td>

        </form>
      </tr>
    </table>
    <input type="submit" form="frmUpdate">
    <button type='button' onclick='location.href="../teamdriverinfo.php"'>Return to Team Driver Info</button>
  </body>
</html>
