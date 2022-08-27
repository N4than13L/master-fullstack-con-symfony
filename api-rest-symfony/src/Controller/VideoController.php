<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

// Entidades
use App\Entity\User;
use App\Entity\Video;
use App\Services\JwtAuth;

// componentes para la request
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints\Email;

class VideoController extends AbstractController
{
    /**
     * @Route("/video", name="app_video")
     */
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/VideoController.php',
        ]);
    }

    public function createVideo(Request $request, JwtAuth $jwt_auth){
        // Recoger el token.

        // Comprobar si e correcto.

        // Recoger datos por POST.

        // Recoger el objeto del usuario identificado.

        // Comprobar y validar datos.
        
        // Guardar el nuevo video favorito en la db.

        // devolver una respuesta.
        
        $data = [
            'status' => 'error',
            'code' => 404,
            'message' => 'metodo para los videos'
        ];

        return new jsonResponse($data);
    }

}
