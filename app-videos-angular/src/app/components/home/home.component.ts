import { Component, OnInit } from '@angular/core';
import { UserService } from 'src/app/services/user.service';
import { VideoService } from 'src/app/services/video.service';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css'],
  providers: [UserService, VideoService]
})
export class HomeComponent implements OnInit {
  public Pagetitle: string
  public identity: any
  public token: any
  public video: any


  constructor(
    private _userService: UserService,
    private _videoService: VideoService
  ) {
    this.Pagetitle = "Inicio"
  }

  ngOnInit(): void {
    this.loadUser()
    this.getVideos()
  }

  loadUser() {
    this.identity = this._userService.getIdentity()
    this.token = this._userService.getToken()
  }

  getVideos() {
    this._videoService.getVideos(this.token).subscribe(
      response => {
        this.video = response.videos
      },
      error => {
        console.log(error)
      }
    )
  }



}
