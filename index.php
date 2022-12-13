<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File upload</title>
</head>
<body>
<form action="index.php" method="post" enctype="multipart/form-data">
  Select image to upload:
  <input type="file" name="uploadedName">
  <input type="submit" value="Nahrát" name="submit">
</form>
<?php
if($_FILES){
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES['uploadedName']['name']);
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    $uploadSuccess = true;

    if($_FILES['uploadedName']['error'] != 0){
        echo "chyba serveru";
        $uploadSuccess = false;
    }

    elseif(file_exists($targetFile)){
        echo "Existuje";
        $uploadSuccess = false;
    }

    elseif($_FILES['uploadedName']['size'] > 8000000){
        echo "moc velký";
        $uploadSuccess = false;
    }

    elseif($fileType !== "jpg" && $fileType === "png"){
        echo "soubor má špatný typ";
        $uploadSuccess = false;
    }

    if(!$uploadSuccess){
        echo "Došlo k chybě uploadu";
    }
    else{
        if(move_uploaded_file($_FILES['uploadedName']['tmp_name'], $targetFile)){
        }else{
            echo "Došlo k chybě uploadu";
        }
    }
}

$files = scandir("uploads");

for($i = 2; $i < count($files); $i++){
    $ext = pathinfo($files[$i], PATHINFO_EXTENSION);
    var_dump($ext);
    if($ext == "mp4" || $ext == "avi"){
        echo "<video width='500' controls>";
        echo "<source src='uploads/{$files[$i]}' type='video/{$ext}'>";
        echo "</video>";
    }
    elseif($ext == "jpg" || $ext == "svg"){
        echo "<img src='uploads/{$files[$i]}' width='500'>";
    }
}
    ?>
</body>
</html>