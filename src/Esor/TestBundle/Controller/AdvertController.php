<?php
/**
 * Created by PhpStorm.
 * User: erwan
 * Date: 18/04/17
 * Time: 12:27
 */


namespace Esor\TestBundle\Controller;


use Esor\TestBundle\Entity\Advert;
use Esor\TestBundle\Form\AdvertEditType;
use Esor\TestBundle\Form\AdvertType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class AdvertController extends Controller
{


    public function indexAction($page, Request $request)
    {
        //print_r($page);

       // $contenu = $this->get('templating')->render('EsorTestBundle:Advert:index.html.twig');

       // return new Response($contenu);
        // Notre liste d'annonce en dur

       /* $listAdverts = array(
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
       */





        if ($page < 1) {
            throw new NotFoundHttpException('Page "' . $page . '"inexistante');

        }

        $nbPerPage = 5;

        // On récupère notre objet Paginator
        $listAdverts = $this->getDoctrine()
            ->getManager()
            ->getRepository('EsorTestBundle:Advert')
            ->getAdverts($page, $nbPerPage);


       // $temp=$thivar/cache/devs->getDoctrine()->getManager()->getRepository('EsorTestBundle:Advert')->getAdverts($page,$nbPerPage);
        //$pagination=$temp[0]->paginate($temp[1],$request->query->get('page',$page),$nbPerPage);
        // On calcule le nombre total de pages grâce au count($listAdverts) qui retourne le nombre total d'annonces
        $nbPages = ceil(count($listAdverts) / $nbPerPage);



        // Si la page n'existe pas, on retourne une 404

        if ($page > $nbPages) {
            throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }

        return $this->render('EsorTestBundle:Advert:index.html.twig',array('listAdverts' => $listAdverts,'nbPages' => $nbPages,'page' => $page));

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
        $listApplications = $em->getRepository('EsorTestBundle:Application')->findBy(array('advert' => $advert));
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
        // On crée un objet Advert
        $advert = new Advert();
        $form = $this->get('form.factory')->create(AdvertType::class, $advert);
        // Si la requête est en POST
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
                $em->persist($advert);
                $em->flush();

                $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

                // On redirige vers la page de visualisation de l'annonce nouvellement créée
                return $this->redirectToRoute('esor_test_view', array('id' => $advert->getId()));
            }
        }

        // À ce stade, le formulaire n'est pas valide car :
        // - Soit la requête est de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
        // - Soit la requête est de type POST, mais le formulaire contient des valeurs invalides, donc on l'affiche de nouveau
        return $this->render('EsorTestBundle:Advert:add.html.twig', array('advert' => $advert, 'form' => $form->createView(),
        ));



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
        /*
        $em = $this->getDoctrine()->getManager();

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



        // 1er candidature
        $application1 = new Application();
        $application1->setAuthor('Quelqun');
        $application1->setContent("j'apporte les croissants");
        $application1->setAdvert($advert);

        $em->persist($advert);
        $em->persist($application1);



        // 2eme
        $application2 = new Application();
        $application2->setAuthor('un autre');
        $application2->setContent("j'apporte les pains aux chocolats");

        //on lie les candidatures a l'annonce
        // $application1->getAdvert($advert);
        $application2->setAdvert($advert);

        // On récupère l'EntityManager
        // $em = $this->getDoctrine()->getManager();

        // Étape 1 : On « persiste » l'entité


        $em->persist($application2);


        $em->flush();


        if ($request->isMethod('POST')) {
            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

            // Puis on redirige vers la page de visualisation de cettte annonce
            return $this->redirectToRoute('esor_test_view', array('id' => $advert->getId()));
        }

        // Si on n'est pas en POST, alors on affiche le formulaire
        return $this->render('EsorTestBundle:Advert:add.html.twig', array('advert' => $advert));
        */
    }


    public function deleteAction($id , Request $request)
    {
        $em = $this->getDoctrine()->getManager();


        // On récupère l'annonce $id
        $advert = $em->getRepository('EsorTestBundle:Advert')->find($id);
        if (null === $advert) {
            throw new NotFoundHttpException("L'annonce d'id " . $id . " n'existe pas.");
        }


        // On crée un formulaire vide, qui ne contiendra que le champ CSRF
        // Cela permet de protéger la suppression d'annonce contre cette faille

        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->remove($advert);
            $em->flush();
            // On boucle sur les catégories de l'annonce pour les supprimer
            /* foreach ($advert->getCategories() as $category) {
                 $advert->removeCategory($category);
             }
     */

            // Pour persister le changement dans la relation, il faut persister l'entité propriétaire

            // Ici, Advert est le propriétaire, donc inutile de la persister car on l'a récupérée depuis Doctrine


            // On déclenche la modification


            $url = $this->get('router')->generate('esor_test_home');

            return new RedirectResponse($url);

        }

        return $this->render('@EsorTest/Advert/delete.html.twig', array(
            'advert' => $advert,
            'form'   => $form->createView()));
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
        $em = $this->getDoctrine()->getManager();

        // On récupère l'annonce $id
        $advert = $em->getRepository('EsorTestBundle:Advert')->find($id);

        if (null === $advert) {
            throw new NotFoundHttpException("L'annonce d'id " . $id . " n'existe pas.");
        }

        // La méthode findAll retourne toutes les catégories de la base de données
        /*$listCategories = $em->getRepository('EsorTestBundle:Category')->findAll();*/ //nope

        // On boucle sur les catégories pour les lier à l'annonce
        /*  foreach ($listCategories as $category) {
              $advert->addCategory($category);
          }
          */

        $form = $this->get('form.factory')->create(AdvertEditType::class, $advert);
        // Si la requête est en POST
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
                $em->persist($advert);
                $em->flush();

                $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

                // On redirige vers la page de visualisation de l'annonce nouvellement créée
                return $this->redirectToRoute('esor_test_view', array('id' => $advert->getId()));
            }
        }

        // À ce stade, le formulaire n'est pas valide car :
        // - Soit la requête est de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
        // - Soit la requête est de type POST, mais le formulaire contient des valeurs invalides, donc on l'affiche de nouveau
        return $this->render('EsorTestBundle:Advert:edit.html.twig', array('advert' => $advert, 'form' => $form->createView(),
        ));

        // Pour persister le changement dans la relation, il faut persister l'entité propriétaire
        // Ici, Advert est le propriétaire, donc inutile de la persister car on l'a récupérée depuis Doctrine

        // Étape 2 : On déclenche l'enregistrement
        $em->flush();

        return $this->render('EsorTestBundle:Advert:edit.html.twig', array(
            'advert' => $advert
        ));


    }

    public function menuAction($limit)
    {
        // On fixe en dur une liste ici, bien entendu par la suite
        // on la récupérera depuis la BDD !
       /* $listAdverts = array(
            array('id' => 2, 'title' => 'Recherche développeur Symfony'),
            array('id' => 5, 'title' => 'Mission de webmaster'),
            array('id' => 9, 'title' => 'Offre de stage webdesigner')
        );

        return $this->render('EsorTestBundle:Advert:menu.html.twig', array(
            // Tout l'intérêt est ici : le contrôleur passe
            // les variables nécessaires au template !
            'listAdverts' => $listAdverts
        ));


*/
        $em = $this->getDoctrine()->getManager();
        $listAdverts = $em->getRepository('EsorTestBundle:Advert')->findBy(array(),array('date' => 'desc'),4);
        if (null === $listAdverts) {
            throw new NotFoundHttpException("Il n\' y a pas d\'annonce.");

        }
       return $this->render('EsorTestBundle:Advert:menu.html.twig',array('listAdverts' => $listAdverts));

    }

    public function testAction(){
        $advert = new Advert;
        $advert->setDate(new \Datetime());  // Champ « date » OK
        $advert->setTitle('abc');           // Champ « title » incorrect : moins de 10 caractères
        //$advert->setContent('blabla');    // Champ « content » incorrect : on ne le définit pas
        $advert->setAuthor('A');            // Champ « author » incorrect : moins de 2 caractères
        // On récupère le service validator
        $validator = $this->get('validator');
        // On déclenche la validation sur notre object
        $listErrors = $validator->validate($advert);
        // Si $listErrors n'est pas vide, on affiche les erreurs
        if(count($listErrors) > 0) {
            // $listErrors est un objet, sa méthode __toString permet de lister joliement les erreurs
            return new Response((string) $listErrors);
        } else {
            return new Response("L'annonce est valide !");
        }
    }

}
