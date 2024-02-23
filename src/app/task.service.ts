import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})
export class TaskService {
  //private apiUrl = 'https://zoomcarft.000webhostapp.com/proj1/api2.php';
  //private apiUrl = 'http://localhost/api2.php';
  //private apiUrl = 'http://sv.rf.gd/dtsk/bk/api2.php';

  private apiUrl = environment.apiUrl;

  constructor(private http: HttpClient) { }

  getTasks(): Observable<any[]> {
    return this.http.get<any[]>(this.apiUrl);
  }

  addTask(title: string, description: string): Observable<any> {
    return this.http.post<any>(this.apiUrl, { operation: 'add', title, description });
  }

  updateTask(id: number, title: string, description: string): Observable<any> {
    return this.http.post<any>(this.apiUrl, { operation: 'update', id, title, description });
  }

  deleteTask(id: number): Observable<any> {
    return this.http.post<any>(this.apiUrl, { operation: 'delete', id });
  }
}
