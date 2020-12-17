<?php
include_once 'config.php';

$database = new Database();
$dbh = $database->getConnection();

$stmt = $dbh->query("SELECT MIN(start_date), MAX(finish_date) FROM learnings");

while ($row = $stmt->fetch())
{
  $arr = array(
      'min' => (new DateTime($row[0]))->format('m.d.Y'),
      'max' => (new DateTime($row[1]))->format('m.d.Y'),
      'minmax' => (new DateTime($row[0]))->format('d.m.Y').'-'.(new DateTime($row[1]))->format('d.m.Y'),
  );

  echo json_encode($arr);
}
