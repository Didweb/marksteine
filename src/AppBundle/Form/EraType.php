<?php
/**
 * Class CountryType | AppBundle/Form/CountryType.php
 *
 * @package     AppBundle
 * @author      Eduard Pinuaga <info@did-web.com>
 */
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use AppBundle\Entity\Country;

/**
 * Formular for Country
 */
class EraType extends AbstractType
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
        $builder->add('name');
        $builder->add('start');
        $builder->add('end');
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
            'data_class' => 'AppBundle\Entity\Era'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_era';
    }
}
