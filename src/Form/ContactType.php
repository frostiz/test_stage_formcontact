<?php

namespace App\Form;

use App\Entity\Department;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Expr\Array_;
use function PHPSTORM_META\type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\Loader\CallbackChoiceLoader;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    private function getChoices()
    {
        $choices = $this->entityManager->getRepository(Department::class)->findAll();
        return $choices;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $choices = $this->getChoices();
        $builder
            ->add('from', TextType::class, [
                'label' => 'From:',
                'attr' => ['placeholder' => 'Enter your name']
            ])
            ->add('to', ChoiceType::class, [
                'choices' => $choices,
                'choice_value' => function(Department $entity = null) {
                    return $entity ? $entity->getId() : '';
                },
                'choice_label' => function(Department $entity = null) {
                    return $entity ? $entity->getName() : '';
                },
                'label' => 'To department:'
            ])
            ->add('subject', TextType::class, [
                'label' => 'Email subject:',
                'attr' => ['placeholder' => 'Enter the email subject']
            ])
            ->add('body', TextareaType::class, [
                'label' => 'Email body:',
                'attr' => ['placeholder' => 'Enter the email body']
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Send email'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options her
        ]);
    }
}
