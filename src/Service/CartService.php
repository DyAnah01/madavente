<?php

namespace App\Service;

use App\Entity\Articles;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{
    private RequestStack $requestStack;
    private EntityManagerInterface $em;

    public function __construct(RequestStack $requestStack, EntityManagerInterface $em)
    {
        // injection de dependance
        $this->requestStack = $requestStack;
        $this->em = $em;
    }

    public function getSession():SessionInterface
    {
        return $this->requestStack->getSession();
    }


    public function addCart(int $id_article)
    {
        // récupération du tableau d'article ajoutés au panier depuis la session
        // utilisateur
        $cart = $this->getSession()->get('cart', []);

        // vérifier si le produit existe déjà dans le panier
        if(!empty($cart[$id_article]))
        {

            // si le produit existe , on incrémente la quantité
            $cart[$id_article]++;

        }else
        {
            // sinon on ajoute le produit au panier
            $cart[$id_article] = 1;
        }
        // Mise à jour du panier dans la session utilisateur
        $this->getSession()->set('cart', $cart);

    }

    public function getTotal()
    {
        // recupearyion du tableau de produit ajouté au panier depuis la session utilisateur
        $cart = $this->getSession()->get('cart');
        $cartData = [] ;// on ajoute la quantité de produit dans le tableau
        if($cart)
        {
            foreach($cart as $id_article => $q)
            {
                // recupération du produit à partir de son id en bdd
                $fetchProduct = $this->em->getRepository(Articles::class)->findOneBy(['id' => $id_article]); //récupérer le repository de la class Article
                if($fetchProduct)
                {
                    $cartData[] = [
                        'article' => $fetchProduct,
                        'quantity' => $q,
                    ];
                }
            }
        }
        // return le tableau de produits avec leurs informations et quantités
        return $cartData;
    }

    public function decrease(int $id){
        // récupération du tableau d'article ajoutés au panier depuis la session utilisateur
        $cart = $this->getSession()->get('cart', []);
        // vérification si la quantité du produit est supérieur à 1 pour pouvoir décrémenter
        if($cart[$id] > 1)
        {
            $cart[$id]--;
        }
        else{
            unset($cart[$id]); //si la quantité du produit est = a 1 , on supprime le produit du panier
        }
        return $this->getSession()->set('cart', $cart);
        
    }
    
    public function deleteCart(int $id){ //delete just one
        // récupération du tableau de produits ajouté au panier depuis la session utilisateur
        $cart = $this->getSession()->get('cart', []);
        // suppression du produit qui est dans le panier 
        unset($cart[$id]);
        return $this->getSession()->set('cart', $cart);// modifie et met à jour ce qui a été modifié , ici $cart

    }
    public function deleteAllCart() //delete all
    {
        return $this->getSession()->remove('cart');
    }

}


?>