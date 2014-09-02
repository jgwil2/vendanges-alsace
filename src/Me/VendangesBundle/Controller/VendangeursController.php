<?php

namespace Me\VendangesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

use Me\VendangesBundle\Entity\Vendangeur;
use Me\VendangesBundle\Form\Type\InscriptionVendangeurType;
use Me\VendangesBundle\Form\Type\ModifierVendangeurType;

use Me\VendangesBundle\Form\Type\MotdepasseOublieType;

use Me\VendangesBundle\Entity\Reponse;

use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class VendangeursController extends Controller
{
    // Homepage + forgotten password action
    public function indexAction(Request $request)
    {
        // get current user object
        $vendangeur = $this->get('security.context')->getToken()->getUser();

    	$form = $this->createForm(new InscriptionVendangeurType());

        $motdepasseForm = $this->createForm(new MotdepasseOublieType());

        $motdepasseForm->handleRequest($request);

        if($motdepasseForm->isSubmitted()){

            // fetch all vendangeurs from database
            $repository = $this->getDoctrine()->getRepository('MeVendangesBundle:Vendangeur');

            $vendangeur = $repository->findOneByEmail($motdepasseForm['email']->getData());

            // get random password, hash it, and set hash as new password
            $factory = $this->get('security.encoder_factory');
            $password = substr(md5(uniqid(mt_rand(), true)), 0, 8);
            $encoder = $factory->getEncoder($vendangeur);
            $hash = $encoder->encodePassword($password, $vendangeur->getSalt());
            $vendangeur->setPassword($hash);

            // persist to database
            $em = $this->getDoctrine()->getManager();
            $em->persist($vendangeur);
            $em->flush();

            // send mail with new credentials
            $to      = $vendangeur->getEmail();
            $subject = 'Nouveau mot de passe !';
            $message = "Bonjour,\r\n\r\nVoici votre nouveau mot de passe\r\n\r\n".'mot de passe : '.$password."\r\n\r\n- l'équipe Vendanges Alsace";
            $headers = 'From: contact@vendanges-alsace.com' . "\r\n" .
                'Reply-To: contact@vendanges-alsace.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

            mail($to, $subject, $message, $headers);

            // set notice
            $this->get('session')->getFlashBag()->add(
                'notice',
                'Votre nouveau mot de passe vous a été envoyé !'
                );

            return $this->render('MeVendangesBundle:Vendangeurs:index.html.twig', array(
                'form' => $form->createView(),
                'motdepasseForm' => $motdepasseForm->createView(),
                'vendangeur' => $vendangeur
            ));
        }

        return $this->render('MeVendangesBundle:Vendangeurs:index.html.twig', array(
            'form' => $form->createView(),
            'motdepasseForm' => $motdepasseForm->createView(),
            'vendangeur' => $vendangeur
        ));
    }

    // Sign up action
    public function inscriptionAction(Request $request)
    {
    	$vendangeur = new Vendangeur();

    	$form = $this->createForm(new InscriptionVendangeurType(), $vendangeur);

        $motdepasseForm = $this->createForm(new MotdepasseOublieType());

		$form->handleRequest($request);

		if($form->isSubmitted()){

            $repository = $this->getDoctrine()->getRepository('MeVendangesBundle:Vendangeur');

            if($repository->findOneByEmail($vendangeur->getEmail())){
                // if email is already in database, set message
                $this->get('session')->getFlashBag()->add(
                    'notice',
                    'Vous êtes déjà inscrit !'
                    );

                return $this->render('MeVendangesBundle:Vendangeurs:index.html.twig', array(
                    'vendangeur' => $vendangeur,
                    'motdepasseForm' => $motdepasseForm->createView(),
                    'form' => $form->createView()
                ));
            }

            // get password from form, hash it, and set hash as new password
            $factory = $this->get('security.encoder_factory');
            $password = $vendangeur->getPassword();
            $encoder = $factory->getEncoder($vendangeur);
            $password = $encoder->encodePassword($password, $vendangeur->getSalt());
            $vendangeur->setPassword($password);

			$em = $this->getDoctrine()->getManager();
			$em->persist($vendangeur);
			$em->flush();

            // log in the new user
            $token = new UserNamePasswordToken($vendangeur, null, 'vendangeurs_secured_area', $vendangeur->getRoles());
            $this->get('security.context')->setToken($token);

            // send welcome mail with credentials
            $to      = $vendangeur->getEmail();
            $subject = 'Bienvenue !';
            $message = "Bonjour,\r\n\r\nVoici vos identifiants\r\n\r\n".'email : '.$vendangeur->getEmail()."\r\n".'mot de passe : '.$vendangeur->getPassword()."\r\n\r\n- l'équipe Vendanges Alsace";
            $headers = 'From: contact@vendanges-alsace.com' . "\r\n" .
                'Reply-To: contact@vendanges-alsace.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

            mail($to, $subject, $message, $headers);

            // welcome message
            $this->get('session')->getFlashBag()->add(
                'notice',
                'Merci pour votre inscription ! Vous pouvez maintenant consulter des annonces et y répondre.'
                );

			return $this->render('MeVendangesBundle:Vendangeurs:index.html.twig', array(
                'vendangeur' => $vendangeur,
                'form' => $form->createView()
            ));
		}

		// return form view if no form submission or validation errors
        return $this->render('MeVendangesBundle:Vendangeurs:pageinscription.html.twig', array(
            'form' => $form->createView()
        ));
    }

    // Browse posts action
    public function consulterAction()
    {
        // fetch all annonces from database
        $repository = $this->getDoctrine()->getRepository('MeVendangesBundle:Annonce');

        // custom join defined in AnnonceRepository.php
        $annonces = $repository->findAllJoinedToVigneron();

        // create array with each vigneron city
        $villes = array();
        foreach ($annonces as $annonce) {
            if(!in_array($annonce->getVigneron()->getVille(), $villes)){
                array_push($villes, $annonce->getVigneron()->getVille());
            }
        }

        $motdepasseForm = $this->createForm(new MotdepasseOublieType());

        $form = $this->createForm(new InscriptionVendangeurType());

        // send to view for rendering with registration form and all annonces
        return $this->render('MeVendangesBundle:Vendangeurs:consulter.html.twig', array(
            'form' => $form->createView(),
            'motdepasseForm' => $motdepasseForm->createView(),
            'annonces' => $annonces,
            'villes' => $villes
        ));
    }

    // Browse vineyards action
    public function domainesAction()
    {
        $repository = $this->getDoctrine()->getRepository('MeVendangesBundle:Vigneron');
        $vignerons = $repository->findAll();

        return $this->render('MeVendangesBundle:Vendangeurs:domaines.html.twig', array(
            'vignerons' => $vignerons
        ));
    }

    // Individual vineyard page
    public function pageDomaineAction($id, Request $request)
    {
        $annonceRepository = $this->getDoctrine()->getRepository('MeVendangesBundle:Annonce');
        $annonces = $annonceRepository->findByVigneron($id);

        $vigneronRepository = $this->getDoctrine()->getRepository('MeVendangesBundle:Vigneron');
        $vigneron = $vigneronRepository->findOneById($id);

        return $this->render('MeVendangesBundle:Vendangeurs:pagedomaine.html.twig', array(
            'vigneron' => $vigneron,
            'annonces' =>$annonces
        ));
    }

    // Edit profile action
    public function monProfilAction(Request $request)
    {
        // get current user object
        $vendangeur = $this->get('security.context')->getToken()->getUser();

        // prefill form with current user data
        $form = $this->createForm(new ModifierVendangeurType(), $vendangeur);

        // get repository and fill $profil object with currnet user data
        $repository = $this->getDoctrine()->getRepository('MeVendangesBundle:Vendangeur');
        $profil = $repository->findOneById($vendangeur);

        $form->handleRequest($request);

        if($form->isSubmitted()){

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Modifications enregistrées !'
                );

            $em = $this->getDoctrine()->getManager();

            $em->flush();

            return new RedirectResponse($this->generateUrl('vendanges_vendangeurs_mon_profil'));
        }

        return $this->render('MeVendangesBundle:Vendangeurs:profil.html.twig', array(
            'vendangeur' => $profil,
            'form' => $form->createView()
        ));
    }

    // Reply to post action
    public function repondreAction($id, Request $request)
    {
        // get current user object
        $vendangeur = $this->get('security.context')->getToken()->getUser();

        // get annonce
        $repository = $this->getDoctrine()->getRepository('MeVendangesBundle:Annonce');
        $annonce = $repository->findOneByIdJoinedToVigneron($id);

        if(!$annonce->getActive()){
            return $this->redirect($this->generateUrl('vendanges_vendangeurs_consulter_annonces'));
        }

        $reponse = new Reponse();

        $form = $this->createFormBuilder($reponse)
            ->add('sujet', 'text')
            ->add('message', 'textarea')
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted()){

            // send mail with message
            $to      = $annonce->getVigneron()->getEmail();
            $subject = 'Nouveau message';
            $message = "Bonjour,\r\n\r\nVous avez un nouveau message de la part de ".$vendangeur->getNom()." ".$vendangeur->getPrenom()."\r\n\r\n".'Sujet : '.$reponse->getSujet()."\r\n".'Message : '.$reponse->getMessage()."\r\n\r\nContact :\r\n".$vendangeur->getEmail()."\r\n".$vendangeur->getTel();
            $headers = 'From: contact@vendanges-alsace.com' . "\r\n" .
                'Reply-To: '.$vendangeur()->getEmail(). "\r\n" .
                'X-Mailer: PHP/' . phpversion();

            mail($to, $subject, $message, $headers);

            $reponse->setVendangeur($vendangeur);
            $reponse->setAnnonce($annonce);

            $em = $this->getDoctrine()->getManager();
            $em->persist($reponse);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Votre message a bien été envoyé !'
                );

            return $this->redirect($this->generateUrl('vendanges_vendangeurs_consulter_annonces'));
        }

        return $this->render('MeVendangesBundle:Vendangeurs:repondre.html.twig', array(
            'annonce' => $annonce,
            'form' => $form->createView()
        ));
    }
}
