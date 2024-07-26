<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"])) {
    $target_dir = "uploads/";
    $original_name = basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $original_name;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if file is an image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check === false) {
        echo "Sorry, the file is not an image.";
        $uploadOk = 0;
    }

    // If file with the same name exists, rename the file
    $counter = 1;
    while (file_exists($target_file)) {
        $target_file = $target_dir . pathinfo($original_name, PATHINFO_FILENAME) . "($counter)." . $imageFileType;
        $counter++;
    }

    // Check file size (e.g., 5 MB)
    if ($_FILES["image"]["size"] > 5000000) {
        echo "Sorry, the file size is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats only (jpg, jpeg, png, gif)
    if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
        $uploadOk = 0;
    }

    // If no errors, upload the file
    if ($uploadOk == 0) {
        echo "Sorry, your file could not be uploaded.";
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $file_url = "anfoz.com/" . $target_file; // Create the URL of the image (replace with server address)
            echo $file_url;

            // Automatically delete the image from the server
            $delete_time = time() + (5 * 60); // 5 minutes later
            $delete_command = "rm -f " . $target_file;
            exec("echo 'at $delete_time <<< \"$delete_command\"' | at now 2>&1"); // Schedule the task with 'at'
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>
