<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use DateTime;

class ApiPostController extends AbstractController
{
    /**
     * @Route("/api/post", name="api_post_index", methods={"GET"} )
     */
    public function index(PostRepository $postRepository): Response
    {
        return $this->json(
            $postRepository->findAll(),
            200,
            [],
            ['groups' => 'post:read']
        );
    }

    /**
     * @Route("/api/post", name="api_post_created", methods={"POST"})
     */
    public function store(Request $request, SerializerInterface $serializerInterface, EntityManagerInterface $em): Response{

        $json_received = $request->getContent();

        $post = $serializerInterface->deserialize($json_received, Post::class, 'json');

        $post->setCreatedAt(new \DateTime());

        $em->persist( $post );
        $em->flush();

        return $this->json($post, 200);
    }
}
