<?php
/**
 * Class PolityType | AppBundle/Form/PolityType.php
 *
 * @package     AppBundle
 * @author      Eduard Pinuaga <info@did-web.com>
 */
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\Polity;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

/**
 * Formular for Polity
 */
class PolityType extends AbstractType
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
        $builder->add('description');

        $builder->add('dayStart', ChoiceType::class, array(
                      'choices' => range(0, 31),
                      'placeholder' => 'Day'
        ));
        $builder->add('monthStart', ChoiceType::class, array(
                      'choices' => range(0, 12),
                      'placeholder' => 'Month',
        ));
        $builder->add('yearStart');

        $builder->add('dayEnd', ChoiceType::class, array(
                      'choices' => range(0, 31),
                      'placeholder' => 'Day'
        ));
        $builder->add('monthEnd', ChoiceType::class, array(
                      'choices' => range(0, 12),
                      'placeholder' => 'Month',
        ));
        $builder->add('yearEnd');
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
            'data_class' => 'AppBundle\Entity\Polity'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_polity';
    }
}
