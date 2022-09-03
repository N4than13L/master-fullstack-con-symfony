import { Component, OnInit } from '@angular/core';
import { User } from 'src/app/models/user';
import { UserService } from 'src/app/services/user.service';
import { Router, ActivatedRoute, Params } from "@angular/router"

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css'],
  providers: [UserService]
})
export class LoginComponent implements OnInit {
  public Pagetitle: string
  public user: User
  public identity: any
  public status: string | any
  public token: string | any

  constructor(
    private _userService: UserService,
    private _router: Router,
    private _route: ActivatedRoute
  ) {
    this.Pagetitle = "Login"
    this.user = new User(1, '', '', '', '', 'ROLE_USER', '')
  }
  ngOnInit(): void {
    this.logout()
  }

  onSubmit(form: any) {
    this._userService.signup(this.user).subscribe(
      res => {
        if (!res.status || res.status != 'error') {
          this.status = 'success'
          this.identity = res
          console.log(this.identity)

          // sacar el token 
          this._userService.signup(this.user, true).subscribe(
            res => {
              if (!res.status || res.status != 'error') {
                this.token = res
                console.log(this.identity)
                console.log(this.token)

                localStorage.setItem('token', this.token)
                localStorage.setItem('identity', JSON.stringify(this.identity))

                this._router.navigate(['/inicio'])
              }
            },
            error => {
              this.status = 'error'
              console.log(error)
            }
          )

        } else {
          this.status = 'error'
        }
      },
      error => {
        this.status = 'error'
        console.log(error)
      }
    )
  }


  logout() {
    this._route.params.subscribe(params => {
      let sure = +params['sure']

      if (sure == 1) {
        localStorage.removeItem('identity')
        localStorage.removeItem('token')

        this.identity = null
        this.token = null

        this._router.navigate(['/inicio'])
      }
    })
  }

}
