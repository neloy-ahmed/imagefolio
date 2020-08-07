<?php 
if(isset($errors)){
    var_dump($errors);
}

?>
<form action="create" method="POST" enctype="multipart/form-data">
         <input type="file" name="image" />
         <input type="submit"/>
      </form>