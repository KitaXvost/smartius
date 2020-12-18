<?php
include_once 'config.php';

$database = new Database();
$dbh = $database->getConnection();

$date1 = (new DateTime($_POST['date1']))->format('Y-m-d 00:00:00');
$date2 = (new DateTime($_POST['date2']))->format('Y-m-d 23:59:59');
if(empty($_POST['date2'])){
  $date2 = $date1;
}
$org_id = $_POST['org'];
$stmt = $dbh->prepare("SELECT collaborators.fullname, learnings.state_id, orgs.name AS orgs_name, courses.name AS courses_name
                       FROM learnings
                       LEFT JOIN collaborators ON learnings.person_id = collaborators.id
                       LEFT JOIN orgs ON collaborators.org_id = orgs.id
                       LEFT JOIN courses ON learnings.course_id = courses.id
                       WHERE collaborators.org_id = :org_id
                       AND
                       learnings.start_date <= :date2 AND
                       learnings.finish_date >= :date1 ");

$stmt->execute(['org_id' => $org_id, 'date1' => $date1, 'date2' => $date2]);
?>
<div style="overflow-x:auto;">
<table>

  <tr>
    <th align=center>Название организации</th>
    <th align=center>Полное имя сотрудника</th>
    <th align=center>Название курса</th>
    <th align=center>Завершён\ Не завершён</th>
  </tr>

<?php
while ($category = $stmt->fetch(PDO::FETCH_LAZY)) {
  echo '<tr>
         <td>'.$category->orgs_name.'</td>
         <td>'.$category->fullname.'</td>
         <td>'.$category->courses_name.'</td>
         <td>'; if ($category->state_id > 2) {
           echo 'завершен';
            } else {
           echo 'не завершен';
         }
                  echo '</td>
         </tr>';
}
echo "</table></div>";
