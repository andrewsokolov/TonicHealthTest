<?php

namespace Auth\AuthBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('first_name');
        $builder->add('last_name');
        $builder->remove('username');
    }

    public function getName()
    {
        return 'auth_user_registration';
    }
}