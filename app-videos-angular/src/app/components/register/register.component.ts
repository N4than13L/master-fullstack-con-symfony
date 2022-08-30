import { Component, OnInit } from '@angular/core';
import { User } from 'src/app/models/user';

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.css']
})
export class RegisterComponent implements OnInit {
  public Pagetitle: string
  public user: User

  constructor() {
    this.Pagetitle = "registro"
    this.user = new User(1, '', '', '', '', 'ROLE_USER', '')
  }

  ngOnInit(): void {
    console.log(this.user)
  }

  onSubmit(val: any) {
    console.log(this.user)
  }

}
