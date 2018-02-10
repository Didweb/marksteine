<?php
/**
 * Class TyMilestoneType | AppBundle/Form/TyMilestoneType.php
 *
 * @package     AppBundle
 * @author      Eduard Pinuaga <info@did-web.com>
 */
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use AppBundle\Entity\Type;

/**
 * Formular for Type
 */
class TyMilestoneType extends AbstractType
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
        $builder->add('name', TextType::class, array('required'=> true));
        $builder->add('color', TextType::class, array('required'=> true));
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
            'data_class' => 'AppBundle\Entity\Type'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_type';
    }
}
