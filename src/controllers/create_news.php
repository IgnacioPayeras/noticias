<?php
require_once '../../vendor/autoload.php';
require_once '../../config/database.php';
date_default_timezone_set('America/Santiago');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $title = $_POST['title'];
  $journalist = $_POST['journalist'];
  $datetime = date('Y-m-d H:i:s');
  $videoLink = $_POST['video-link'];
  $videoTitle = $_POST['video-title'];
  $introduction = $_POST['introduction'];
  $conclusion = $_POST['conclusion'];

  $conn = new mysqli($servername, $username, $password, $database);
  $sql1 = "INSERT INTO news (title, datetime, video_link, video_title, introduction, conclusion, id_journalist) VALUES ('$title', '$datetime', '$videoLink', '$videoTitle', '$introduction', '$conclusion', '$journalist')";
  $conn->query($sql1);
  $lastNewsResult = $conn->query("SELECT id FROM news ORDER BY id DESC LIMIT 1");
  $lastNewsId = $lastNewsResult->fetch_assoc()['id'];
  $counterBody = $_POST['counter'];
  for ($i = 1; $i <= $counterBody; $i++) {
    $titleBody = $_POST["title-body-$i"];
    $contentBody = $_POST["body-$i"];
    $imageLink = $_POST["image-link-$i"];
    $imageDescription = $_POST["image-alt-$i"];

    $sql2 = "INSERT INTO part (title, content, image_link, image_description) VALUES ('$titleBody', '$contentBody', '$imageLink', '$imageDescription')";
    $conn->query($sql2);
    $lastPartResult = $conn->query("SELECT id from part ORDER BY id DESC LIMIT 1");
    $lastPartId = $lastPartResult->fetch_assoc()['id'];

    $sql3 = "INSERT INTO news_part (id_news, id_part) VALUES ('$lastNewsId', '$lastPartId')";
    $conn->query($sql3);
  }

  echo "Nuevo news creado exitosamente";
  header('Location: /');
  exit;
  $conn->close();
}
