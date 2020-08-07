<div class="row">
<?php 
foreach($images as $image){
?>

<div class="col-md-4">
    <a href="filter/<?php echo $image['id']; ?>"><img style="max-width: 100%; height: auto;"  src="<?php echo WEBROOT; ?>/gallery/<?php echo $image['file_name']; ?>" class="img-fluid img-thumbnail"></a>
    <a href="filterOrCrop/<?php echo $image['id'] ?>/filter"><button type="button" class="btn btn-primary">Filter</button></a>
    <a href="filterOrCrop/<?php echo $image['id'] ?>/crop"><button type="button" class="btn btn-primary">Crop</button></a>
</div>

<?php
}
?>
</div>

