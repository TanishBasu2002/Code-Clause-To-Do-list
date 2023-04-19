let tasks = JSON.parse(localStorage.getItem('tasks')) || [];

function addTask() {
  const input = document.getElementById('input');
  const list = document.getElementById('list');
  const task = input.value.trim();

  if (task !== '') {
    tasks.push({text: task, completed: false});
    input.value = '';
    renderTasks();
    saveTasks();
  }
}

function renderTasks() {
  const list = document.getElementById('list');
  list.innerHTML = '';
  tasks.forEach((task, index) => {
    const li = document.createElement('li');
    li.classList.add('list-group-item');
    if (task.completed) {
      li.classList.add('list-group-item-success');
    }
    li.textContent = task.text;
    li.addEventListener('click', () => toggleCompleted(index));
    li.addEventListener('contextmenu', (event) => {
      event.preventDefault();
      if (confirm('Are you sure you want to delete this task?')) {
        deleteTask(index);
      }
    });
    list.appendChild(li);
  });
  const clearButton = document.getElementById('clear-button');
  clearButton.disabled = !tasks.some(task => task.completed);
}

function toggleCompleted(index) {
  tasks[index].completed = !tasks[index].completed;
  renderTasks();
  saveTasks();
}

function deleteTask(index) {
  tasks.splice(index, 1);
  renderTasks();
  saveTasks();
}

function clearCompleted() {
  tasks = tasks.filter(task => !task.completed);
  renderTasks();
  saveTasks();
}

function saveTasks() {
  localStorage.setItem('tasks', JSON.stringify(tasks));
}

renderTasks();