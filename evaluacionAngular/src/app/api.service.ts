import { Injectable } from '@angular/core';
import {HttpClient, HttpHeaders } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})

export class ApiService {

  baseURL = 'http://localhost:3000/';

  constructor(private http:HttpClient) {}

  // tslint:disable-next-line: ban-types
  getAllData(apiItem: String): any {
    return this.http.get(this.baseURL + apiItem, {responseType: 'json'});
  }
  // tslint:disable-next-line: ban-types
  insertItem(apiItem: String, data): any {
    return this.http.post(this.baseURL + apiItem, data, {responseType: 'json'});
  }
  // tslint:disable-next-line: ban-types
  editItem(apiItem: String, data): any {
    return this.http.put(this.baseURL + apiItem, data,{responseType: 'json'});
  }
  // tslint:disable-next-line: ban-types
  deleteItem(id: String): any {
    return this.http.delete(this.baseURL + id, {responseType: 'json'});
  }
}
