<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Pagina Principal</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/noticia.css">
	<style type="text/css">
		
	</style>
</head>
<body>

<form method="post" enctype="multipart/form-data">
<div class="formulario">
	<div>
		<label>faça o upload seu arquivo:</label>
		<input type="file" name="arquivo"><br>
	</div>
	<div>
		<label>TITULO:</label><br>
		<input type="text" name="titulo"><br>
	</div>
	<div>
		<label>TEXTO:</label><br>
		<textarea rows="15" cols="50" name="texto"></textarea><br>
	</div>
	<div>
		<input type="submit" value="Enviar arquivo">
	</div>
</div>
</form>
<img src="">
<?php

require_once("conecxao.php");
$file = isset($_FILES['arquivo'])?$_FILES['arquivo']:"";
$titulo = isset($_POST['titulo'])?$_POST['titulo']:"";
$texto = isset($_POST['texto'])?$_POST['texto']:"";
$uploaddir = "img";
if (!is_dir($uploaddir)) {
	mkdir($uploaddir);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
	if (empty($file) or empty($titulo) or empty($texto)) {
		echo "erro todos os campos tem que esta preenchido <br> ";		
	}else{
		if (move_uploaded_file($file['tmp_name'], $uploaddir .DIRECTORY_SEPARATOR. $file['name'])) {
   	 	echo "Arquivo válido e enviado com sucesso.\n";
   	 	$insert=$conn->prepare("INSERT INTO noticia(img,titulo,texto)VALUES(:img,:titulo,:texto)");
		$insert->bindParam(":img",$file['name']);
		$insert->bindParam(":titulo",$_POST['titulo']);
		$insert->bindParam(":texto",$_POST['texto']);
		$insert->execute();
		echo "<br>";
		} else {
    	echo "erro no upload de arquivo!<br>";
		}		
	}
}
//conteudo da noticia
	$select=$conn->prepare("SELECT * FROM noticia");
	$select->fetchAll();
	$select->execute();
	foreach ($select as $row) {
		?>
		<div class="noticia">
		<?php		
		echo "<img src="."img/".$row['img'].">"."<br>";
		echo "<p class="."titulo".">".$row['titulo']."</p>";
		echo "<p class="."texto".">".$row['texto']."</p>";
		echo "<p class="."codigo".">Codigo da Noticia: ".$row['id']."</p>";
		?>
		</div>
		<?php
	}


?>

<div>
	
</div>

</body>
</html>