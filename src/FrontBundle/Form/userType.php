<?php

namespace FrontBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;





class userType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom')
            ->add('prenom')
            ->add("username")
            ->add("email")
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array('label' => 'form.password'),
                'second_options' => array('label' => 'form.password_confirmation'),
                'invalid_message' => 'fos_user.password.mismatch',
            ))
            ->add('adresse')
            ->add('cp')
            ->add('ville')
            ->add('dateEmbauche', DateType::class, array('placeholder' => 'cliquez pour selectionné la date','widget' => 'single_text','attr' => ['class' => 'datepicker']))

            ->add('roles', ChoiceType::class, array(
                'choices' => array(
                    'Admin' => 'ROLE_ADMIN',
                    'Utilisateur' => 'ROLE_UTILISATEUR',
                    'Comptable' => 'ROLE_COMPTABLE'
                ),
                'expanded' => true,
                'multiple' => true,
                'required'    => true,
            ))
            ->add("Ajouter", SubmitType::class, array(
                'attr'  => array('class' => 'btn','center-align')));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FrontBundle\Entity\user'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'frontbundle_user';
    }


}
