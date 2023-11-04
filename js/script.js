let taskToUpdate;

document.addEventListener('DOMContentLoaded', function() {
    const params = new URLSearchParams(window.location.search);
    const success = params.get('success');
    if(localStorage.getItem("favoriteTheme")){
        let theme = localStorage.getItem("favoriteTheme") ;
        document.querySelector("body").setAttribute("data-bs-theme", theme);
        document.querySelector("#lightOrDarkMode").className = (theme == "dark") ? "bi bi-moon-stars fs-2" : "bi bi-sun-fill fs-2";
        document.querySelector("#lightOrDarkMode").style.color = (theme == "dark") ? "#F6F1D5" : "orange";
    } else {
        document.querySelector("body").setAttribute("data-bs-theme", "light");
    }

    if (success === "true") {
        Swal.fire({ 
            position: 'down-end',
            icon: 'success',
            title: 'A tarefa foi concluída com sucesso!',
            showConfirmButton: false,
            timer: 1500
        });
    } else if(success === "false") {
        Swal.fire({ 
            position: 'down-end',
            icon: 'error',
            title: 'Houve um erro ao realizar a tarefa!',
            showConfirmButton: false,
            timer: 1500
        });
    }
});


document.querySelector("#updateButton").addEventListener("click", function(){   
    let newTask = document.querySelector("#updatedTask").value;
    if(newTask){
        Swal.fire({
            title: "Você tem certeza que deseja modificar essa tarefa?",
            icon: "question",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#097969',
            confirmButtonText: "Sim!",
            cancelButtonColor: "#DD6B55",
            cancelButtonText: "Não!",
            timer: 5000,
            timerProgressBar: true
        })
        .then((willDelete) => {
            if(willDelete.value){
                location.assign("./actions/updateTaskAction.php?id=" + taskToUpdate + "&task=" + newTask);
            }
        });
    } else {
        Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: 'Preencha os dados corretamente!',
            showConfirmButton: false,
            timer: 1500
        })
    }
});

// Lidando com todas as funções de forma anônima evitando que o usuário possa chamar pelo inspetor
document.querySelectorAll('.bi').forEach(icon => {
    icon.addEventListener('click', function() {
        const taskId = this.getAttribute('name');
        const iconClass = this.classList[1];

        switch(iconClass) {
            case 'bi-trash3-fill':      
                Swal.fire({
                    position: "center",
                    title: "Você tem certeza que deseja remover essa tarefa?",
                    icon: "error",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Sim, remover tarefa!",
                    cancelButtonColor: '#097969',
                    cancelButtonText: "Não, manter tarefa!",
                    timer: 5000,
                    timerProgressBar: true
                })
                .then((willDelete) => {
                    if(willDelete.value){
                        location.assign("./actions/removeAction.php?id=" + taskId);
                    }
                });
                break;
            case 'bi-check-lg':
                Swal.fire({
                    position: "center",
                    title: "Você tem certeza que deseja classificar essa tarefa como 'Em andamento'?",
                    icon: "question", 
                    showCancelButton: true,
                    confirmButtonColor: '#097969',
                    confirmButtonText: "Sim!",
                    cancelButtonColor: "#DD6B55",
                    cancelButtonText: "Não!",
                    timer: 5000,
                    timerProgressBar: true
                })    
                .then((willDelete) => {
                    if(willDelete.value){
                        location.assign("./actions/turnTaskIntoProgressAction.php?id=" + taskId);
                    }
                });
                break;
            case 'bi-check-all':
                Swal.fire({
                    position: "center",
                    title: "Você tem certeza que deseja classificar essa tarefa como 'Completa'?",
                    icon: "question",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#097969',
                    confirmButtonText: "Sim!",
                    cancelButtonColor: "#DD6B55",
                    cancelButtonText: "Não!",
                    timer: 5000,
                    timerProgressBar: true
                })
                .then((willDelete) => {
                    if(willDelete.value){
                        location.assign("./actions/completeTaskAction.php?id=" + taskId);
                    }
                });
                break;
            default:
                break;
        }
    });
});

function setThisTaskToUpdate(id){
    taskToUpdate = id;
}

function handleThemeSwitch(){
    const currTheme = document.querySelector("#lightOrDarkMode");
    let theme = document.querySelector("body").getAttribute("data-bs-theme");

    if(theme == "light"){
        console.log("Night time... I'm feeling asleep!");
        currTheme.className = "bi bi-moon-stars fs-2";
        currTheme.style.color = "#F6F1D5";
        document.querySelector("body").setAttribute("data-bs-theme", "dark");
        localStorage.setItem("favoriteTheme", "dark");
    } else {
        console.log("It's a sunny day!");
        document.querySelector("body").setAttribute("data-bs-theme", "light");
        currTheme.className = "bi bi-sun-fill fs-2";
        currTheme.style.color = "orange";
        localStorage.setItem("favoriteTheme", "light");
    }
}