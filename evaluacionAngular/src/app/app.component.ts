import { Component } from '@angular/core';
import { Items } from './models/items';
import { ApiService } from './api.service';
import {HttpClient} from '@angular/common/http';
import { DataTablesModule } from 'angular-datatables';
import {NgbModal, ModalDismissReasons, NgbModalOptions} from '@ng-bootstrap/ng-bootstrap';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  constructor(private http: HttpClient, private apiService: ApiService, private modalService: NgbModal) {
    this.modalOptions = {
      backdrop:'static',
      backdropClass:'customBackdrop'
    }
  }

  public modalTitle: any;
  public btnTitle: any;
  public itemData: Items[];
  public temp: Object = false;
  selectedItems: Items = new Items();
  closeResult: string;
  modalOptions:NgbModalOptions;
  
  open(content) {
    this.modalService.open(content, this.modalOptions).result.then((result) => {
      this.closeResult = `Closed with: ${result}`;
    }, (reason) => {
      this.closeResult = `Dismissed ${this.getDismissReason(reason)}`;
    });
  }

  private getDismissReason(reason: any): string {
    if (reason === ModalDismissReasons.ESC) {
      return 'by pressing ESC';
    } else if (reason === ModalDismissReasons.BACKDROP_CLICK) {
      return 'by clicking on a backdrop';
    } else {
      return  `with: ${reason}`;
    }
  }

  ngOnInit(): void {
    this.apiService.getAllData('items').subscribe(
      data => this.itemData = data,
      err => console.log(err),
      () => console.log('Complete'), this.temp = true
    );
  }

  openForEdit(items: Items) {
    this.selectedItems = items;
  }

  deleteItem(items: Items) {
    if (confirm('Estas seguro de realizar esta acción?')) {
      //this.itemData.splice(this.itemData.findIndex(v => v.motivo === items.motivo), 1);
      this.apiService.deleteItem('items/' + items.motivo).subscribe(
        data => console.log(data), location.reload(),
        err => console.log(err),
        () => console.log('Complete')
      );
    }
  }

  addItem() {
    if (this.selectedItems.motivo == 0) {
      this.apiService.insertItem('items', {des_motivo: this.selectedItems.des_motivo, estado: this.selectedItems.estado, tipo: this.selectedItems.tipo}).subscribe(
        data => console.log(data), location.reload(),
        err => console.log(err),
        () => console.log('Complete Insert')
      );
    } else {
      this.apiService.editItem('items/' + this.selectedItems.motivo, {des_motivo: this.selectedItems.des_motivo, estado: this.selectedItems.estado, tipo: this.selectedItems.tipo}).subscribe(
        data => console.log(data),
        err => console.log(err),
        () => console.log('Complete Update')
      );
    }
  }

  cambiarAgregar() {
    this.selectedItems = {motivo: 0, des_motivo: '', estado: '', tipo: ''};
    this.modalTitle = 'Agregar Item';
    this.btnTitle = 'Agregar';
  }
  
  cambiarEditar() {
    this.modalTitle = 'Editar Item';
    this.btnTitle = 'Editar';
  }
}
