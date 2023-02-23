<?php

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


    public function addCard(int $id_article)
    {
        // récupération du tableau d'article ajoutés au panier depuis la session
        // utilisateur
        $cart = $this->getSession()->get('cart', []);

        // vérifier si le produit existe déjà dans le panier
        if(!empty($card[$id_article]))
        {

            // si le produit existe , on incrémente la quantité
            $cart[$id_article]++;

        }else
        {
            // sinon on ajoute le produit au panier
            $card[$id_article] = 1;
        }
        // Mise à jour du panier dans la session utilisateur
        $this->getSession()->set('cart', $cart);

    }

    public function getTotal()
    {
        // recupearyion du tableau de produit ajouté au panier depuis la session utilisateur
        $cart = $this->getSession()->get('cart');
        $cartdata = [] ;// on ajoute la quantité de produit dans le tableau
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
                        'quantity' => $q
                    ];
                }
            }
        }
        // return le tableau de produits avec leurs informations et quantités
        return $cartData;
    }

}


?>