
<img src="<?php echo WEBROOT; ?>/gallery/<?php echo $image['file_name']; ?>">

<a href="<?php echo WEBROOT; ?>image/applyFilter/<?php echo $image['id'] ?>/original"><button type="button" class="btn btn-primary">Original</button></a>
<a href="<?php echo WEBROOT; ?>image/applyFilter/<?php echo $image['id'] ?>/grayscale"><button type="button" class="btn btn-primary">Grayscale</button></a>
<a href="<?php echo WEBROOT; ?>image/applyFilter/<?php echo $image['id'] ?>/sepia"><button type="button" class="btn btn-primary">Sepia</button></a>
<a href="<?php echo WEBROOT; ?>image/applyFilter/<?php echo $image['id'] ?>/invert"><button type="button" class="btn btn-primary">Invert</button></a>