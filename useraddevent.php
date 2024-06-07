<?php
session_start();
include('./routes/router.php');
include('./navigation/usernavigation.php');

if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    // Generate and store CSRF token in session
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EVENTR!</title>
    <link rel="stylesheet" href="./css/addevents.css"/>
</head>
<body>
    <div class="parent_container">
        <div class="left-container">
            <?php 
                include('classes/Profile.php');
                include('./Classes/Database.php');

                // Ensure the Database class connects to the database
                $DB = new Database();
                $con = $DB->connectDB();

                $profile = new Profile();

                // Check if form submission and token is valid
                if (isset($_POST['btn']) && isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
                    // Process form submission
                   $profile->AddToTableEvents($_POST, $_FILES, $_SESSION['username']); 
                    // Set session variable to indicate form submission
                    $_SESSION['form_submitted'] = true;
                    // Generate new CSRF token to prevent multiple submissions
                    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
                    // Redirect to avoid form resubmission
                    echo '<script>setTimeout(function(){window.location.href="useraddevent.php";}, 1000);</script>';
                }
            ?>
        </div>
        <div class="right-container">
            <div class="events_header_container">
                <div class="events-title">
                    <h1>Book an Event</h1>
                    <p>Fill out the form below to add an event to your planner.</p>
                </div>
                <div class="user_info">
                    <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
                </div>
            </div>
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                
                <div class="parent">
                    <div class="parent-flex">
                        <div class="when-title">
                            <div class="when-icon">
                                <img src="./img/addevent_icon.png"/>
                            </div>
                            <div class="">
                                <h1>When and where will it take place?</h1>
                            </div>
                        </div>
                        <label for="name">Event Name:</label><br/>
                        <div class="date_time">
                            <input type="text" id="name" name="name" required><br><br>
                        </div>
                        <label for="model">Date and Time:</label><br/>
                        <div class="date_time">
                            <input type="date" id="date" name="date" required><br><br>
                            <label for="timefrom" class="label">From:</label><br/>
                            <input type="time" id="timefrom" class="time" name="timefrom" required><br><br>
                            <label for="timeto" class="label">To:</label><br/>
                            <input type="time" id="timeto" class="time" name="timeto" required><br><br>
                        </div>
                        <div class="venue_host" style="display: flex;">
                            <div class="venue " style="margin-right: 5%;">
                                <label for="venue">Venue:</label><br/>
                                <input type="text" id="venue" name="venue" required><br><br>
                            </div>
                            <div class="host">
                                <label for="venue">Host Name:</label><br/>
                                <input type="text" name="username" require value="<?php echo htmlspecialchars($_SESSION['username']); ?>"><br/>
                            </div>
                        </div>
                        <label for="product_image">Insert Image:</label>
                        <input type="file" id="product_image" name="product_image" class="product_desc" required><br>
                        <button name="btn" id="btn" class="submit_btn">Book Event</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

<?php
} else {
    header("Location: loginform.php");
    exit();
}
?>
