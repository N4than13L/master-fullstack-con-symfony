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


class UserController extends AbstractController
{
    /**
     * @Route("/user", name="app_user")
     */

    public function index(): JsonResponse
    {
        $user_repo = $this->getDoctrine()->getRepository(User::class);
        $video_repo = $this->getDoctrine()->getRepository(Video::class);

        $users = $user_repo->findAll();
        $user = $user_repo->find(1);
        $video = $video_repo->findAll();

        $data = [
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UserController.php',
        ];

        /* 
        foreach($users as $user){
            echo "<h1>{$user->getName()} {$user->getSurname()}</h1>";

            foreach($user->getVideos() as $video){
                echo "<p>{$video->getTitle()} - {$video->getUser()->getEmail()}</p>";
            }
        }
        die();
        */

        return $this->json($video);
    }

    public function create(Request $request){
        // recoger los datos por POST
        $json = $request->get('json', null);

        // decodificar el json
        $params =json_decode($json);

        // Respuesta por defecto.
        $data = [
            'status' => 'error',
            'code' => '200',
            'message' => "usuario no esta creado"
        ];

        // Comprobar y validar datos
        if($json != null){
            $name = (!empty($params->name)) ? $params->name : null;
            $surname = (!empty($params->surname)) ? $params->surname : null;
            $email =  (!empty($params->email)) ? $params->email : null;
            $password = (!empty($params->password)) ? $params->password : null;


            $validator = Validation::createValidator();
            $validate_email = $validator->validate($email, [
                new Email()
            ]);

            if (!empty($email) && count($validate_email) == 0 && !empty($password) && !empty($name) && !empty($surname) ){
                // Si la validacion es correcta, crear el objeto de usuario
                $user = new User();
                $user->setName($name);
                $user->setSurname($surname);
                $user->setEmail($email);

                $user->setRole('ROLE-USER');
                $user->setCreatedAt(new \DateTime('now'));

                // Cifrar la contrasena 
                $pwd = hash('sha256', $password);
                $user->setPassword($pwd);

                $data= $user;

                // Comprobar si el usuario existe (duplicado)
                $doctrine = $this->getDoctrine();
                $em = $doctrine->getManager();

                $user_repo = $doctrine->getRepository(User::class);
                $isset_user = $user_repo->findBy(array(
                    'email' => $email
                ));

                // si no existe, Guardarlo en la db
                if(count($isset_user) == 0){
                    //Guardar uuario
                    $em->persist($user);
                    $em->flush();

                    $data = [
                        'status' => 'error',
                        'code' => '200',
                        'message' => "usuario creado exitosamente",
                        'user' => $user
                    ];
                }else{ 
                    $data = [
                        'status' => 'error',
                        'code' => '500',
                        'message' => "usuario ya exisste"
                    ];
                }

            }
            
        }

        // Hacer respuesta
        return new JsonResponse($data);
    }

    public function login(Request $request, JwtAuth $jwt_auth){
        // Recibir los datos por POST.
        $json = $request->get('json', null);
        $params = json_decode($json);

        // Array por defecto para devolver.
        $data = [
            'status' => 'error',
            'code' => 200,
            'messge' => 'usuario no identificado'
        ];

        // Comprobar y validar datos 
        if ($json != null){
            $email = (!empty($params->email) ? $params->email : null);
            $password = (!empty($params->password) ? $params->password : null);
            $gettoken = (!empty($params->gettoken) ? $params->gettoken : null);


            $validator = Validation::createValidator();
            $validate_email = $validator->validate($email, [
                new Email()
            ]);

            if(!empty($email) && !empty($password) && count($validate_email) == 0){
                // Cifrar la contrasena
                $pwd = hash('sha256', $password);


                /* Si todo es valido, llamaremos a un 
                servicio para 
                identificar al usuario y que 
                no devuelva un token o un objeto */
               
                if($gettoken){
                    $signup = $jwt_auth->signup($email, $pwd, $gettoken);
                }else{
                    $signup = $jwt_auth->signup($email, $pwd);
                }

                return new JsonResponse($signup);
    
            }
        }

        // Si nos devuelve bien todos los datos, respuesta.
        return new JsonResponse($data);
    }

    public function edit(Request $request){
        // Recoger la cabezera de autenticacion

        // crear un metodo para ver si es correcto el token

        // Y si es correcto, hacer la actualizacion del uuario 

        // ...

        $data = [
            'status' => 'error',
            'message' => 'Metodo para editar'
        ];

        return new JsonResponse($data);
    }


}
