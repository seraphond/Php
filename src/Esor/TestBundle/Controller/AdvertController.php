<?php
/**
 * Created by PhpStorm.
 * User: erwan
 * Date: 18/04/17
 * Time: 12:27
 */


namespace Esor\TestBundle\Controller;


use Esor\TestBundle\Entity\Advert;
use Esor\TestBundle\Entity\Application;
use Esor\TestBundle\Entity\Image;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class AdvertController extends Controller
{


    public function indexAction($page)
    {

        /*if ($page < 1) {
            throw new NotFoundHttpException('Page "' . $page . '"inexistante');

        }
        $contenu = $this->get('templating')->render('EsorTestBundle:Advert:index.html.twig');

        return new Response($contenu);*/
        // Notre liste d'annonce en dur

        $listAdverts = array(
            array(
                'title' => 'Recherche développpeur Symfony',
                'id' => 1,
                'author' => 'Alexandre',
                'content' => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
                'date' => new \Datetime()),
            array(
                'title' => 'Mission de webmaster',
                'id' => 2,
                'author' => 'Hugo',
                'content' => 'Nous recherchons un webmaster capable de maintenir notre site internet. Blabla…',
                'date' => new \Datetime()),
            array(
                'title' => 'Offre de stage webdesigner',
                'id' => 3,
                'author' => 'Mathieu',
                'content' => 'Nous proposons un poste pour webdesigner. Blabla…',
                'date' => new \Datetime())
        );
        return $this->render('EsorTestBundle:Advert:index.html.twig', array(

            'listAdverts' => $listAdverts));

    }


    /*  $tag = $request->query->get('tag');

      return new Response("Affichage de l'annonce d'id : ".$id.", avec le tag : ".$tag);*/
    //return new Response("Affichage de id: ".$id);
    //return $this->render('EsorTestBundle:Advert:view.html.twig', array('id' => $id));
    public function viewAction($id)
    {
        /* $advert = array(
             'title'   => 'Recherche développpeur Symfony2',
             'id'      => $id,
             'author'  => 'Alexandre',
             'content' => 'Nous recherchons un développeur Symfony2 débutant sur Lyon. Blabla…',
             'date'    => new \Datetime()
         );
 */
        /* $advert=new Advert;
         $advert->setContenu("Recherche Dev.");
          return $this->render('@EsorTest/Advert/view.html.twig', array(
              'advert' => $advert
          ));
  */
        /*$repo=$this->getDoctrine()->getManager()->getRepository('EsorTestBundle:Advert');

        //on récupère l'entitée via son id

          $advert = $repo->find($id);

          if(null == $advert){
              throw new NotFoundHttpException("cette annonce n'existe pas");
          }

          return $this->render('EsorTestBundle:Advert:view.html.twig',array('advert' => $advert));
        */

        $em = $this->getDoctrine()->getManager();
        $advert = $em->getRepository('EsorTestBundle:Advert')->find($id);
        if (null === $advert) {
            throw new NotFoundHttpException("L'annonce d'id " . $id . " n'existe pas");

        }
        $listApplications = $em->getRepository('EsorTestBundle:Advert')->findBy(array('advert' => $advert));
        return $this->render('EsorTestBundle:Advert:view.html.twig', array('advert' => $advert, 'listApplications' => $listApplications));

    }


    public function viewSlugAction($slug, $year, $format)
    {
        return new Response(
            "On pourrait afficher l'annonce correspondant au
            slug '" . $slug . "', créée en " . $year . " et au format " . $format . "."
        );
    }

    public function genRateAction()
    {
        //$url = $this->get('router')->generate('esor_test_view',array('id'=> 5)); // $url vaux /platform
        $url = $this->get('router')->generate('esor_test_home', array(), UrlGeneratorInterface::ABSOLUTE_URL);  // $url vaux http://monsite.com/platform
        return new Response("L'URL de l'annonce d'id 5 est : " . $url);

    }

    public function redirectionAction()
    {
        $url = $this->get('router')->generate('esor_test_home');

        return new RedirectResponse($url); // return $this->redirect($url); ou encore  return $this->redirectToRoute('oc_platform_home');
    }

    public function addAction(Request $request)
    {

        // On récupère le service
        $antispam = $this->get('Esor_Test.antispam');

        // Je pars du principe que $text contient le texte d'un message quelconque
        $text = 'truc';
        if ($antispam->isSpam($text)) {
            throw new \Exception('Votre message a été détecté comme spam !');
        }

        // Ici le message n'est pas un spam

        /*$session = $request->getSession();

        $session->getFlashBag()->add('info', 'Annonce bien enregistrée');

        $session->getFlashBag()->add('info', 'Oui oui, elle est bien enregistrée !');

        return $this->redirectToRoute('esor_test_view', array('id' => 5));

        */
        $advert = new Advert();
        $advert->setTitre('Recherche dev symfony');
        $advert->setAuteur('Seraph');
        $advert->setContenu("Nous recherchons .... bah lis l'annonce bordel");

        //immage

        // Création de l'entité Image
        $image = new Image();
        $image->setUrl('http://sdz-upload.s3.amazonaws.com/prod/upload/job-de-reve.jpg');
        $image->setAlt('Job de rêve');

        // On lie l'image à l'annonce
        $advert->setImage($image);

        $em = $this->getDoctrine()->getManager();
        $em->persist($advert);
        $em->flush();


        // 1er candidature
        $application1 = new Application();
        $application1->setAuthor('Quelqun');
        $application1->setContent("j'apporte les croissants");

        // 2eme
        $application2 = new Application();
        $application2->setAuthor('un autre');
        $application2->setContent("j'apporte les pains aux chocolats");

        //on lie les candidatures a l'annonce
        $application1->getAdvert($advert);
        $application2->setAdvert($advert);

        // On récupère l'EntityManager
        $em = $this->getDoctrine()->getManager();

        // Étape 1 : On « persiste » l'entité
        $em->persist($advert);
        $em->persist($application1);
        $em->persist($application2);


        $em->flush();


        if ($request->isMethod('POST')) {
            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

            // Puis on redirige vers la page de visualisation de cettte annonce
            return $this->redirectToRoute('esor_test_view', array('id' => $advert->getId()));
        }

        // Si on n'est pas en POST, alors on affiche le formulaire
        return $this->render('EsorTestBundle:Advert:add.html.twig', array('advert' => $advert));
    }


    public function deleteAction($id)

    {


        return $this->render('OCPlatformBundle:Advert:delete.html.twig');

    }


    public function editAction($id, Request $request)
    {
        // Ici, on récupérera l'annonce correspondante à $id

        // Même mécanisme que pour l'ajout
        /* if ($request->isMethod('POST')) {
             $request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée.');

             return $this->redirectToRoute('esor_test_view', array('id' => 5));
         }

         return $this->render('esor:Advert:edit.html.twig');*/

        $advert = array(
            'title' => 'Recherche développpeur Symfony',
            'id' => $id,
            'author' => 'Alexandre',
            'content' => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
            'date' => new \Datetime()
        );

        return $this->render('OCPlatformBundle:Advert:edit.html.twig', array(
            'advert' => $advert
        ));
    }

    public function menuAction($limit)
    {
        // On fixe en dur une liste ici, bien entendu par la suite
        // on la récupérera depuis la BDD !
        $listAdverts = array(
            array('id' => 2, 'title' => 'Recherche développeur Symfony'),
            array('id' => 5, 'title' => 'Mission de webmaster'),
            array('id' => 9, 'title' => 'Offre de stage webdesigner')
        );

        return $this->render('EsorTestBundle:Advert:menu.html.twig', array(
            // Tout l'intérêt est ici : le contrôleur passe
            // les variables nécessaires au template !
            'listAdverts' => $listAdverts
        ));
    }

}
