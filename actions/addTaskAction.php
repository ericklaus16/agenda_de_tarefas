<?php
require "../conn.php";

$taskDescription = filter_input(INPUT_POST, "taskDescription", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if($taskDescription){
    $query = $conn->prepare("INSERT INTO `tasks` (task) VALUES (:task)");
    $query->bindValue(":task", $taskDescription);
    $query->execute();
    header("Location: ../index.php?success=true");
    exit;
} else {
    header("Location: ../index.php?success=false");
    exit;
}
?>