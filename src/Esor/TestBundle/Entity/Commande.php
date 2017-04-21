<?php

/**
 * Created by PhpStorm.
 * User: erwan
 * Date: 19/04/17
 * Time: 14:19
 */
class Commande
{
    public function getPrixTotal()
    {
        $prix = 0;
        foreach ($this->getListeProduits() as $produit) {
            $prix += $produit->getPrix();
        }

        return $prix;
    }
}