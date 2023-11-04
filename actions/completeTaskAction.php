<?php
require "../conn.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
if($id){
    $query = $conn->prepare("UPDATE tasks SET status=2 WHERE id = :id;");
    $query->bindValue(":id", $id);
    $query->execute();
    header("Location: ../index.php?success=true");
    exit;
} else {
    header("Location: ../index.php?success=false");
    exit;
}
?>
