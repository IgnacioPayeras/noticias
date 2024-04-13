<?php

require_once '../../vendor/autoload.php';
require_once '../../config/database.php';

$loader = new \Twig\Loader\FilesystemLoader('../templates');
$twig = new \Twig\Environment($loader);

$conn = new mysqli($servername, $username, $password, $database);

$sql2 = "SELECT * FROM journalist";
$result2 = $conn->query($sql2);
$journalistList = array();

if ($result2->num_rows > 0) {
  while ($row = $result2->fetch_assoc()) {
    $journalistList[] = $row;
  }
} else {
  echo "No se encontraron noticias";
}

$conn->close();

echo $twig->render('create_news.twig', ['journalistList' => $journalistList]);

