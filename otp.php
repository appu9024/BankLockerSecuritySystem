<?php 
include 'header.php'; 

// Redirect if user is not logged in
if (!isset($_SESSION['username'])) {
    echo "<script>window.location.href='../index.php';</script>";
    exit;
}

require 'connection.php'; // Include DB connection

$user_id = $_GET['id'] ?? null; // Get User ID from URL

if (!$user_id) {
    echo "<script>alert('Invalid User ID!'); window.location.href='previous_page.php';</script>";
    exit;
}

// Fetch user details
$query = "SELECT * FROM user WHERE id = '$user_id'";
$result = mysqli_query($link, $query);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    echo "<script>alert('User not found!'); window.location.href='previous_page.php';</script>";
    exit;
}

$mobile = $user['number']; // Assuming 'number' stores the user's mobile number

// Check if OTP needs to be generated
if (!isset($_SESSION['otp']) || !isset($_SESSION['otp_user_id']) || $_SESSION['otp_user_id'] != $user_id || time() > ($_SESSION['otp_expiry'] ?? 0)) {
    $_SESSION['otp'] = rand(1000, 9999); // Generate new OTP
    $_SESSION['otp_user_id'] = $user_id;
    $_SESSION['otp_expiry'] = time() + 60; // Expiry time set to 60 seconds

    // Send OTP via Fast2SMS API
    $fields = [
        "message" => "Your OTP is: {$_SESSION['otp']}",
        "language" => "english",
        "route" => "q",
        "numbers" => $mobile,
    ];

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($fields),
        CURLOPT_HTTPHEADER => [
            "authorization: CKj0XMBQoDsayTZNWwYkO4Uu9e83lFIS6qEzLfVxdAcGrH5ipnv4WBFJEawxCulgjHbXZK1D2oqsVMey",
            "content-type: application/json"
        ],
    ]);

    $response = curl_exec($curl);
    curl_close($curl);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Verify OTP</title>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        let expiryTime = <?php echo $_SESSION['otp_expiry'] ?? 0; ?>;
        let currentTime = Math.floor(Date.now() / 1000);
        let timeLeft = expiryTime - currentTime;

        let countdownElement = document.getElementById("countdown");
        let otpInput = document.getElementById("otp");
        let verifyBtn = document.getElementById("verify_btn");

        if (!expiryTime) {
            countdownElement.innerHTML = "OTP not generated.";
            otpInput.disabled = true;
            verifyBtn.disabled = true;
        } else if (timeLeft <= 0) {
            countdownElement.innerHTML = "Expired";
            otpInput.disabled = true;
            verifyBtn.disabled = true;
            alert("OTP expired! Please request a new OTP.");
        } else {
            let timerInterval = setInterval(function () {
                if (timeLeft <= 0) {
                    clearInterval(timerInterval);
                    countdownElement.innerHTML = "Expired";
                    otpInput.disabled = true;
                    verifyBtn.disabled = true;
                    alert("OTP expired! Please request a new OTP.");
                } else {
                    countdownElement.innerHTML = timeLeft;
                    timeLeft--;
                }
            }, 1000);
        }
    });
    </script>
</head>
<body class="fix-sidebar">
<div id="wrapper">
  <div id="page-wrapper">
    <div class="container-fluid">
      <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
          <h4 class="page-title">Verify OTP</h4>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="white-box">
            <div class="row">
              <div class="col-md-12">
                <form class="form-material form-horizontal" method="POST">
                  <div class="form-group">
                    <div class="col-md-2">
                      <label>Number<span class="text-danger">*</span></label>
                    </div>
                    <div class="col-md-3">
                      <input type="text" class="form-control" name="number" value="<?php echo htmlentities($_SESSION['otp']); ?>" readonly><br>  //$mobile
                    </div>

                    <div class="form-group">
                        <div class="col-md-2">
                            <label>Enter OTP<span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="otp" name="otp" maxlength="4" required><br>
                        </div>
                        <div class="col-md-3">
                            <p id="timer" style="font-weight: bold; color: red;">
                                OTP expires in: <span id="countdown">60</span> seconds
                            </p>
                        </div>
                    </div>

                  <div class="form-group" style="margin-left:400px">
                    <button type="submit" name="verify_otp" id="verify_btn" class="btn btn-success">Verify OTP</button>
                  </div>
                </form>

                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['verify_otp'])) {
                    $entered_otp = $_POST['otp'];

                    if (isset($_SESSION['otp'], $_SESSION['otp_user_id']) && $_SESSION['otp'] == $entered_otp && $_SESSION['otp_user_id'] == $user_id) {
                        // Update access level
                        $update_query = "UPDATE user SET access = 1 WHERE id = '$user_id'";
                        mysqli_query($link, $update_query);

                        // Log the access event
                        $name = $user['name'];
                        $number = $user['number'];
                        $email = $user['email'];
                        $time = time();

                        $log_query = "INSERT INTO in_logs (name, number, email, time, fin_id) VALUES ('$name', '$number', '$email', '$time', '$user_id')";
                        mysqli_query($link, $log_query);

                        // Clear OTP session after verification
                        unset($_SESSION['otp'], $_SESSION['otp_user_id'], $_SESSION['otp_expiry']);

                        // Redirect to access page
                        echo "<script>alert('OTP Verified! Access Granted.'); window.location.href='access.php';</script>";
                        exit;
                    } else {
                        echo "<script>alert('Invalid OTP. Try again!');</script>";
                    }
                }
                ?>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
