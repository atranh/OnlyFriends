<?php
session_start();
?>
<!DOCTYPE html>
<html lang = "en">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<body style='background-color: DodgerBlue; text-align:center'>
<nav class="navbar navbar-expand-lg navbar-light bg-primary">
  <a class="navbar-brand" href="#">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Features</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Pricing</a>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="#">Disabled</a>
      </li>
    </ul>
  </div>
</nav>
<a href="MatchMaker.php">test matchmaker page</a>;
<?php
$username = $_SESSION["username"];
echo "<title>$username | Profile</title>";

$db = new mysqli("localhost", "id15345354_memberdb","CPS530Group123-","id15345354_members");
if ($db -> connect_error) {
    echo ("Failed to connect to MySQL: " . $db -> connect_error);
    exit();
}

$prompt = "SELECT * FROM Login WHERE Username = '$username'";
$data = $db->query($prompt);
$row = mysqli_fetch_row($data);
$Name = $row[4];
$LastName =$row[5];
$Gender = $row[6];
$PFP = $row[9];
$Age = $row[10];
$city = $row[8];
$city = explode('|',$city);
$city = $city[2];
$maxage = $row[12];
$interests = $row[13];
$occupation = $row[16];
$bio = $row[17];
echo "<br>";
//profile picture
if ($PFP == 'defaultpic.png'){
    $PFP = 'ProfilePic/'.$PFP;
}

echo "<img src='$PFP' class='rounded-circle' style='display: block; margin-left: auto;margin-right: auto;width:400px;height:400px;border: 2px solid black;'alt='profile'/>";
echo "<div class='h1' style='text-align:center;'>$Name $LastName</div>";
//information table
echo '<table style = "border: 1px solid black;font-size: 32px;	text-align: center;" width = "1000px" cellpadding="15" border="0" align="center">';
?>
<!-- change image -->
<form action="uploadimage.php" method="post" enctype="multipart/form-data">
  Select image to upload:
  <input type="file" name="fileToUpload" id="fileToUpload">
  <input type="submit" value="Upload Image" name="submit">
</form>
<?php
echo '<br><br><tr>
<td><b><u>Likes</u></b></td>
<td><b><u>Age</u></b></td>
<td><b><u>Gender</u></b></td>
</tr>';
echo '<tr>
<td>'.ucfirst($interests).'</td>
<td>'.$Age.'</td>
<td>'.ucfirst($Gender).'</td>
</tr>';
echo '<tr>
<td><b><u>City</u></b></td>
<td> <b><a style=color:black href=https://onlyfriendspage.000webhostapp.com/userdata.php>Edit Details</a></b></td>
<td><b><u>Occupation</u></b></td>
</tr>';
echo '<tr>
<td>'.$city.'</td>
<td> </td>
<td>'.$occupation.'</td>
</tr>
</table>
<a href="userdata.php">EDIT</a>'
;

echo '<br>
<h4>Biography</h4>
<form action="updatebio.php" method="post">
    <textarea rows="10" cols="50" maxlength="300" name="bio">
    '.$bio.'
    </textarea>
    <br>
    <input type="submit" value="Change" name="submit">
</form>';
?>

</body>
</html>