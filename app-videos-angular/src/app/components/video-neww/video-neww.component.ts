import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute, Params } from "@angular/router"
import { UserService } from 'src/app/services/user.service';
import { Video } from 'src/app/models/video';

import { VideoService } from 'src/app/services/video.service';

@Component({
  selector: 'app-video-neww',
  templateUrl: './video-neww.component.html',
  styleUrls: ['./video-neww.component.css'],
  providers: [UserService, VideoService]
})

export class VideoNewwComponent implements OnInit {
  public Pagetitle: string
  public identity: any
  public token: any
  public status: any

  public video: Video | any

  constructor(private _router: Router, _route: ActivatedRoute,
    private _userService: UserService, private _videoService: VideoService) {
    this.Pagetitle = "Videos favoritos"
    this.identity = this._userService.getIdentity()
    this.token = this._userService.getToken()
  }

  ngOnInit(): void {
    this.video = new Video(1, this.identity.sub, '', '', '', '', '')
  }

  onSubmit(form: any) {
    this._videoService.createVideo(this.token, this.video).subscribe(
      response => {
        if (response.status = "success") {
          this.status = "success"
          console.log(response)
          // this._router.navigate(['/inicio'])
        } else {
          this.status = "error"
        }
      },
      error => {
        this.status = "error"
        console.log(error)
      }
    )
  }

}
