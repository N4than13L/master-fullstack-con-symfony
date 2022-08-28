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
        $data = array(
            'status' => 'error',
            'code' => 404,
            'message' => 'video no guardado'
        );
            
        // Recoger el token.
        $token = $request->headers->get('Authorization', null);

        // Comprobar si es correcto.
        $auth_check = $jwt_auth->checkToken($token);

        if($auth_check){
           // Recoger datos por POST.
           $json = $request->get('json', null);
           $params = json_decode($json); 

           // Recoger el objeto del usuario identificado.
           $identity = $jwt_auth->checkToken($token, true);

           // Comprobar y validar datos.
           if(!empty($json)){
            $user_id = ($identity->sub != null) ? $identity->sub : null;
            $title = (empty($params->title)) ? $params->title : null;
            $description = (empty($params->description)) ? $params->description : null;
            $url = (empty($params->url)) ? $params->url : null;

            if(!empty($user_id) && !empty($title)){
                // Guardar el nuevo video favorito en la db.
                $em = $this->getDoctrine()->getManager();
                
                $user = $this->getDoctrine()->getRepository(User::class)->findOneBy([
                    'id' => $user_id
                ]);

                $video = new Video();
                $video->setUser($user);
                $video->setTitle($title);
                $video->setDescription($description);
                $video->setUrl($url);
                $video->setStatus('normal');

                $created_at = new DateTime('now');
                $updated_at = new DateTime('now');

                $video->setCreatedAt($created_at);
                $video->setUpdatedAt($updated_at);

                // Guardar en db.
                $em->persist($video);
                $em->flush();

                // devolver una respuesta.
                $data = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Video guardado exitosamente',
                    'video' => $video
                );
                
            }

        } 

    }

        return $this->json($data);
    }


    public function videos(Request $request, JwtAuth $jwt_Auth){
        // Recoger la cabezera.

        // Comprobar el token.

        // Si es valido, Coneguir obj de usuario.

        // Conf el bundle de la paginacion.

        // Hacer una consulta para paginar 

        // Recoger el parametro de la url.

        // invocar paginacion 

        // Preparar array de datos para devolver.
        
        $data = array(
            'status' => 'error',
            'code' => 404,
            'message' => 'ruta de paginacion'
        );
        return $this->json($data);
    }

}
