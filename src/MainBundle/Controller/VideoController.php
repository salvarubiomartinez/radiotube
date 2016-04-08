<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class VideoController extends Controller {

    //Indice
    public function IndexAction() {
        $videos = $this->getDoctrine()->getRepository('MainBundle:Video')->findAll();
        return $this->render('MainBundle:Video:index.html.twig', array(
                    'videos' => $videos
        ));
    }
    
    //Formulario para crear videos
    public function CreateAction(Request $request) {
        $video = new \MainBundle\Entity\Video();

        $form = $this->createFormBuilder($video)
                ->add('nombre', TextType::class)
                ->add('autor', TextType::class)
                ->add('descripcion', TextareaType::class)
                ->add('VideoFile', FileType::class, array('label' => 'Video'))
                ->add('envia', SubmitType::class)
                ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($video);
            $em->flush();
            return $this->redirectToRoute('_index');
        }

        return $this->render('MainBundle:Video:create.html.twig', array(
                    'formulari' => $form->createView(),
        ));
    }

    //Acción de vista de detalle de un video
    public function DetailsAction($id) {

        //Cogemos el vídeo con sus comentarios y valoraciones
        $video = $this->getDoctrine()->getRepository('MainBundle:Video')->find($id);
        $comentarios = $this->getDoctrine()->getRepository('MainBundle:Comentario')->findByvideoid($id);
        $valoraciones = $this->getDoctrine()->getRepository('MainBundle:Valoracion')->findByvideoid($id);

        //Si no hay comentarios añadimos un mensaje
        if (count($comentarios) == 0) {
            $mensaje = new \MainBundle\Entity\Comentario();
            $mensaje->setComentario("No hay comentarios");
            array_push($comentarios, $mensaje);
        }
        
        //Calculamos la valoración media y le asignamos estrellas
        if (count($valoraciones) != 0) {
            $valoracionGlobal = 0;
            foreach ($valoraciones as $valoracion) {
                $valoracionGlobal = $valoracionGlobal + $valoracion->getValoracion();
            }
            $valoracionGlobal = intval($valoracionGlobal / count($valoraciones));
            $estrellas = "";
            for ($i = 0; $i < $valoracionGlobal; $i++) {
                $estrellas = $estrellas . "&#9734;&emsp;";
            }
        } else {
            $estrellas = "No hay valoraciones";
        }
        return $this->render('MainBundle:Video:details.html.twig', array(
                    'video' => $video, 'comentarios' => $comentarios, 'valoracion' => $estrellas
        ));
    }

    //Acción de vista parcial para crear comentarios
    public function ComentarioAction($videoId, Request $request) {
        $video = $this->getDoctrine()->getRepository('MainBundle:Video')->find($videoId);
        $comentario = new \MainBundle\Entity\Comentario();
        $comentario->setVideoid($video);

        $form = $this->createFormBuilder($comentario)
                ->setAction($this->generateUrl('_comentario', array('videoId' => $videoId)))
                ->add('comentario', TextareaType::class)
                ->add('envia', SubmitType::class)
                ->getForm();

        $formView = $form->createView();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($comentario);
            $em->flush();
            return $this->redirectToRoute('_details', array('id' => $comentario->getVideoid()->getId()));
        }
        return $this->render('MainBundle:Video:comentario.html.twig', array(
                    'comentario' => $formView
        ));
    }

    //Acción de vista parcial para crear valoraciones
    public function ValoracionAction($videoId, Request $request) {
        if ($this->getRequest()->isMethod('GET')) {
            return $this->render('MainBundle:Video:valoracion.html.twig', array(
                        'videoId' => $videoId
            ));
        } else if ($this->getRequest()->isMethod('POST')) {
            $video = $this->getDoctrine()->getRepository('MainBundle:Video')->find($videoId);
            $valoracion = new \MainBundle\Entity\Valoracion();
            $valoracion->setVideoid($video);
            $valoracion->setValoracion($request->get('valoracion'));
            $em = $this->getDoctrine()->getManager();
            $em->persist($valoracion);
            $em->flush();
            return $this->redirectToRoute('_details', array('id' => $videoId));
        }
    }

    //Acción de vista parcial para eliminar un vídeo
    public function DeleteAction($id) {
        if ($this->getRequest()->isMethod('GET')) {
            $video = $this->getDoctrine()->getRepository('MainBundle:Video')->find($id);
            return $this->render('MainBundle:Video:delete.html.twig', array(
                        'video' => $video
            ));
        } else if ($this->getRequest()->isMethod('POST')) {
            $em = $this->getDoctrine()->getManager();
            $video = $em->getRepository('MainBundle:Video')->find($id);

            if (!$video) {
                throw $this->createNotFoundException(
                        'No se encuentra el video ' . $id
                );
            }
            $em->remove($video);
            $em->flush();
            return $this->redirectToRoute('_index');
        }
    }

    //Acción de la vista de Ranking
    public function RankingAction() {
        $videos = $this->getDoctrine()->getRepository('MainBundle:Video')->findAll();
        $valoracionGlobal = Array();
        
        //Calculamos la valoración media de cada vídeo y se la añadimos al vídeo
        foreach ($videos as $video) {
            $valoraciones = $this->getDoctrine()->getRepository('MainBundle:Valoracion')->findByvideoid($video->getId());
            $valoracionGlobal = 0;
            if (count($valoraciones) != 0) {
                foreach ($valoraciones as $valoracion) {
                    $valoracionGlobal = $valoracionGlobal + $valoracion->getValoracion();
                }
                $valoracionGlobal = ($valoracionGlobal / count($valoraciones));
            }
            $video->setValoracion(number_format((float) $valoracionGlobal, 1, '.', ''));
        }
        return $this->render('MainBundle:Video:ranking.html.twig', array(
                    'videos' => $videos
        ));
    }

    //Acción de búsqueda de vídeos
    public function SearchAction(Request $request) {

        $searchString = $request->request->get('searchString');

        $query = $this
                ->container
                ->get('doctrine')
                ->getManager()
                ->createQuery(
                        'SELECT e FROM MainBundle:Video e WHERE e.nombre LIKE :search OR e.descripcion LIKE :search OR e.autor LIKE :search'
                )
                ->setParameter('search', '%' . $searchString . '%');

        $videos = $query->getResult();
        return $this->render('MainBundle:Video:search.html.twig', array(
                    'videos' => $videos, 'searchString' => $searchString
        ));
    }

}
