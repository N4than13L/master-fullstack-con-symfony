import { Injectable } from "@angular/core"
import { HttpClient, HttpHeaders } from "@angular/common/http"
import { Observable } from "rxjs"

import { Video } from "../models/video"
import { global } from "./global"


@Injectable()
export class VideoService {
    public url: string


    constructor(
        public _http: HttpClient
    ) {
        this.url = global.url
    }

    createVideo(token: any, video: any): Observable<any> {
        let json = JSON.stringify(video)
        let params = 'json=' + json

        let headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded')
            .set("Authorization", token)

        return this._http.post(this.url + 'video/new', params, { headers: headers })
    }

    getVideos(token: any): Observable<any> {
        let headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded')
            .set("Authorization", token)

        return this._http.get(this.url + 'videos/list', { headers: headers })
    }

    getVideo(token: any, id: any): Observable<any> {
        let headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded')
            .set("Authorization", token)

        return this._http.get(this.url + 'video/detail/' + id, { headers: headers })
    }

    updateVideo(token: any, video: any, id: any): Observable<any> {
        let json = JSON.stringify(video)
        let params = 'json=' + json

        let headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded')
            .set("Authorization", token)

        return this._http.put(this.url + 'video/edit/' + id, params, { headers: headers })
    }

    deleteVideo(token: any, id: any): Observable<any> {
        let headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded')
            .set("Authorization", token)

        return this._http.delete(this.url + 'video/remove/' + id, { headers: headers })
    }

}