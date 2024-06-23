<?php

namespace App\Controller;

use App\Class\Cart;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Expr\FuncCall;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CartController extends AbstractController
{
    public function __construct(private Cart $cart, private EntityManagerInterface $entityManager)
    {
        $this->cart = $cart;
        $this->entityManager = $entityManager;
    }
    #[Route('/panier', name: 'app_cart')]
    public function index(): Response
    {
        $cart = $this->cart->getFullCart();
        $productTab = [];
        if (!empty($cart)) {
            foreach ($cart as $id => $quantity) {
                $item = $this->entityManager->getRepository(Product::class)->findOneById($id);

                if ($item) {
                    $productTab[] = [
                        'product' => $item,
                        'quantity' => $quantity
                    ];
                }
            }
        }
        return $this->render('cart/cart.html.twig', [
            'cart' => $cart,
            'products' => $productTab
        ]);
    }

    #[Route('/panier/add/{id}/{slug}', name: 'app_cart_add')]
    public function add($id, $slug, Request $request): Response
    {
        if (true) { /// TODO : vérifier si le produit est dans le panier)
            $quantity = $request->request->get('quantity', 1); // Récupère la quantité dans le formulaire
            $this->cart->addItem($id, $quantity); // Ajoute le produit au panier
            $this->addFlash('success', 'Produit ajouté au panier avec succès'); // Affiche un message flash
        } else {
            $this->addFlash('error', "Le produit n'est plus en stocke"); // Affiche un message flash
        }
        return $this->redirectToRoute('app_product_show', ['slug' => $slug]); // Redirige vers la page du produit
    }


    #[Route('/panier/remove/{id}', name: 'app_cart_remove')]
    public function removeCartById($id)
    {
        $this->cart->removeCartById((int)$id);
        return $this->index();
    }


    #[Route('/panier/vider/panier', name: 'app_cart_remove_all')]
    public function removeAllCart()
    {
        $this->cart->removeAllCart();
        return $this->index();
    }
}
