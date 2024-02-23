import { Component, OnInit } from '@angular/core';
import { TaskService } from './task.service';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent implements OnInit {
  tasks: any[] = [];
  title = '';
  description = '';

  constructor(private taskService: TaskService) {}

  ngOnInit() {
    this.fetchTasks();
  }

  fetchTasks() {
    this.taskService.getTasks().subscribe(
      tasks => this.tasks = tasks,
      error => console.error('Error fetching tasks:', error)
    );
  }

  addTask() {
    this.taskService.addTask(this.title, this.description).subscribe(
      data => {
        console.log(data.message);
        this.fetchTasks();
      },
      error => console.error('Error adding task:', error)
    );
  }

  updateTask(id: number) {
    // Assuming you have input fields for updating in your template
    // Assign values to this.title and this.description before calling this method
    this.taskService.updateTask(id, this.title, this.description).subscribe(
      data => {
        console.log(data.message);
        this.fetchTasks();
      },
      error => console.error('Error updating task:', error)
    );
  }

  deleteTask(id: number) {
    this.taskService.deleteTask(id).subscribe(
      data => {
        console.log(data.message);
        this.fetchTasks();
      },
      error => console.error('Error deleting task:', error)
    );
  }
}
