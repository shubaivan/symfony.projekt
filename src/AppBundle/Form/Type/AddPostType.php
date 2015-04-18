<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use AppBundle\Entity\Post;
use AppBundle\Entity\Tag;

class AddPostType extends AbstractType
{
    public $tags;

    public function __construct(array $tags)
    {
        $this->tags = $tags;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $tag = $this->tags;

        $builder
            ->add('title')
            ->add('text')
            ->add('author')
            ->add('thumbnail', 'file')
            ->add('tag', 'entity', [
                'class' => 'AppBundle:Tag',
                'choices' => new GetTagType($tag),
                'multiple' => true
            ]);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Post',
            'intention' => 'appbundle_post',
            'csrf_protection' => true
        ));
    }

    public function getName()
    {
        return 'addPost';
    }
}
