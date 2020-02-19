<?php

namespace App\Controller;

use App\Entity\Album;
use App\Entity\Category;
use App\Form\AlbumType;
use App\Repository\AlbumRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AlbumController extends AbstractController
{

    private $menu_categories;
    function __construct(CategoryRepository $repo)
    {
        $this->menu_categories = $repo->findAll();
    }

    /**
     * @Route("/", name="album_index", methods={"GET"})
     */
    public function index(AlbumRepository $albumRepository): Response
    {
        $menu_categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        return $this->render('album/index.html.twig', [
            'albums' => $albumRepository->findAll(),
            'menu_categories'=>$this->menu_categories 
        ]);
    }

    /**
     * @Route("/new", name="album_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $album = new Album();
        $form = $this->createForm(AlbumType::class, $album);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($album);
            $entityManager->flush();
            $this->addFlash('success','L\'album a bien été ajouté');

            return $this->redirectToRoute('album_index');
        }

        return $this->render('album/new.html.twig', [
            'album' => $album,
            'form' => $form->createView(),
            'menu_categories'=>$this->menu_categories 
        ]);
    }

    /**
     * @Route("/{id}", name="album_show", methods={"GET"})
     */
    public function show(Album $album): Response
    {
        return $this->render('album/show.html.twig', [
            'album' => $album,
            'menu_categories'=>$this->menu_categories 
        ]);
    }

    /**
     * @Route("/{id}/edit", name="album_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Album $album): Response
    {
        $form = $this->createForm(AlbumType::class, $album);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success','L\'album a bien été modifié');

            return $this->redirectToRoute('album_index');
        }

        return $this->render('album/edit.html.twig', [
            'album' => $album,
            'form' => $form->createView(),
            'menu_categories'=>$this->menu_categories 
        ]);
    }

    /**
     * @Route("/{id}", name="album_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Album $album): Response
    {
        if ($this->isCsrfTokenValid('delete'.$album->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($album);
            $entityManager->flush();
            $this->addFlash('danger','L\'album a bien été supprimé');
        }

        return $this->redirectToRoute('album_index');
    }

     /**
     * @Route("/album/{id}", name="album_category")
     */
    public function AlbumByCategory($id, CategoryRepository $repo){
        $category = $repo->find($id);
        $albums = $category->getAlbum();
        return $this->render('album/index.html.twig', [
            'albums'=> $albums,
            'menu_categories'=>$this->menu_categories 
        ]);
    }
}
