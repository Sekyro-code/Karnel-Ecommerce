<?php

namespace App\Controller;

use App\Class\Search;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Product;
use App\Form\SearchType;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    #[Route('/produits', name: 'app_product')]
    public function index(Request $request): Response
    {


        // instanciation de la classe Search
        $products = $this->entityManager->getRepository(Product::class)->findAll(); // récupération de tous les produits
        $search = new Search(); // instanciation de la classe Search
        $form = $this->createForm(SearchType::class, $search); // instanciation du formulaire
        $form->handleRequest($request); // Ecoute le formulaire pour savoir si il a été soumis
        if ($form->isSubmitted() && $form->isValid()) { // Si le formulaire est soumis et valide // Récupère les informations du formulaire
            $products = $this->entityManager->getRepository(Product::class)->findWithSearch($search);
            return $this->render('product/products.html.twig', [
                'products' => $products,
                'form' => $form->createView()    // Affiche le formulaire
            ]);
        } else {
            return $this->render('product/products.html.twig', [
                'products' => $products,
                'form' => $form->createView()
            ]);
        }
    }

    #[Route('/produit/{slug}', name: 'app_product_show')]
    public function show(string $slug, Request $request): Response
    {
        $product = $this->entityManager->getRepository(Product::class)->findOneBy(['slug' => $slug]);
        if (!$product) {
            return $this->redirectToRoute('app_product');
        }

        return $this->render('product/product.html.twig', [
            'product' => $product
        ]);
    }
}
