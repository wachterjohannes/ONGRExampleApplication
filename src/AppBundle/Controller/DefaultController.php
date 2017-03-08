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

        $page = $request->get('page', 1);
        $filter = $request->query->get('filter');
        $query = $request->query->get('q');

        return $this->render(
            'default/index.html.twig',
            [
                'items' => $repository->findItems($page, self::PAGE_SIZE, $query, $filter),
                'pages' => ceil($repository->count($query, $filter) / self::PAGE_SIZE) ?: 1,
                'page' => $page,
                'q' => $query,
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
