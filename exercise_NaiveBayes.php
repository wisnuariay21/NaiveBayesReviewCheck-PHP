<?php 
 require_once __DIR__.'/vendor/autoload.php';
 use Phpml\FeatureExtraction\TokenCountVectorizer;
 use Phpml\Tokenization\WhitespaceTokenizer;
 use Phpml\FeatureExtraction\TfIdfTransformer;
 use Phpml\Classification\KNearestNeighbors;
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
<h2> CEK KOMENTAR </h2>
	<form method="POST" action=""> 
		<input type="textarea" name="keyword" id="myInput" placeholder="input comment">
		<input type="submit" name="submit">
	</form>
<table id="myTable" border="1">

<?php
$conn = new mysqli("localhost", "root", "", "review");
if ($conn->connect_error) 
{
	die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST['submit']))
{
	$sql = "SELECT count(sentimen) as totpositif FROM review WHERE sentimen = 'Positif'";
	$res = mysqli_query($conn, $sql);
	$totpositif = mysqli_fetch_assoc($res);

	$sql2 = "SELECT count(sentimen) as totnegatif FROM review WHERE sentimen = 'Negatif'";
	$res = mysqli_query($conn, $sql2);
	$totnegatif = mysqli_fetch_assoc($res);

	$sql3 = "SELECT count(sentimen) as total FROM review";
	$res = mysqli_query($conn, $sql3);
	$total = mysqli_fetch_assoc($res);

	$insert = $_POST['keyword'];
    $comment = explode(' ', $insert);

	echo "P(Positif) = ".$totpositif['totpositif']."/".$total['total'];
    echo "<br>";

    $positifnum = 1;
	$positifdenom = 1;
    foreach ($comment as $key) 
    {
    	$sqlpositif = "SELECT count(komentar) as totkomen FROM review where komentar like '%".$key."%' AND sentimen = 'Positif'";
    	$result = mysqli_query($conn, $sqlpositif);
    	$totkomen = mysqli_fetch_assoc($result);
    	$positifnum = $positifnum * $totkomen['totkomen'];
    	$positifdenom = $positifdenom * $totpositif['totpositif'];

    	echo "P(".$key." | Positif) = ".$totkomen['totkomen']."/".$totpositif['totpositif'];
    	echo "<br>";
    }
    $positifnum = $positifnum * $totpositif['totpositif'];
    $positifdenom = $positifdenom * $total['total'];
    echo "P(".$_POST['keyword']." | Positif) = ".$positifnum."/".$positifdenom;
    echo "<br><br><br>";


    echo "N(Negatif) = ".$totnegatif['totnegatif']."/".$total['total'];
    echo "<br>";

    $negatifnum = 1;
    $negatifdenom = 1;
    foreach ($comment as $key) 
    {
    	$sqlnegatif = "SELECT count(komentar) as totkomen FROM review where komentar like '%".$key."%' AND sentimen = 'Negatif'";
    	$result = mysqli_query($conn, $sqlnegatif);
    	$totkomen = mysqli_fetch_assoc($result);
    	$negatifnum = $negatifnum * $totkomen['totkomen'];
    	$negatifdenom = $negatifdenom * $totnegatif['totnegatif'];

    	echo "N(".$key." | Negatif) = ".$totkomen['totkomen']."/".$totnegatif['totnegatif'];
    	echo "<br>";

    }
    $negatifnum = $negatifnum * $totnegatif['totnegatif'];
    $negatifdenom = $negatifdenom * $total['total'];
    echo "N(".$_POST['keyword']." | Negatif) = ".$negatifnum."/".$negatifdenom;
    echo "<br><br>";

    $respositif = $positifnum / $positifdenom;
    $resnegatif = $negatifnum / $negatifdenom;

  	if(max($respositif, $resnegatif) == $respositif)
  	{
  		echo "Hasil Sentimen analisis pada komen baru adalah positif";
  	}
  	else
  	{
  		echo "Hasil Sentimen analisis pada komen baru adalah negatif";
  	}

}
echo "</table><br>";
?>