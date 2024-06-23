<?php

namespace App\Class;

use Symfony\Component\HttpFoundation\RequestStack;

class Cart
{
    private $session;
    public function __construct(private RequestStack $requestStack)
    {
        $this->session = $this->requestStack->getSession();
    }

    public function addItem($id, $quantity)
    {
        $cart = $this->session->get('cart', []); // Récupère le panier actuel s'il existe sinon un tableau vide (qui sera rempli avec les items du panier)
        if (!empty($cart[$id])) { // (si il n'est pas vide) Vérifie si le produit est déja dans le panier (si il n'est pas vide)
            $cart[$id] += $quantity; // Incrémente le nombre de fois que le produit est dans le panier
        } else {
            $cart[$id] = $quantity; // Ajoute le produit au panier avec une quantité de 1
            // $cart[$id] = 1; // Ajoute le produit au panier avec une quantité de 1
        }
        $this->session->set('cart', $cart); // Enregistre le panier
    }

    public function getFullCart()
    {
        return $this->session->get('cart');
    }

    public function removeCartById($id)
    {
        if (!empty($this->session->get('cart')[$id])) { // Vérifie si le produit est dans le panier
            $newCart = $this->session->get('cart'); // Récupère le panier
            unset($newCart[$id]); // Supprime le produit du panier
            $this->session->set('cart', $newCart); // Enregistre le panier
        }
    }

    public function removeAllCart()
    {
        $this->session->remove('cart');
    }
}
