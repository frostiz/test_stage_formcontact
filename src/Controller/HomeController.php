<?php

namespace App\Controller;

use App\Entity\Department;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContactType;

class HomeController extends AbstractController
{
    private function sendMail($data, $mailer)
    {
        $to = $data['to']->getUsers()->getValues();
        $to = array_map(function(User $user) { return $user->getEmail(); }, $to);
        $message = (new \Swift_Message($data['subject'] ?? 'Default email subject'))
            ->setFrom(array('mailertestthib@gmail.com' => $data['from']))
            ->setTo($to)
            ->setBody($data['body'] ?? 'Default email body');
        $mailer->send($message);
    }

    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, \Swift_Mailer $mailer)
    {
        $contact_form = $this->createForm(ContactType::class, null, [
            'action' => $this->generateUrl('home')
        ]);
        $contact_form->handleRequest($request);

        if ($contact_form->isSubmitted() && $contact_form->isValid()) {
            $data = $contact_form->getData();
            $this->sendMail($data, $mailer);
        }
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'contact_form' => $contact_form->createView()
        ]);
    }
}
