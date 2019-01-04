<?php
/**
 * Created by PhpStorm.
 * User: hotov
 * Date: 04.01.2019
 * Time: 18:58
 */

class ImageHelper
{
    static private $instance = NULL;

    static function getInstance()
    {
        if (self::$instance == NULL) {
            self::$instance = new ImageHelper();
        }

        return self::$instance;
    }

    public static function uploadFile()
    {
        $target_dir = "imgs/";
        $target_file = $target_dir . basename($_FILES["file"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if ($_FILES["file"]["tmp_name"] != "") {
            $check = getimagesize($_FILES["file"]["tmp_name"]);
            if ($check !== false) {
                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                    && $imageFileType != "gif") {
                    echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.')</script>";
                } else {
                    if (file_exists($target_file)) {
                        echo "<script>alert('Sorry, file already exists.')</script>";
                    } else
                        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                            echo "The file \"<a href='" . BASE_URL . "imgs/" . basename($_FILES["file"]["name"]) . "' target='_blank'>imgs/" . basename($_FILES["file"]["name"]) . "</a>\" has been uploaded.";
                        } else {
                            echo "<script>alert('Sorry, there was an error uploading your file.)</script>";
                        }
                }
            } else echo "<script>alert('File is not an image.')</script>";
        } else echo "<script>alert('File is not an image.')</script>";
    }
}