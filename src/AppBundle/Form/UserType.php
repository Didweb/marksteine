<?php
/**
 * Class UserType | AppBundle/Form/UserType.php
 *
 * @package     AppBundle
 * @author      Eduard Pinuaga <info@did-web.com>
 */
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

/**
 * Formular for Team
 */
class UserType extends AbstractType
{
    /**
     * BuildFormular
     * {@inheritdoc}
     *
     * @param FormBuilderInterface   $builder Service FormBuilderInterface
     * @param string[]               $options List Options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstName');
        $builder->add('lastName');
        $builder->add('gender', ChoiceType::class, array(
                                            'label'    => 'Gender',
                                            'choices'  => array(
                                                              'Male' => 'm',
                                                              'famele' => 'f',
                                                              'Neutre' => 'n'
                                                              ),
                                                              ));
        $builder->add('brithdate', BirthdayType::class, array(
              'placeholder' => array(
                  'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
              )
          ));

        $builder->add('country', CountryType::class, array(
                                            'label'    => 'Country'));
        $builder ->add('file', FileType::class, array(
                                                    "label" => "Avatar",
                                                    "attr" =>array("class" => "form-control")
                                                ));
    }

    /**
     * Config options.
     * {@inheritdoc}
     *
     * @param OptionsResolver   $resolver Service OptionsResolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_user';
    }

}
