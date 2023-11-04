<?php
require "../conn.php";
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
$newTask = filter_input(INPUT_GET, "task", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if($newTask && $id){
    $query = $conn->prepare("UPDATE tasks SET task = :task WHERE id = :id;");
    $query->bindValue(":task", $newTask);
    $query->bindValue(":id", $id);
    $query->execute();
    header("Location: ../index.php?success=true");
    exit;
} else {
    header("Location: ../index.php?success=false");
    exit;
}
?>