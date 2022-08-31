import { Component, OnInit } from '@angular/core';
import { User } from 'src/app/models/user';
import { UserService } from 'src/app/services/user.service';

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.css'],
  providers: [UserService]
})

export class RegisterComponent implements OnInit {
  public Pagetitle: string
  public user: User
  public status: string | any

  constructor(
    private _userService: UserService
  ) {
    this.Pagetitle = "registro"
    this.user = new User(1, '', '', '', '', 'ROLE_USER', '')
  }

  ngOnInit(): void {
    this.onSubmit(this.user)
    console.log(this._userService.test())
  }

  onSubmit(form: any) {
    this._userService.register(this.user).subscribe(
      res => {
        if (res.status == "success") {
          this.status = "success"
          form.reset()
        } else {
          this.status = "error"
        }
      },
      err => {
        this.status = "error"
        console.log(err)
      }
    )
  }

}
