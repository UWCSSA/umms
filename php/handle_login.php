<?php
    // seprate mysql authentication information for hosting the project on github
    // mysql_ini.php is supposed to define a variable $con which has connection to the membership mysql database
    include "mysql_ini.php";

    // prepare and bind
    $stmt = $con->prepare(
        "SELECT fname,lname,memid,credit,regdate FROM members
    WHERE email = ? AND password = ?"
    );
    $stmt->bind_param("ss", $email, $password);

    // set parameters and execute
    $email = $_POST["email"];
    $password = $_POST["password"];

    // return result
    if ($stmt->execute()) {
      // get result
      $stmt->bind_result($user_fname, $user_lname, $user_memid, $user_credit, $user_regdate);
      $stmt->fetch();

      // use PHP native GD library to create an e-card image
      $card_width = 400;
      $card_height = 250;
      $name_height_offset = 15; // same as font-size
      $card_height_offset = 24;
      $card_owner_text = strtoupper($user_fname) . "  " . strtoupper($user_lname);
      $register_year = substr($user_regdate, 0, 4);
      $user_memid_padding = $register_year.str_pad(strval($user_memid), 8, "0", STR_PAD_LEFT);
      $card_number_text = substr($user_memid_padding, 0, 4)."  ".
                          substr($user_memid_padding, 4, 4)."  ".
                          substr($user_memid_padding, 8, 4);
      $width_start_position = 0.3;
      if (strlen($card_owner_text) < 16) {
        $width_start_position = $width_start_position + (16 - strlen($card_owner_text))*0.03;
      }
      $image = imagecreatefrompng("../img/card.png");
      // set text color to be white
      $textcolorname = imagecolorallocate($image, 239, 220, 155);
      $textcolorcard = imagecolorallocate($image, 255, 255, 255);
      $fontname = "../img/arial.ttf";
      $fontcard = "../img/kredit_front.ttf";
      // Write the string
      // array imagettftext ( resource $image , float $size , float $angle , int $x , int $y ,
      //                      int $color , string $fontfile , string $text )
      imagettftext($image, $name_height_offset, 0, $card_width*$width_start_position, $card_height*0.72+$name_height_offset,
                   $textcolorname, $fontname, $card_owner_text);
      imagettftext($image, $card_height_offset, 0, $card_width*0.084, $card_height*0.42+$name_height_offset,
                   $textcolorcard, $fontcard, $card_number_text);

      // A walk around to use base64_encode for GD
      ob_start();
      imagepng($image); // no second parameter, will do output instead of writing to file
      $image_base64 = ob_get_clean();
      imagedestroy($image);
  } else {
      header("Location: ../fail.html");
    }
    $stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <!-- mobile support -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UWCSSA Membership Management System - Find Member</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="shortcut icon" href="../img/icon.jpg">
</head>
<body>
    <!-- top navigation bar -->
    <div class="navbar navbar-default navbar-static-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <a href="../index.html" class="navbar-brand">UWCSSA Membership Management System</a>
                <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="navbar-collapse collapse" id="navbar-main">
                <ul class="nav navbar-nav">
                    <li class="active">
                        <a href="../index.html">Register</a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="active"><img src="../img/logo.png" width="110" height="50"></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- account information -->
  <div class="container">
    <?php if ($user_fname !== NULL) { ?>
            <div class="row">
                <div class="col-md-6">
                  <table class="table table-bordered">
                      <tbody>
                          <tr><th class="col-md-2">First Name</th><td class="col-md-6"><?php echo $user_fname?></td></div></tr>
                          <tr><th class="col-md-2">Last Name</th><td class="col-md-6"><?php echo $user_lname?></td></tr>
                          <tr><th class="col-md-2">Member ID</th><td class="col-md-6"><?php echo $user_memid_padding?></td></tr>
                          <tr><th class="col-md-2">Credit</th><td class="col-md-6"><?php echo $user_credit?></td></tr>
                      </tbody>
                  </table>
                </div>
                <div class="col-md-6">
                    <img src="data:image/x-icon;base64,<?php echo base64_encode($image_base64); ?>"></img>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                  <a href="../login.html" class="btn btn-warning" role="button">Logout</a>
                </div>
            </div>
    <?php } else { ?>
      <h5>Account Doesn't Exist Or Incorrect Password!</h5></br>
            <div>
      <a href="../login.html" class="btn btn-warning" role="button">Back</a>
    <?php } ?>
  </div>

    <script type="text/javascript" src="../js/jquery-2.1.1.js"></script>
    <script type="text/javascript" src="../js/bootstrap.js"></script>
    <script type="text/javascript" src="../js/validator.js"></script>
</body>
</html>
