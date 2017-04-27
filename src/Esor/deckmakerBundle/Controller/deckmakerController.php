<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 27/04/17
 * Time: 09:45
 */

namespace Esor\deckmakerBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Esor\deckmakerBundle\Entity\Card;
use Esor\deckmakerBundle\Form\CardType;
use Symfony\Component\HttpFoundation\Request;

class deckmakerController extends controller{

        public function addCardAction(Request $request){
            $Card =new Card();
            $form = $this->get('form.factory')->create(CardType::class, $Card);
            if ($request->isMethod('POST')) {
                // On fait le lien Requête <-> Formulaire
                // À partir de maintenant, la variable $advert contient les valeurs entrées dans le formulaire par le visiteur
                $form->handleRequest($request);
                // On vérifie que les valeurs entrées sont correctes
                // (Nous verrons la validation des objets en détail dans le prochain chapitre)
                if ($form->isValid()) {
                    /* $advert->getImage()->upload();*/ // plus utile maintenant que c'est géré par événements
                    // On enregistre notre objet $advert dans la base de données, par exemple
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($Card);
                    $em->flush();

                    $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

                    // On redirige vers la page de visualisation de la carte nouvellement créée
                    //mais plus tard
                    return $this->redirectToRoute('esor_test_home'/*, array('id' => $Card->getId())*/);
                }
            }
            return $this->render('EsordeckmakerBundle:deckmaker:addCard.html.twig',array('Card' => $Card, 'form' => $form->createView(),
            ));
        }


}