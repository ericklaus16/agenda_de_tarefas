<?php
    require "conn.php";
    $query = $conn->prepare("SELECT * FROM tasks");
    $query->execute();
    $nComecadas = 0;
    $incompletas = 0;
    $completas = 0;

    if($query->rowCount() > 0){
        $dados = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach($dados as $task){
            if($task['status'] == 0){
                $nComecadas += 1;
            } else if($task['status'] == 1){
                $incompletas += 1;
            } else {
                $completas += 1;
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
    <link rel="shortcut icon" href="img/notebook_ico.png" type="image/x-icon" />
    <link rel="stylesheet" href="sweetalert2.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">  
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="sweetalert2.all.min.js"></script>  
    <title>Agenda de Tarefas</title>
</head>
<body>
    <div class="container-fluid">
        <div class="taskTable">
            <div class="tasks">
                <h2 class="alert alert-dark">NÃO COMEÇADAS</h2>
                <div class="scrollArea">
                    <table class="table table-hover" border="1" width="100%">
                        <tr>
                            <th class="types">TAREFAS (<?=$nComecadas?>)</th>
                            <th class="types">AÇÕES</th>
                        </tr>
                        <?php foreach($dados as $task): if($task['status'] == 0){?>
                            <tr>
                                <td id="task"><?= $task['task'] ?></td>
                                <td id="icons">
                                    <i class="bi bi-trash3-fill" style="color: red" name="<?=$task['id'];?>" title="Excluir Tarefa"></i>
                                    <i class="bi bi-pencil-fill" style="color: orange" name="<?=$task['id'];?>" data-bs-toggle="modal" data-bs-target="#updateTaskModal" onclick="setThisTaskToUpdate(<?=$task['id']?>)" title="Editar Tarefa"></i>
                                    <i class="bi bi-check-lg" style="color: blue" name="<?=$task['id'];?>" title="Tarefa em Andamento"></i>
                                    <i class="bi bi-check-all" style="color: green" name="<?=$task['id'];?>" title="Concluir Tarefa"></i>
                                </td>
                            </tr>
                        <?php } endforeach; ?>
                    </table>
                </div>
                <form method="POST" action="actions/addTaskAction.php" class="inputArea">
                    <div class="input-group mb-3">
                        <input type="text" name="taskDescription" placeholder="Digite uma nova tarefa..." class="form-control">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Adicionar</button>
                        </div>
                    </div>
                </form> 
    
            </div>
            <div class="runningTasks">
                <h2 class="alert alert-warning">EM ANDAMENTO</h2>
                <div class="scrollArea">
                    <table class="table table-hover" border="1" width="100%">
                            <tr>
                                <th class="types">TAREFAS (<?=$incompletas?>)</th>
                                <th class="types">AÇÕES</th>
                            </tr>
                            <?php foreach($dados as $task): if($task['status'] == 1){?>
                                <tr>
                                    <td id="task"><?= $task['task'] ?></td>
                                    <td id="icons">
                                        <i class="bi bi-trash3-fill" style="color: red" name="<?=$task['id'];?>" title="Excluir Tarefa"></i>
                                        <i class="bi bi-check-all" style="color: green" name="<?=$task['id'];?>" title="Concluir Tarefa"></i>
                                    </td>
                                </tr>
                            <?php } endforeach; ?>
                        </table>
                </div>
            </div>
            <div class="completeTasks">
                <h2 class="alert alert-success">CONCLUÍDAS</h2>
                <div class="scrollArea">
                    <table class="table table-hover" border="1" width="100%">
                        <tr>
                            <th class="types">TAREFAS (<?=$completas?>)</th>
                            <th class="types">AÇÕES</th>
                        </tr>
                        <?php foreach($dados as $task): if($task['status'] == 2){?>
                            <tr>
                                <td id="task"><?= $task['task'] ?></td>
                                <td id="icons">
                                    <i class="bi bi-trash3-fill" style="color: red" name="<?=$task['id'];?>" title="Excluir Tarefa"></i>
                                </td>
                            </tr>
                        <?php } endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
        
        <i id="lightOrDarkMode" style="color: orange" class="bi bi-sun-fill fs-2" onclick="handleThemeSwitch()"></i>
    
        <div class="modal fade" id="updateTaskModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Qual será a nova tarefa?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="actions/updateTaskAction.php">
                            <input name="updatedTask" id="updatedTask" class="form-control" type="text" placeholder="Digite aqui..."/>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" id="updateButton" class="btn btn-primary" onclick="handleUpdateTask()">Salvar modificações</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>                
    <script src="js/script.js"></script>
</body>
</html>