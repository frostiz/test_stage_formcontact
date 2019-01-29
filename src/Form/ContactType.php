<?php

namespace App\Form;

use App\Entity\Department;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use PhpParser\Node\Expr\Array_;
use function PHPSTORM_META\type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('from', TextType::class, [
                'label' => 'From:',
                'attr' => ['placeholder' => 'Enter your name']
            ])
            ->add('department', EntityType::class, [
                'class' => Department::class,
                'label' => 'Department: ',
                'choice_label' => function($category) {
                    return $category->getName();
                }
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
