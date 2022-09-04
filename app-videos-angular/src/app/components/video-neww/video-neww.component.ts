import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute, Params } from "@angular/router"
import { UserService } from 'src/app/services/user.service';
import { Video } from 'src/app/models/video';


@Component({
  selector: 'app-video-neww',
  templateUrl: './video-neww.component.html',
  styleUrls: ['./video-neww.component.css'],
  providers: [UserService]
})

export class VideoNewwComponent implements OnInit {
  public Pagetitle: string
  public identity: any
  public token: any
  public video: Video | any

  constructor(private _router: Router, _route: ActivatedRoute,
    private _userService: UserService) {
    this.Pagetitle = "Videos favoritos"
    this.identity = this._userService.getIdentity()
    this.token = this._userService.getToken()
  }

  ngOnInit(): void {
    this.video = new Video(1, this.identity.sub, '', '', '', '', '')
  }

}
