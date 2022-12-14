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

use Knp\Component\Pager\PaginatorInterface;

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

    public function createVideo(Request $request, JwtAuth $jwt_auth, $id = null){
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
            $title = (!empty($params->title)) ? $params->title : null;
            $description = (!empty($params->description)) ? $params->description : null;
            $url = (!empty($params->url)) ? $params->url : null;

            if(!empty($user_id) && !empty($title)){
                // Guardar el nuevo video favorito en la db.
                $em = $this->getDoctrine()->getManager();
                $user = $this->getDoctrine()->getRepository(User::class)->findOneBy([
                    'id' => $user_id
                ]);

                if($id == null){
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
                }else{
                    $video =  $this->getDoctrine()->getRepository(Video::class)->findOneBy([
                        'id' => $id,
                        'user' => $identity->sub
                    ]);

                    if($video && is_object($video)){
                        $video->setTitle($title);
                        $video->setDescription($description);
                        $video->setUrl($url);
                        $video->setStatus('normal');

                        $updated_at = new DateTime('now');

                        $video->setCreatedAt($created_at);
                        $video->setUpdatedAt($updated_at);

                        $em->persist($video);
                        $em->flush();

                        $data = [
                            'status' => 'success',
                            'code' => 200,
                            'message' => 'video actualizado',
                            'video' => $video
                        ];
                    }
                }
            }
        } 
        return new jsonResponse($data);
    }

        
    }


    public function videos(Request $request, JwtAuth $jwt_Auth, PaginatorInterface $paginator){
        // Recoger la cabezera.
        $token = $request->headers->get('Authorization');

        // Comprobar el token.
        $auth_check = $jwt_Auth->checkToken($token);

        // Si es valido
        if($auth_check == true){
            // Coneguir obj de usuario.
            $identity = $jwt_Auth->checkToken($token, true);            
            $em = $this->getDoctrine()->getManager();

            // Hacer una consulta para paginar 
            $dql = "SELECT v FROM App\Entity\Video v WHERE
             v.user = {$identity->sub} ORDER BY v.id DESC";

            $query = $em->createQuery($dql);

            // Recoger el parametro de la url.
            $page = $request->query()->getInt('page', 1);
            $itemsPerPage = 5;

            // invocar paginacion 
            $pagination = $paginator->paginate($query, $page, $itemsPerPage);
            $total = $pagination->getTotalItemCount();

            // Preparar array de datos para devolver.
            $data = array(
                'status' => 'success',
                'code' => 200,
                'total_items_count' => $total,
                'page_actual' => $page,
                'items_per_page' => $itemsPerPage,
                'total_pages' => ceil($total / $itemsPerPage),
                'videos' => $pagination,
                'user' => $identity->sub
            );

        }else{
            $data = array(
                'status' => 'error',
                'code' => 404,
                'message' => 'ruta de paginacion'
            );
        }

        return new JsonResponse($data);
    }

    public function detail(Request $request, JwtAuth $jwt_Auth, $id = null){
        // Sacar el token y comprobar si es corecto.
        $token = $request->headers->get('Authorization');
        $auth_check = $jwt_Auth->checkToken($token);

        if($auth_check){
            // sacar la identidad del usuario 
            $identity = $jwt_Auth->checkToken($token, true);
            
            // Sacar el video en base al id
            $video = $this->getDoctrine()->getRepository(Video::class)->findOneBy([
                'id' => $id
            ]);

            if($video && is_object($video) && $identity->sub == $video->getUser()->getId()){
                $data = [
                    'status' => 'success',
                    'code' => 200,
                    'video' => $video
                ];
            }

            // Sacar el video y ver si es de usuario identificado

        }else{
            // Devolver una respuesta
            $data = [
                'status' => 'error',
                'code' => 404,
                'message' => 'Video no encontrado'
            ];
        }

        return $this->json($data);
    }

    public function remove(Request $request, JwtAuth $jwt_Auth, $id){
        $token = $request->headers->get('Authorization');
        $auth_check = $jwt_Auth->checkToken($token);
        // Devolver una respuesta
            $data = [
                'status' => 'error',
                'code' => 404,
                'message' => 'Video no encontrado'
            ];

        if($auth_check){
            $identity = $jwt_Auth->checkToken($token, true);

            $doctrine = $this->getDoctrine();
            $em = $doctrine->getManager();

            $video = $doctrine->getRepository(Video::class)->findOneBy([
               'id' => $id
            ]);

            if($video && is_object($video) && $identity->sub == $video->getUser()->getId()){
                $em->remove($video);
                $em->flush();

                // Devolver una respuesta
                $data = [
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'video eliminado'
                ];

            }
        }

        return $this->json($data);

    }

}
