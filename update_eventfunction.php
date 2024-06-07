<?php
session_start();
include('./routes/router.php');

if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id'])) {
        $product_id = $_POST['product_id'];

        // Collect updated product details from the form
        $name = $_POST['name'];
        $date = $_POST['date'];
        $timefrom = $_POST['timefrom'];
        $timeto = $_POST['timeto'];
        $venue = $_POST['venue'];

        // Handle file upload for the event image
        if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
            $image = $_FILES['image']['name'];
            $temp_image = $_FILES['image']['tmp_name'];
            $image_path = './uploaded_image/' . $image; // Adjust this path as per your directory structure

            // Move the uploaded image to the destination directory
            if (move_uploaded_file($temp_image, $image_path)) {
                // Image uploaded successfully, proceed with updating the event
                include('./classes/Profile.php');
                include('./classes/Database.php');

                $DB = new Database();
                $DB->connectDB();

                $obj = new Profile();
                $result = $obj->UpdateEvent($product_id, $name, $date, $timefrom, $timeto, $venue, $image_path);

                if ($result) {
                    echo "Event updated successfully.";
                    // Redirect user to a page indicating success
                    exit();
                } else {
                    echo "Error updating event.";
                    // Redirect user to a page indicating error
                    exit();
                }
            } else {
                echo "Error uploading image.";
                // Redirect user to a page indicating image upload error
                exit();
            }
        } else {
            // Image not uploaded, proceed with updating the event without changing the image
            include('./classes/Profile.php');
            include('./classes/Database.php');

            $DB = new Database();
            $DB->connectDB();

            $obj = new Profile();
            $result = $obj->UpdateEvent($product_id, $name, $date, $timefrom, $timeto, $venue, null); // Pass null for the image path

            if ($result) {
                echo "Event updated successfully.";
                // Redirect user to a page indicating success
                exit();
            } else {
                echo "Error updating event.";
                // Redirect user to a page indicating error
                exit();
            }
        }
    } else {
        // Handle invalid request method or missing product_id
        echo "Invalid request.";
        exit();
    }
} else {
    header("Location: loginform.php");
    exit();
}
?>
