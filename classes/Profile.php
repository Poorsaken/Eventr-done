<?php
// require ('database.php');

class Profile{

    



    // function GetAllProducts(){
    //     global $con;
    //     try {
    //         $sql = "SELECT * FROM `tbl_products` ORDER BY id";
    //         $stmt = $con->prepare($sql);
    //         $stmt->execute();

    //         return $stmt->fetchAll(PDO::FETCH_ASSOC);
    //     } catch (PDOException $e) {
    //         echo "Error: " . $e->getMessage();
    //     }
function UpdateEvent($product_id, $name, $date, $timefrom, $timeto, $venue, $image) {
    $con = Database::getConnection(); // Get the database connection
    try {
        $sql = "UPDATE `tbl_allevents` 
                SET name = :name, date = :date, timefrom = :timefrom, timeto = :timeto, venue = :venue, image = :image 
                WHERE id = :product_id"; // Changed placeholder from `:id` to `:product_id`
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':product_id', $product_id); // Ensure the placeholder matches
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':timefrom', $timefrom);
        $stmt->bindParam(':timeto', $timeto);
        $stmt->bindParam(':venue', $venue);
        $stmt->bindParam(':image', $image);
        $stmt->execute();

        $sql = "UPDATE `tbl_approvedevents` 
                SET name = :name, date = :date, timefrom = :timefrom, timeto = :timeto, venue = :venue , image = :image 
                WHERE id = :product_id"; // Changed placeholder from `:id` to `:product_id`
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':product_id', $product_id); // Ensure the placeholder matches
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':timefrom', $timefrom);
        $stmt->bindParam(':timeto', $timeto);
        $stmt->bindParam(':venue', $venue);
         $stmt->bindParam(':image', $image);
        $stmt->execute();

        $sql = "UPDATE `tbl_cancelledevents` 
                SET name = :name, date = :date, timefrom = :timefrom, timeto = :timeto, venue = :venue , image = :image 
                WHERE id = :product_id"; // Changed placeholder from `:id` to `:product_id`
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':product_id', $product_id); // Ensure the placeholder matches
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':timefrom', $timefrom);
        $stmt->bindParam(':timeto', $timeto);
        $stmt->bindParam(':venue', $venue);
         $stmt->bindParam(':image', $image);
        $stmt->execute();

        $sql = "UPDATE `tbl_events` 
                SET name = :name, date = :date, timefrom = :timefrom, timeto = :timeto, venue = :venue , image = :image 
                WHERE id = :product_id"; // Changed placeholder from `:id` to `:product_id`
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':product_id', $product_id); // Ensure the placeholder matches
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':timefrom', $timefrom);
        $stmt->bindParam(':timeto', $timeto);
        $stmt->bindParam(':venue', $venue);
        $stmt->bindParam(':image', $image);
        $stmt->execute();

        return true; // Return true if the update was successful
    } catch (PDOException $e) {
        // Log the error to a file or monitoring system instead of echoing
        error_log("Error: " . $e->getMessage());
        return false; // Return false if there was an error
    }
}


   



   function AddToTableEvents($req, $files, $username) {
    $con = Database::getConnection();

    $name = $req['name'];
    $date = $req['date'];
    $timefrom = $req['timefrom'];
    $timeto = $req['timeto'];
    $venue = $req['venue'];

    // Handle image upload
    $targetDir = "uploaded_image/"; // Relative path to the directory where images will be uploaded
    $fileName = basename($files["product_image"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

    $allowTypes = array('jpg', 'jpeg', 'png', 'gif');
    if (in_array($imageFileType, $allowTypes)) {
        // Check if the directory exists, if not create it
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        // Move the uploaded file to the target directory
        if (move_uploaded_file($files["product_image"]["tmp_name"], $targetFilePath)) {
            try {
                // First SQL statement
                $sql1 = "INSERT INTO `tbl_events` 
                         (username, name, date, timefrom, timeto, venue, image)
                         VALUES 
                         (:username, :name, :date, :timefrom, :timeto, :venue, :image)";

                // Prepare the first statement
                $stmt1 = $con->prepare($sql1);

                // Bind parameters for the first statement
                $stmt1->bindParam(':username', $username);
                $stmt1->bindParam(':name', $name);
                $stmt1->bindParam(':date', $date);
                $stmt1->bindParam(':timefrom', $timefrom);
                $stmt1->bindParam(':timeto', $timeto);
                $stmt1->bindParam(':venue', $venue);
                $stmt1->bindParam(':image', $targetFilePath);

                // Execute the first statement
                $stmt1->execute();

                // Second SQL statement
                $sql2 = "INSERT INTO `tbl_allevents` 
                         (username, name, date, timefrom, timeto, venue, image)
                         VALUES 
                         (:username, :name, :date, :timefrom, :timeto, :venue, :image)";

                // Prepare the second statement
                $stmt2 = $con->prepare($sql2);

                // Bind parameters for the second statement
                $stmt2->bindParam(':username', $username);
                $stmt2->bindParam(':name', $name);
                $stmt2->bindParam(':date', $date);
                $stmt2->bindParam(':timefrom', $timefrom);
                $stmt2->bindParam(':timeto', $timeto);
                $stmt2->bindParam(':venue', $venue);
                $stmt2->bindParam(':image', $targetFilePath);

                // Execute the second statement
                $stmt2->execute();

                echo "<script>alert('Inserted Successfully')</script>";
            } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.";
    }

    // Close the database connection
    $con = null;
}

   function UserAddEvent($req, $files, $username) {
    $con = Database::getConnection();

    $name = $req['name'];
    $date = $req['date'];
    $timefrom = $req['timefrom'];
    $timeto = $req['timeto'];
    $venue = $req['venue'];

    // Handle image upload
    $targetDir = "uploaded_image/"; // Relative path to the directory where images will be uploaded
    $fileName = basename($files["product_image"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

    $allowTypes = array('jpg', 'jpeg', 'png', 'gif');
    if (in_array($imageFileType, $allowTypes)) {
        // Check if the directory exists, if not create it
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        // Move the uploaded file to the target directory
        if (move_uploaded_file($files["product_image"]["tmp_name"], $targetFilePath)) {
            try {
                // First SQL statement
                $sql1 = "INSERT INTO `tbl_events` 
                         (username, name, date, timefrom, timeto, venue, image)
                         VALUES 
                         (:username, :name, :date, :timefrom, :timeto, :venue, :image)";

                // Prepare the first statement
                $stmt1 = $con->prepare($sql1);

                // Bind parameters for the first statement
                $stmt1->bindParam(':username', $username);
                $stmt1->bindParam(':name', $name);
                $stmt1->bindParam(':date', $date);
                $stmt1->bindParam(':timefrom', $timefrom);
                $stmt1->bindParam(':timeto', $timeto);
                $stmt1->bindParam(':venue', $venue);
                $stmt1->bindParam(':image', $targetFilePath);

                // Execute the first statement
                $stmt1->execute();

                // Second SQL statement
                $sql2 = "INSERT INTO `tbl_allevents` 
                         (username, name, date, timefrom, timeto, venue, image)
                         VALUES 
                         (:username, :name, :date, :timefrom, :timeto, :venue, :image)";

                // Prepare the second statement
                $stmt2 = $con->prepare($sql2);

                // Bind parameters for the second statement
                $stmt2->bindParam(':username', $username);
                $stmt2->bindParam(':name', $name);
                $stmt2->bindParam(':date', $date);
                $stmt2->bindParam(':timefrom', $timefrom);
                $stmt2->bindParam(':timeto', $timeto);
                $stmt2->bindParam(':venue', $venue);
                $stmt2->bindParam(':image', $targetFilePath);

                // Execute the second statement
                $stmt2->execute();

                echo "<script>alert('Inserted Successfully')</script>";
            } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.";
    }

    // Close the database connection
    $con = null;
}






      

 // Ensure you include the correct path to your Database class file

function SignUpAccount($req) {
    $con = Database::getConnection(); // Get the database connection

    $username = $req['username'];
    $password = $req['password'];

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Prepare SQL and bind parameters
        $sql = "INSERT INTO `tbl_login` (username, password) VALUES (:username, :password)";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashedPassword);

        // Execute the query
        $stmt->execute();

        // Success alert and redirection
        echo "<script>alert('Inserted Successfully'); window.location.href='signup.php';</script>";
        exit(); // Ensure no further code is executed after redirection

    } catch (PDOException $e) {
        // Output a JavaScript snippet to trigger an alert for error
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
}




 function GetAllEvents(){
    $con = Database::getConnection();
    try {
        $sql = "SELECT * FROM `tbl_events` ORDER BY id";
        $stmt = $con->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

function GetAllEventsUpdate($product_id){
      $con = Database::getConnection();
    try {
        $sql = "SELECT * FROM `tbl_allevents` WHERE id = :product_id";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}



 function GetAllApprovedEvents(){
    $con = Database::getConnection();
    try {
        $sql = "SELECT * FROM `tbl_allevents` ORDER BY id";
        $stmt = $con->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

 function GetAllApprovedEvents1(){
    $con = Database::getConnection();
    try {
        $sql = "SELECT * FROM `tbl_approvedevents` ORDER BY id";
        $stmt = $con->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

 function GetAllEventsLNG(){
    $con = Database::getConnection();
    try {
        $sql = "SELECT * FROM `tbl_allevents` ORDER BY id";
        $stmt = $con->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}


 function GetAllApprovedEventsByUser($username){
    $con = Database::getConnection();
    try {
        $sql = "SELECT * FROM `tbl_approvedevents` WHERE username = :username ORDER BY id";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}


 function ViewCancelledEvents(){
    $con = Database::getConnection();
    try {
        $sql = "SELECT * FROM `tbl_cancelledevents` ORDER BY id";
        $stmt = $con->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

 function UserViewCancelledEvents($username){
    $con = Database::getConnection();
    try {
        $sql = "SELECT * FROM `tbl_cancelledevents` WHERE username = :username ORDER BY id";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}





 function ApproveProduct($product_id){
    $con = Database::getConnection();

    try {
        // Fetch product details from tbl_products
        $sql = "SELECT * FROM tbl_events WHERE id = $product_id";
        $result = $con->query($sql);
        $product = $result->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            // Insert product details into tbl_deletedproducts
           $sql = "INSERT INTO tbl_approvedevents
        (username, name, date, timefrom, timeto, venue,image)
        VALUES
        ('{$product['username']}', '{$product['name']}', '{$product['date']}', '{$product['timefrom']}', '{$product['timeto']}','{$product['venue']}','{$product['image']}')";

            $con->exec($sql);

            $sql = "DELETE FROM tbl_events WHERE id = $product_id";
            $con->exec($sql);
        } else {
            echo "";
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

//admin cancellevents
 function CancelledEvents($product_id){
    $con = Database::getConnection();

    try {
        // Fetch product details from tbl_products
        $sql = "SELECT * FROM tbl_approvedevents WHERE id = $product_id";
        $result = $con->query($sql);
        $product = $result->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            // Insert product details into tbl_deletedproducts
            $sql = "INSERT INTO tbl_cancelledevents
                    (username ,name, date, timefrom, timeto, venue)
                    VALUES
                    ('{$product['username']}','{$product['name']}', '{$product['date']}', '{$product['timefrom']}', '{$product['timeto']}','{$product['venue']}')";
            $con->exec($sql);

            $sql = "DELETE FROM tbl_approvedevents WHERE id = $product_id";
            $con->exec($sql);
        } else {
            echo "";
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}


 function DeletedEvents($product_id){
    $con = Database::getConnection();

    try {
        // Fetch product details from tbl_allevents
        $sql = "SELECT * FROM tbl_allevents WHERE id = :product_id";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            // Insert product details into tbl_deletedevents
            $sql = "INSERT INTO tbl_deletedevents
                    (username ,name, date, timefrom, timeto, venue, image)
                    VALUES
                    (:username, :name, :date, :timefrom, :timeto, :venue, :image)";
            $stmt = $con->prepare($sql);
            $stmt->execute([
                ':username' => $product['username'],
                ':name' => $product['name'],
                ':date' => $product['date'],
                ':timefrom' => $product['timefrom'],
                ':timeto' => $product['timeto'],
                ':venue' => $product['venue'],
                ':image' => $product['image']
            ]);
            
            // Delete from all related tables
            $tables = ['tbl_allevents', 'tbl_approvedevents', 'tbl_cancelledevents'];
            foreach ($tables as $table) {
                $sql = "DELETE FROM $table WHERE id = :product_id";
                $stmt = $con->prepare($sql);
                $stmt->bindParam(':product_id', $product_id);
                $stmt->execute();
            }
        }
    } catch(PDOException $e) {
        error_log("Error deleting event: " . $e->getMessage());
        echo "An error occurred while deleting the event.";
    }
}


 function UserCancelledEvents($product_id){
    $con = Database::getConnection();

    try {
        // Fetch product details from tbl_products
        $sql = "SELECT * FROM tbl_approvedevents WHERE id = $product_id";
        $result = $con->query($sql);
        $product = $result->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            // Insert product details into tbl_deletedproducts
            $sql = "INSERT INTO tbl_cancelledevents
                    (username ,name, date, timefrom, timeto, venue, image)
                    VALUES
                    ('{$product['username']}','{$product['name']}', '{$product['date']}', '{$product['timefrom']}', '{$product['timeto']}','{$product['venue']}','{$product['image']}')";
            $con->exec($sql);

            $sql = "DELETE FROM tbl_approvedevents WHERE id = $product_id";
            $con->exec($sql);
        } else {
            echo "";
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}


// function CancelledEvents($req){
//   $con = Database::getConnection();


//     $name = $req['name'];
//     $date = $req['date'];
//     $timefrom = $req['timefrom'];
//     $timeto = $req['timeto'];
//     $venue = $req['venue'];

//     try {

//         $sql = "INSERT INTO `tbl_cancelledevents`
//         (name,date,timefrom,timeto,venue)
//         VALUES
//         (:name, :date ,:timefrom, :timeto, :venue)";

    
//         $stmt = $con->prepare($sql);

//         // Bind parameters
//         $stmt->bindParam(':name', $name);
//         $stmt->bindParam(':date', $date);
//         $stmt->bindParam(':timefrom', $timefrom);
//         $stmt->bindParam(':timeto', $timeto);
//         $stmt->bindParam(':venue', $venue);

//         // Execute the statement
//         $stmt->execute();
    

//      } catch(PDOException $e) {
//         // echo "Error: " . $e->getMessage();
//     }
// }









// function AddToTableEvents($req){
//     global $con;

//     $name = $req['name'];
//     $date = $req['date'];
//     $timefrom = $req['timefrom'];
//     $timeto = $req['timeto'];
//     $venue = $req['venue'];

//     try {
//         // Prepare SQL statement with placeholders
//         $sql = "INSERT INTO `tbl_events` 
//                 (name, date, timefrom, timeto, venue)
//                 VALUES 
//                 (:name, :date, :timefrom, :timeto, :venue)";
      
//         // Prepare the statement
//         $stmt = $con->prepare($sql);

//         // Bind parameters
//         $stmt->bindParam(':name', $name);
//         $stmt->bindParam(':date', $date);
//         $stmt->bindParam(':timefrom', $timefrom);
//         $stmt->bindParam(':timeto', $timeto);
//         $stmt->bindParam(':venue', $venue);

//         // Execute the statement
//         $stmt->execute();

//      echo "<script>alert('Inserted Successfuly')</script>";
//     } catch(PDOException $e) {
//         // echo "Error: " . $e->getMessage();
//     }
// }














}

?>