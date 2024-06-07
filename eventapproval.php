<?php
session_start();
include('./routes/router.php');

if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EVENTR!</title>
    <link rel="stylesheet" href="./css/landingpage.css"/>
    <style>
        .image_event {
            width: 100%;
            height: 150px;
            background-color: #ffffff;
            border-radius: 4px;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .image_event img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="parent_container">
        <div class="left-container">
            <?php include('./navigation/navigation.php'); ?>
        </div>
        <div class="right-container">
            <div class="card-container">
                <div class="events_header_container">
                    <div class="events-title">
                        <h1>Accept an Event</h1>
                        <p>Choose an event to Accept or Reject</p>
                    </div>
                </div>

                <?php
                include('./classes/Database.php');
                include('./classes/Profile.php');
                $DB = new Database();
                $DB->connectDB();
                $obj = new Profile();
                $products = $obj->GetAllEvents();

                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_product_id'])) {
                    $obj->ApproveProduct($_POST['delete_product_id']);
                }

                if ($products) {
                    echo "<div class='container'>";
                    foreach ($products as $product) {
                        echo "<div class='venue_container'>";
                         echo "<div class='icon_active'>";
                        echo "<img src='./img/active_icon.png'/>";
                        echo "</div>";
                        echo "<div class='image_event'>";
                            if (!empty($product['image'])) {
                                echo "<img src='{$product['image']}' alt='Event Image' class='images'/>";
                            } else {
                                echo "<p>No image available</p>";
                            }
                        echo "</div>";
                    

                        echo "<div class='venue_name'>";
                        echo "<p>{$product['name']}</p>";
                        echo "</div>";

                        echo "<div class='separator'>";
                        echo "<div class='date_cont'>";
                        echo "<div class='img_cont'>";
                        echo "<img src='./img/calendar.png'/>";
                        echo "</div>";
                        echo "<div class='date_name'>";
                        echo "<p>{$product['date']}</p>";
                        echo "</div>";
                        echo "</div>";

                        echo "<div class='date_cont'>";
                        echo "<div class='img_cont'>";
                        echo "<img src='./img/time.png'/>";
                        echo "</div>";
                        echo "<div class='date_name'>";
                        echo "<p>{$product['timefrom']} to {$product['timeto']}</p>";
                        echo "</div>";
                        echo "</div>";

                        echo "<div class='date_cont'>";
                        echo "<div class='img_cont'>";
                        echo "<img src='./img/location.png'/>";
                        echo "</div>";
                        echo "<div class='date_name'>";
                        echo "<p>{$product['venue']}</p>";
                        echo "</div>";
                        echo "</div>";
                                
                        echo "<div class='date_name'>";
                        echo "<p>{$product['username']}</p>";
                        echo "</div>";

                        echo "</div>";

                        echo "<form method='POST' action=''>";
                        echo "<input type='hidden' name='delete_product_id' value='{$product['id']}'>";
                        echo "<input type='submit' class='approve-button' value='Accept' style='padding: 5px 10px;'>";
                        echo "</form>";
                        echo "</div>";
                    }
                    echo "</div>";
                } else {
                    echo "No products available.";
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>

<?php
} else {
    header("Location: logins.php");
    exit();
}
?>
