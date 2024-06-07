<?php
session_start();
include('./routes/router.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
    <link rel="stylesheet" href="./css/update_eventform.css"/>
    <link rel="stylesheet" href="./css/addevent.css"/>
</head>
<body>

<div class="container">
    <div class="left-container">
        <?php 
            include('./navigation/navigation.php');
        ?>
    </div>

    <div class="right-container">
        <?php
        if(isset($_SESSION['id']) && isset($_SESSION['username'])) {
            if(isset($_POST['update_product_id'])) {
                $product_id = $_POST['update_product_id'];

                include('./classes/Profile.php');
                include('./classes/Database.php');

                $DB = new Database();
                $DB->connectDB();

                $obj = new Profile();
                $product = $obj->GetAllEventsUpdate($product_id);

                // Now $product variable contains the details of the selected product
                // You can use these details to populate the form fields
            } 
        } 

        // Check if $product variable is set and not empty before populating form fields
        if(isset($product) && !empty($product)) {
        ?>
            <div class="events_header_container">
                <div class="events-title">
                    <h1>Update Event</h1>
                </div>
            </div>
            <form action="update_eventfunction.php" method="POST" id="myForm" enctype="multipart/form-data">
                <!-- <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>"> -->
                <div class="parent">
                    <div class="parent-flex">
                        <div class="when-title">
                            <div class="when-icon">
                                <img src="./img/updateevent_icon.png"/>
                            </div>
                            <div class="">
                                <h1>Change what data you will be changing</h1>
                            </div>
                        </div>
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <label for="name">Event Name:</label><br/>
                        <div class="date_time">
                            <input type="text" id="name" name="name" value="<?php echo $product['name']; ?>" required><br><br>
                        </div>
                        <label for="model">Date and Time:</label><br/>
                        <div class="date_time">
                            <input type="date" id="date" name="date" value="<?php echo $product['date']; ?>" required><br><br>
                            <label for="timefrom" class="label">From:</label><br/>
                            <input type="time" id="timefrom" class="time" name="timefrom" value="<?php echo $product['timefrom']; ?>" required><br><br>
                            <label for="timeto" class="label">To:</label><br/>
                            <input type="time" id="timeto" class="time" name="timeto" value="<?php echo $product['timeto']; ?>" required><br><br>
                        </div>
                        <div class="venue_host" style="display: flex;">
                            <div class="venue " style="margin-right: 5%;">
                                <label for="venue">Venue:</label><br/>
                                <input type="text" id="venue" name="venue" value="<?php echo $product['venue']; ?>" required><br><br>
                            </div>
                            <div class="host">
                                <label for="venue">Host Name:</label><br/>
                                <input type="text" name="username" require value="<?php echo htmlspecialchars($_SESSION['username']); ?>"><br/>
                            </div>
                        </div>


                         <label for="product_image">Current Image:</label><br>
                        <?php if (!empty($product['image'])): ?>
                            <img src="<?php echo $product['image'];?>" alt="Current Image" id="product_image"><br>
                        <?php else: ?>
                            <p>No image uploaded</p>
                        <?php endif; ?>
                        <label for="product_image">Insert Image:</label>
                        <input type="file" id="image" name="image" class="product_desc" required><br>
                        <button name="btn" id="btn" class="submit_btn">Update Event</button>
                    </div>
                </div>
            </form>
        <?php
        } else {
           
        }
        ?>
    </div>
</div>

</body>
</html>
