<?php
/**
 * Created by PhpStorm.
 * User: erwan
 * Date: 18/04/17
 * Time: 12:27
 */

namespace Esor\TestBundle\Controller;

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

        if ($page < 1) {
            throw new NotFoundHttpException('Page "' . $page . '"inexistante');

        }
        $contenu = $this->get('templating')->render('EsorTestBundle:Advert:index.html.twig');

        return new Response($contenu);

    }

    public function viewAction($id, Request $request)
    {
        /*  $tag = $request->query->get('tag');

          return new Response("Affichage de l'annonce d'id : ".$id.", avec le tag : ".$tag);*/
        //return new Response("Affichage de id: ".$id);
        return $this->render('EsorTestBundle:Advert:view.html.twig', array('id' => $id));

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
        $session = $request->getSession();


        $session->getFlashBag()->add('info', 'Annonce bien enregistrée');


        $session->getFlashBag()->add('info', 'Oui oui, elle est bien enregistrée !');


        return $this->redirectToRoute('esor_test_view', array('id' => 5));
    }

    public function deleteAction($id)

    {


        return $this->render('OCPlatformBundle:Advert:delete.html.twig');

    }


    public function editAction($id, Request $request)
    {
        // Ici, on récupérera l'annonce correspondante à $id

        // Même mécanisme que pour l'ajout
        if ($request->isMethod('POST')) {
            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée.');

            return $this->redirectToRoute('esor_test_view', array('id' => 5));
        }

        return $this->render('esor:Advert:edit.html.twig');
    }

}
