<?php
require_once './vendor/autoload.php';
require_once './config/database.php';

$loader = new \Twig\Loader\FilesystemLoader('./src/templates');
$twig = new \Twig\Environment($loader);


$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
  die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT n.title, j.name, n.datetime, n.video_link, n.video_title, n.introduction, group_concat(p.title separator '\n') AS body_titles, group_concat(p.content separator '\n') AS body_contents, group_concat(p.image_link separator '\n') AS body_image_link, group_concat(p.image_description separator '\n') AS body_image_description, n.conclusion FROM news AS n INNER JOIN journalist AS j ON j.id=n.id_journalist INNER JOIN news_part as np on np.id_news=n.id INNER JOIN part as p on p.id=np.id_part GROUP BY n.id";

$result = $conn->query($sql);
$newsList = array();

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $newsList[] = $row;
  }
} else {
  echo "No se encontraron noticias";
}



$conn->close();

echo $twig->render('home.twig', ['newsList' => $newsList]);