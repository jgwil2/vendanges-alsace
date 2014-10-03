<?php

namespace Me\VendangesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

use Me\VendangesBundle\Entity\Vigneron;
use Me\VendangesBundle\Form\Type\InscriptionVigneronType;
use Me\VendangesBundle\Form\Type\ModifierVigneronType;

use Me\VendangesBundle\Entity\Annonce;
use Me\VendangesBundle\Form\Type\AnnonceType;
use Me\VendangesBundle\Form\Type\ModifierAnnonceType;

use Me\VendangesBundle\Form\Type\MotdepasseOublieType;

use Me\VendangesBundle\Entity\ReponseAuVendangeur;

use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class VigneronsController extends Controller
{
    // homepage + password forgotten action
    public function indexAction(Request $request)
    {
        $form = $this->createForm(new InscriptionVigneronType());

        $motdepasseForm = $this->createForm(new MotdepasseOublieType());

        $motdepasseForm->handleRequest($request);

        if($motdepasseForm->isSubmitted()){

            // fetch all vignerons from database
            $repository = $this->getDoctrine()->getRepository('MeVendangesBundle:Vigneron');

            $vigneron = $repository->findOneByEmail($motdepasseForm['email']->getData());

            // get random password, hash it, and set hash as new password
            $factory = $this->get('security.encoder_factory');
            $password = substr(md5(uniqid(mt_rand(), true)), 0, 8);
            $encoder = $factory->getEncoder($vigneron);
            $hash = $encoder->encodePassword($password, $vigneron->getSalt());
            $vigneron->setPassword($hash);

            // persist to database
            $em = $this->getDoctrine()->getManager();
            $em->persist($vigneron);
            $em->flush();

            // send mail with new credentials
            $to      = $vigneron->getEmail();
            $subject = 'Nouveau mot de passe';
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

            return $this->render('MeVendangesBundle:Vignerons:index.html.twig', array(
                'form' => $form->createView(),
                'motdepasseForm' => $motdepasseForm->createView()
            ));
        }

        return $this->render('MeVendangesBundle:Vignerons:index.html.twig', array(
        	'form' => $form->createView(),
            'motdepasseForm' => $motdepasseForm->createView()
        ));
    }

    // Sign up action
    public function inscriptionAction(Request $request)
    {
    	$vigneron = new Vigneron();

    	$form = $this->createForm(new InscriptionVigneronType(), $vigneron);

        $motdepasseForm = $this->createForm(new MotdepasseOublieType());

		$form->handleRequest($request);

		if($form->isValid()){

            $repository = $this->getDoctrine()->getRepository('MeVendangesBundle:Vigneron');

            if($repository->findOneByEmail($vigneron->getEmail())){
                // if email is already in database, set message
                $this->get('session')->getFlashBag()->add(
                    'notice',
                    'Vous êtes déjà inscrit !'
                    );

                return $this->render('MeVendangesBundle:Vignerons:index.html.twig', array(
                    'motdepasseForm' => $motdepasseForm->createView(),
                    'form' => $form->createView()
                ));
            }

            // get password from form, hash it, and set hash as new password
            $factory = $this->get('security.encoder_factory');
            $password = $vigneron->getPassword();
            $encoder = $factory->getEncoder($vigneron);
            $password = $encoder->encodePassword($password, $vigneron->getSalt());
            $vigneron->setPassword($password);

			$em = $this->getDoctrine()->getManager();

			$em->persist($vigneron);
			$em->flush();

            // log in the new user
            $token = new UserNamePasswordToken($vigneron, null, 'vignerons_secured_area', $vigneron->getRoles());
            $this->get('security.context')->setToken($token);

            // send welcome mail with credentials
            $to      = $vigneron->getEmail();
            $subject = 'Bienvenue !';
            $message = "Bonjour,\r\n\r\nVoici vos identifiants\r\n\r\n".'email : '.$vigneron->getEmail()."\r\n".'mot de passe : '.$vigneron->getPassword()."\r\n\r\n- l'équipe Vendanges Alsace";
            $headers = 'From: contact@vendanges-alsace.com' . "\r\n" .
                'Reply-To: contact@vendanges-alsace.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

            mail($to, $subject, $message, $headers);

            // welcome message
            $this->get('session')->getFlashBag()->add(
                'notice',
                'Merci pour votre inscription ! Vous pouvez maintenant passer des annonces.'
                );

			return $this->render('MeVendangesBundle:Vignerons:index.html.twig', array(
                'vigneron' => $vigneron,
                'form' => $form->createView(),
                'motdepasseForm' => $motdepasseForm->createView(),
            ));
		}

    	// return form view if no form submission or validation errors
        return $this->render('MeVendangesBundle:Vignerons:pageinscription.html.twig', array(
            'form' => $form->createView()
        ));

    }

    // New post action
    public function nouvelleAnnonceAction(Request $request)
    {

        $annonce = new Annonce();

        // get current user object
        $vigneron = $this->get('security.context')->getToken()->getUser();

        $form = $this->createForm(new AnnonceType(), $annonce);

        // get all annonces associated with current user
        $repository = $this->getDoctrine()->getRepository('MeVendangesBundle:Annonce');
        $annonces = $repository->findAllByVigneron($vigneron->getId());

        $form->handleRequest($request);

        if($form->isSubmitted()){

            $em = $this->getDoctrine()->getManager();

            // set vigneron of current annonce to current user object
            $annonce->setVigneron($vigneron);

            $em->persist($annonce);
            $em->flush();

            return $this->redirect($this->generateUrl('vendanges_vignerons'));
        }

        return $this->render('MeVendangesBundle:Vignerons:annonce.html.twig', array(
            'form' => $form->createView(),
            'annonces' => $annonces
        ));
    }

    // Modify post action
    public function modifierAnnonceAction($id, Request $request)
    {
        // get current user object
        $vigneron = $this->get('security.context')->getToken()->getUser();

        $repository = $this->getDoctrine()->getRepository('MeVendangesBundle:Annonce');
        $annonce = $repository->findOneById($id);

        // if this annonce is not associated with current user, redirect to list
        if($vigneron != $annonce->getVigneron()){
            return $this->redirect($this->generateUrl('vendanges_vignerons_nouvelle_annonce'));
        }

        $form = $this->createForm(new ModifierAnnonceType(), $annonce);

        $form->handleRequest($request);

        if($form->isSubmitted()){

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Modifications enregistrées !'
                );

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirect($this->generateUrl(
                'vendanges_vignerons_modifier_annonce',
                array('id' => $id)
            ));
        }

        return $this->render('MeVendangesBundle:Vignerons:modifier.html.twig', array(
            'annonce' => $annonce,
            'form' => $form->createView()
        ));
    }

    // Browse potential workers action
    public function consulterAction()
    {
        // fetch all vendangeurs from database
        $repository = $this->getDoctrine()->getRepository('MeVendangesBundle:Vendangeur');
        $vendangeurs = $repository->findAll();

        $reponse = new ReponseAuVendangeur();

        $form = $this->createFormBuilder($reponse)
            ->add('sujet', 'text')
            ->add('message', 'textarea')
            ->getForm();

        return $this->render('MeVendangesBundle:Vignerons:consulter.html.twig', array(
            'vendangeurs' => $vendangeurs,
            'form' => $form->createView()
        ));
    }

    // Send message to a user action
    public function repondreAction($id, Request $request)
    {
        // get current user object
        $vigneron = $this->get('security.context')->getToken()->getUser();

        // get vendangeur
        $repository = $this->getDoctrine()->getRepository('MeVendangesBundle:Vendangeur');
        $vendangeur = $repository->findOneById($id);

        if(!$vendangeur->getDisponible()){
            return $this->redirect($this->generateUrl('vendanges_vignerons_consulter_profils'));
        }

        $reponse = new ReponseAuVendangeur();

        $form = $this->createFormBuilder($reponse)
            ->add('sujet', 'text')
            ->add('message', 'textarea')
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted()){

            // send mail with message
            $to      = $vendangeur->getEmail();
            $subject = 'Nouveau message';
            $message = "Bonjour,\r\n\r\nVous avez un nouveau message de la part de ".$vigneron->getNom()." ".$vendangeur->getPrenom()."\r\n\r\n".'Sujet : '.$reponse->getSujet()."\r\n".'Message : '.$reponse->getMessage()."\r\n\r\nContact :\r\n".$vigneron->getEmail();
            $headers = 'From: contact@vendanges-alsace.com' . "\r\n" .
                'Reply-To: '.$vigneron->getEmail(). "\r\n" .
                'X-Mailer: PHP/' . phpversion();

            mail($to, $subject, $message, $headers);

            $reponse->setVendangeurId($vendangeur);
            $reponse->setVigneronId($vigneron);

            $em = $this->getDoctrine()->getManager();
            $em->persist($reponse);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Votre message a bien été envoyé !'
                );

            return $this->redirect($this->generateUrl('vendanges_vignerons_consulter_profils'));

        }

        return $this->render('MeVendangesBundle:Vignerons:repondre.html.twig', array(
            'vendangeur' => $vendangeur,
            'form' => $form->createView()
        ));
    }

    // Edit profile action
    public function monProfilAction(Request $request)
    {
        // get current user object
        $vigneron = $this->get('security.context')->getToken()->getUser();

        // prefill form with current user data
        $form = $this->createForm(new ModifierVigneronType(), $vigneron);

        // get repository and fill $profil object with currnet user data
        $repository = $this->getDoctrine()->getRepository('MeVendangesBundle:Vigneron');
        $profil = $repository->findOneById($vigneron);

        $form->handleRequest($request);

        if($form->isSubmitted()){

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Modifications enregistrées !'
                );

            $em = $this->getDoctrine()->getManager();

            $em->flush();

            return new RedirectResponse($this->generateUrl('vendanges_vignerons_mon_profil'));
        }

        return $this->render('MeVendangesBundle:Vignerons:profil.html.twig', array(
            'vigneron' => $profil,
            'form' => $form->createView()
        ));
    }

    // Browse my posts action
    public function mesAnnoncesAction()
    {
        // get current user object
        $vigneron = $this->get('security.context')->getToken()->getUser();

        // get all annonces associated with current user
        $repository = $this->getDoctrine()->getRepository('MeVendangesBundle:Annonce');
        $annonces = $repository->findAllByVigneron($vigneron->getId());

        return $this->render('MeVendangesBundle:Vignerons:gererannonces.html.twig', array(
            'annonces' => $annonces
        ));
    }
}
