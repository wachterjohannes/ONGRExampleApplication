<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Item;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    const PAGE_SIZE = 10;

    /**
     * @Route("/", name="list", methods={"GET"})
     */
    public function indexAction(Request $request)
    {
        $repository = $this->get('app.item_repository');

        return $this->render(
            'default/index.html.twig',
            [
                'items' => $repository->findItems($request->get('page', 1), self::PAGE_SIZE, $request->get('q')),
                'pages' => ceil($repository->count($request->get('q')) / self::PAGE_SIZE) ?: 1,
                'page' => $request->get('page', 1),
                'q' => $request->get('q'),
            ]
        );
    }

    /**
     * @Route("/", name="post", methods={"POST"})
     */
    public function postAction(Request $request)
    {
        $item = new Item();
        $item->setTitle($request->get('title'));
        $item->setCreatedAt(new \DateTime());

        $this->get('app.item_manager')->create($item);

        return $this->redirectToRoute('list');
    }

    /**
     * @Route("/{id}/_delete", name="delete")
     */
    public function deleteAction($id)
    {
        $this->get('app.item_manager')->remove($id);

        return $this->redirectToRoute('list');
    }
}
