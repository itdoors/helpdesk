<?php

  $file_uploaded = $_POST['file_upload']?$_POST['file_upload']:0;
  if ($file_uploaded)
  {
     echo  mime_content_type($file_uploaded);
  };

?>

<form action="file.php" method="post">
   <input type="file" name="file_upload" />
   <input type="submit" value="Send"> 
</form>