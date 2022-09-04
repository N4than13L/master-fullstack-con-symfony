import { ModuleWithProviders } from "@angular/core"
import { Routes, RouterModule } from "@angular/router"

import { LoginComponent } from "./components/login/login.component"
import { RegisterComponent } from "./components/register/register.component"
import { HomeComponent } from "./components/home/home.component"
import { ErrorComponent } from "./components/error/error.component"

import { UserEditComponent } from "./components/user-edit/user-edit.component"
import { VideoNewwComponent } from "./components/video-neww/video-neww.component"

const appRoutes: Routes = [
    { path: '', component: HomeComponent },
    { path: 'inicio', component: HomeComponent },
    { path: 'login', component: LoginComponent },
    { path: 'logout/:sure', component: LoginComponent },
    { path: 'registro', component: RegisterComponent },
    { path: 'ajustes', component: UserEditComponent },
    { path: 'video-favorito', component: VideoNewwComponent },
    { path: 'error', component: ErrorComponent },
    { path: '**', component: ErrorComponent }
]


export const appRoutingProviders: any[] = []
export const routing: ModuleWithProviders<RouterModule> = RouterModule.forRoot(appRoutes)

