<?php
/**
 * Created by PhpStorm.
 * User: hotov
 * Date: 04.01.2019
 * Time: 18:58
 */

class IO
{
    static private $instance = NULL;

    static function getInstance()
    {
        if (self::$instance == NULL) {
            self::$instance = new IO();
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
                    echo "<script>alert('Pouze soubory JPG, JPEG, PNG a GIF jsou povoleny.')</script>";
                } else {
                    if (file_exists($target_file)) {
                        echo "<script>alert('Obrázek již existuje')</script>";
                    } else
                        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                            echo "<p>Soubor \"<a href='" . BASE_URL . "imgs/" . basename($_FILES["file"]["name"]) . "' 
                            target='_blank'>imgs/" . basename($_FILES["file"]["name"]) . "</a>\" nahrán.</p>";
                        } else {
                            echo "<script>alert('Problém s nahráváním')</script>";
                        }
                }
            } else echo "<script>alert('Soubor není obrázek.')</script>";
        } else echo "<script>alert('Soubor není obrázek.')</script>";
    }

    public static function importJSON()
    {
        $target_dir = "import/";
        $target_file = $target_dir . basename($_FILES["file"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if ($_FILES["file"]["tmp_name"] != "") {
            if ($imageFileType != "JSON" && $imageFileType != "json") {
                echo "<script>alert('Pouze soubory typu JSON jsou povoleny')</script>";
            } else {

                if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                    echo "<p>Soubor \"<a href='" . BASE_URL . "import/" . basename($_FILES["file"]["name"]) . "' 
                    target='_blank'>import/" . basename($_FILES["file"]["name"]) . "</a>\" importován.</p>";
                    return "import/" . basename($_FILES["file"]["name"]);
                } else {
                    echo "<script>alert('Problém s nahráváním.')</script>";
                }
            }
        } else echo "<script>alert('Problém s nahráváním.')</script>";
    }
}