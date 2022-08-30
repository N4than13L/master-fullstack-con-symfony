import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-error',
  templateUrl: './error.component.html',
  styleUrls: ['./error.component.css']
})
export class ErrorComponent implements OnInit {
  public Pagetitle: string
  constructor() {
    this.Pagetitle = "404"
  }

  ngOnInit(): void {
  }

}
