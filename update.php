<?php require 'header.php'
require 'database.php';
 
 $db = new Database(); 
 $flowers = $db->getFlowers();
 $message = null;
 if(isset($_GET) && isset($_GET['flower'])){
     
	 if(isset($_POST) && isset($_POST['editflower'])){
			$reqs_flower = $_POST['editflower'];
			$genus = $_POST['genus'];
			species = $_POST['species'];
			comname = $_POST['comname'];
			$r = $db->updateFlower($reqs_flower, $genus, $species, $comname);
			if($r){
				$message = $reqs_flower ."Updated!";
			}else{
				$message = $reqs_flower."Not updated.";
			}
	 }
	 $flowers = $db->getFlowers();
	 if($_GET['flower']== -1){
        $message = "Please select a flower.";
     }else{
         $reqs_flower = $_GET['flower'];
         $flower = $flowers[$reqs_flower];
     }
 }else{
 	 $flowers = $db->getFlowers();
 }

?>

	<div class="container">
	<?php
    if(!is_null($message)){
        echo('<div class="panel panel-default "><div class="bg-danger panel-body">'.$message . '</div></div>');
    }
?>
	<?php
		//Hide if flower is already selected 
		if(is_null($message) || !isset($flower)):
		?>
	<form class="form-inline" method = "get">
<div class="form_group">
<label for="flower">Flower</label>
<select class="form-control" id="flower" name = "flower">
	<option value="-1">Select One</option>
	<?php
		foreach ($flowers as $f) { ?>
			<option value = "<?= $f["comname"]?>"><?php echo $f ["comname"]; ?></option>
		<?php
        }
		?>
</select>
</div>
<button type ="submit" class="btn btn-default">Go</button>
</form>
<?php
else:
// Only show if flower is selected 
?>
<form method="post" class="form-horizontal">
<div class="form-group">
	<label for="genus" class="col-sm-2 control-label">Genus</label>
	<div class="col-sm-10">
		<input type="text" class="form-control" id="genus" name="genus" value="<?-$flower['genus']?>">
	</div>
	</div>
	<div class="form-group">
	<label for="species" class="col-sm-2 control-label">Species</label>
	<div class="col-sm-10">
		<input type="text" class="form-control" id="species" name="species" value="<?-$flower['species']?>">
	</div>
	</div>
	<div class="form-group">
	<label for="comname" class="col-sm-2 control-label">Common Name</label>
	<div class="col-sm-10">
		<input type="text" class="form-control" id="comname" name="comname" value="<?-$flower['comname']?>">
	</div>
	</div>
	<input name="editflower" value="<?-$flower['genus']?>" type="hidden">
	<button type="submit" class="btn btn-default">Submit</button>
	</form>
	<?php
		endif;
	?>
	</div><!-- /.container -->