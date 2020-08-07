<img src="<?php echo WEBROOT; ?>/gallery/<?php echo $image['file_name']; ?>">

Flip : 
<a href="<?php echo WEBROOT; ?>image/flip/<?php echo $image['id'] ?>/none"><button type="button" class="btn btn-primary">None</button></a>
<a href="<?php echo WEBROOT; ?>image/flip/<?php echo $image['id'] ?>/horizontal"><button type="button" class="btn btn-primary">Flip Horizontally</button></a>
<a href="<?php echo WEBROOT; ?>image/flip/<?php echo $image['id'] ?>/vertical"><button type="button" class="btn btn-primary">Flip Vertically</button></a>
<br>
Rotate:
<a href="<?php echo WEBROOT; ?>image/rotate/<?php echo $image['id'] ?>/0"><button type="button" class="btn btn-primary">0 deg</button></a>
<a href="<?php echo WEBROOT; ?>image/rotate/<?php echo $image['id'] ?>/30"><button type="button" class="btn btn-primary">30 deg</button></a>
<a href="<?php echo WEBROOT; ?>image/rotate/<?php echo $image['id'] ?>/60"><button type="button" class="btn btn-primary">60 deg</button></a>