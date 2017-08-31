<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Licence;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class LicenceController extends Controller
{

    /**
     * @Route("/", name="licences")
     */
    public function Action(Request $request)
    {

        return $this->render('licence/home.html.twig');
    }
    /**
     * @Route("/articles", name="licences_articles")
     */
    public function licencesAction(Request $request)
    {

        $licences = $this->getDoctrine()
            ->getRepository('AppBundle:Licence')
            ->findAll();
        // replace this example code with whatever you need
        return $this->render('licence/index.html.twig', array(
            'licences' => $licences
    ));
    }

    /**
     * @Route("/licences/create", name="licences_create")
     */

    public function createAction(Request $request)
    {

        // if (!$this->get('security.authorization_checker')->isGranted('ROLE_AUTEUR')) {
        //
        //     // Sinon on déclenche une exception « Accès interdit »
        //
        //     throw new AccessDeniedException('Accès limité aux auteurs.');
        //
        //  }
        $licence = new Licence;

        $form = $this->createFormBuilder($licence)
            ->add('name', TextType::class, array('attr' => array('class' => 'form-control', 'style'=>'margin-bottom:15px')))
            ->add('permissions', TextType::class, array('attr' => array('class' => 'form-control', 'style'=>'margin-bottom:15px')))
            ->add('conditions', TextType::class, array('attr' => array('class' => 'form-control', 'style'=>'margin-bottom:15px')))
            ->add('limitations', TextType::class, array('attr' => array('class' => 'form-control', 'style'=>'margin-bottom:15px')))
            ->add('save', SubmitType::class, array('label' => 'Ajouter une licence','attr' => array('class' => 'btn btn-default', 'style'=>'margin-bottom:15px')))

            ->getForm();

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                $name = $form['name']->getData();
                $permissions = $form['permissions']->getData();
                $conditions = $form['conditions']->getData();
                $limitations = $form['limitations']->getData();

                $licence->setName($name);
                $licence->setPermissions($permissions);
                $licence->setConditions($conditions);
                $licence->setLimitations($limitations);

                $em = $this->getDoctrine()->getManager();

                $em->persist($licence);
                $em->flush();

                $this->addFlash(
                    'notice',
                    'Votre licence à bien étè ajouté'
                );
                return $this->redirectToRoute('licences');
            }
        // replace this example code with whatever you need
        return $this->render('licence/create.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/licences/edit/{id}", name="licences_edit")
     */
    public function editAction($id, Request $request)
    {

                $licence = $this->getDoctrine()
                    ->getRepository('AppBundle:Licence')
                    ->find($id);
                $licence->setName($licence->getName());
                $licence->setPermissions($licence->getPermissions());
                $licence->setConditions($licence->getConditions());
                $licence->setLimitations($licence->getLimitations());


                $form = $this->createFormBuilder($licence)
                    ->add('name', TextType::class, array('attr' => array('class' => 'form-control', 'style'=>'margin-bottom:15px')))
                    ->add('permissions', TextType::class, array('attr' => array('class' => 'form-control', 'style'=>'margin-bottom:15px')))
                    ->add('conditions', TextType::class, array('attr' => array('class' => 'form-control', 'style'=>'margin-bottom:15px')))
                    ->add('limitations', TextType::class, array('attr' => array('class' => 'form-control', 'style'=>'margin-bottom:15px')))
                    ->add('save', SubmitType::class, array('label' => 'Ajouter une licence','attr' => array('class' => 'btn btn-default', 'style'=>'margin-bottom:15px')))

                    ->getForm();

                    $form->handleRequest($request);

                    if($form->isSubmitted() && $form->isValid()){
                        $name = $form['name']->getData();
                        $permissions = $form['permissions']->getData();
                        $conditions = $form['conditions']->getData();
                        $limitations = $form['limitations']->getData();

                        $em = $this->getDoctrine()->getManager();

                        $licence->setName($name);
                        $licence->setPermissions($permissions);
                        $licence->setConditions($conditions);
                        $licence->setLimitations($limitations);




                        $em->flush();

                        $this->addFlash(
                            'notice',
                            'Votre licence à bien étè modifié'
                        );
                        return $this->redirectToRoute('licences');
                    }
                // replace this example code with whatever you need
                return $this->render('licence/edit.html.twig', array(
                    'form' => $form->createView()
                ));


    }

    /**
     * @Route("/licences/details/{id}", name="licences_details")
     */
    public function detailsAction($id)
    {
        $licences = $this->getDoctrine()
            ->getRepository('AppBundle:Licence')
            ->find($id);
        // replace this example code with whatever you need
        return $this->render('licence/details.html.twig', array(
            'licences' => $licences
    ));

    }

    /**
     * @Route("/licences/delete/{id}", name="licences_delete")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $licence = $em->getRepository('AppBundle:Licence')->find($id);

        $em->remove($licence);
        $em->flush();
        $this->addFlash(
            'notice',
            'Votre licence à bien étè supprimé'
        );
        return $this->redirectToRoute('licences_articles');


    }


}
