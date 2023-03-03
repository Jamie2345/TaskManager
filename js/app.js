function validateForm() {

  // create variable for if form is valid
  var form = document.getElementById("sign-up-form");
  var form_valid = form.reportValidity();

  // Check if passwords match 

  var pass = document.getElementById("password").value;
  var confirm_pass = document.getElementById("confirm-password").value;

  let message = document.getElementsByClassName("password-message")[0];

  message.textContent = "";

  if (form_valid) {

    if (pass != '' && pass != null) {
      if (pass.length != 0) {
        
        if (pass == confirm_pass) {
          message.textContent = "";
          
          // if form valid and passwords match submit it
          // submit form
          console.log('form valid')
          form.method = "POST";
          form.submit();  
        }
        
        else {
          message.textContent = "passwords do not match";
        }
      }
    }
  }
}

function reloadPage() {
  window.location.reload();
}

function deleteTask(task_id) {
  const data = {
    task_id: task_id,
  }
  
  // make the request
  fetch("taskremover.php", {
    method: "POST",
    body: JSON.stringify(data),
    headers: {
      "Content-Type": "application/json; charset=UTF-8"
    }
  })
    .then((response) => response.json())
    .then((data) => console.log(data))
}

function deleteTaskButton(task, task_id) {  
  var body = document.getElementById("tasks-page");
  var blur = document.getElementById("blur");
  var popup = document.getElementById("task-delete-popup");

  // reset popups
  body.classList.remove("no-overflow");
  blur.classList.remove("active");
  popup.classList.remove("active");

  body.classList.add("no-overflow");
  blur.classList.add("active");
  popup.classList.add("active");

  var taskTextBox = document.getElementById("task-delete-task-text");

  taskTextBox.innerText = task;
  
  // handle closing popup
  function closePopup() {
    body.classList.remove("no-overflow");
    blur.classList.remove("active");
    popup.classList.remove("active");
  }

  document.querySelector("#task-delete-close-button").addEventListener("click", function() {
    closePopup();
  });

  document.querySelector("#delete_conf_btn").addEventListener("click", function() {

    deleteTask(task_id);
    closePopup();
    reloadPage(); 
  });
}

function editTaskButton(task, task_id) {
  var body = document.getElementById("tasks-page");
  var blur = document.getElementById("blur");
  var popup = document.getElementById("task-edit-popup");

  // reset popups
  body.classList.remove("no-overflow");
  blur.classList.remove("active");
  popup.classList.remove("active");

  body.classList.add("no-overflow");
  blur.classList.add("active");
  popup.classList.add("active");

  // handle closing popup
  function closePopup() {
    body.classList.remove("no-overflow");
    blur.classList.remove("active");
    popup.classList.remove("active");
  }

  document.querySelector("#task-edit-close-button").addEventListener("click", function() {
    closePopup();
  });

  document.querySelector("#edit_cancel_btn").addEventListener("click", function() {
    closePopup();
  });

  var input_box = document.querySelector("#edit_box");

  input_box.value = task.trim();
  input_box.focus();

  document.querySelector("#edit_conf_btn").addEventListener("click", function() {
    var textContent = input_box.value.trim();

    if (textContent.length == 0) {
      deleteTask(task_id);
    }

    else {
      const data = {
        task: task,
        task_id: task_id,
        new_value: textContent
      }
      
      // make the request
      fetch("taskeditor.php", {
        method: "POST",
        body: JSON.stringify(data),
        headers: {
          "Content-Type": "application/json; charset=UTF-8"
        }
      })
        .then((response) => response.json())
        .then((data) => console.log(data))
    }
    
    closePopup();
    reloadPage(); 
  });
  
}

function addTaskButton(task_id) {
  var body = document.getElementById("tasks-page");
  var blur = document.getElementById("blur");
  var popup = document.getElementById("task-add-popup");

  // reset popups
  body.classList.remove("no-overflow");
  blur.classList.remove("active");
  popup.classList.remove("active");

  body.classList.add("no-overflow");
  blur.classList.add("active");
  popup.classList.add("active");

  // handle closing popup
  function closePopup() {
    body.classList.remove("no-overflow");
    blur.classList.remove("active");
    popup.classList.remove("active");
  }

  document.querySelector("#task-add-close-button").addEventListener("click", function() {
    closePopup();
    reloadPage(); 
  });

  document.querySelector("#add_cancel_btn").addEventListener("click", function() {
    closePopup();
    reloadPage(); 
  });

  var input_box = document.querySelector("#add_box");

  document.querySelector("#add_conf_btn").addEventListener("click", function() {
    var textContent = input_box.value.trim();

    if (textContent.length == 0) {
      closePopup();
      reloadPage(); 
    }

    else {

      const data = {
        task: textContent,
        task_id: task_id,
      }
    
      // make the request
      fetch("taskadder.php", {
        method: "POST",
        body: JSON.stringify(data),
        headers: {
          "Content-Type": "application/json; charset=UTF-8"
        }
      })
        .then((response) => response.json())
        .then((data) => console.log(data))

    }
    reloadPage(); 
  });
    
}

function taskStatus(cb, task_id) {
  console.log(task_id);
  console.log(cb.checked);

  const data = {
    task_id: task_id,
    task_status: cb.checked
  }

  fetch("taskstatus.php", {
    method: "POST",
    body: JSON.stringify(data),
    headers: {
      "Content-Type": "application/json; charset=UTF-8"
    }
  })
    .then((response) => response.json())
    .then((data) => console.log(data))
  
  reloadPage();
}

function deleteAllTasks() {
  var body = document.getElementById("tasks-page");
  var blur = document.getElementById("blur");
  var popup = document.getElementById("delete-all-popup");

  // reset popups
  body.classList.remove("no-overflow");
  blur.classList.remove("active");
  popup.classList.remove("active");

  body.classList.add("no-overflow");
  blur.classList.add("active");
  popup.classList.add("active");

  // handle closing popup
  function closePopup() {
    body.classList.remove("no-overflow");
    blur.classList.remove("active");
    popup.classList.remove("active");
  }

  document.querySelector("#delete-all-close-button").addEventListener("click", function() {
    closePopup();
    reloadPage(); 
  });

  document.querySelector("#delete_all_conf_btn").addEventListener("click", function() {
    fetch("deletealltasks.php")
    
    .then((response) => response.json())
    .then((data) => console.log(data))
  
    reloadPage();
  });

}
