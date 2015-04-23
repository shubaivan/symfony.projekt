<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 12.12.14
 * Time: 15:56
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Iphp\FileStoreBundle\Mapping\Annotation as FileStore;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PostRepository")
 * @ORM\Table(name="post")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @FileStore\Uploadable
 * @ORM\HasLifecycleCallbacks()
 */
class Post
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    protected $title;

    /**
     * @ORM\Column(type="text")
     */
    protected $text;

    /**
     * @ORM\Column(type="string", length=200)
     */
    protected $author;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", name="createdAt")
     */
    protected $createdAt;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=true, name="updatedAt")
     */
    protected $updatedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true, name="deletedAt")
     */
    protected $deletedAt;

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(type="string", length=128, unique=true)
     */
    protected $slugPost;

    /**
     * @ORM\OneToMany(targetEntity="Issue", mappedBy="post", orphanRemoval=true)
     */
    protected $issue;

    /**
     * @ORM\ManyToMany(targetEntity="Tag", mappedBy="post")
     * @ORM\JoinTable(name="posts_tag")
     */
    protected $tag;

    /**
     * @ORM\Column(name="photo", type="array")
     * @Assert\File( maxSize="20M")
     * @FileStore\UploadableField(mapping="photo")
     */
    private $photo;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->issue = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tag = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param  string $title
     * @return Post
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set text
     *
     * @param  string $text
     * @return Post
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set author
     *
     * @param  string $author
     * @return Post
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set createdAt
     *
     * @param  \DateTime $createdAt
     * @return Post
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param  \DateTime $updatedAt
     * @return Post
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set deletedAt
     *
     * @param  \DateTime $deletedAt
     * @return Post
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return \DateTime
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * Set slugPost
     *
     * @param  string $slugPost
     * @return Post
     */
    public function setSlugPost($slugPost)
    {
        $this->slugPost = $slugPost;

        return $this;
    }

    /**
     * Get slugPost
     *
     * @return string
     */
    public function getSlugPost()
    {
        return $this->slugPost;
    }

    /**
     * Add issue
     *
     * @param  \AppBundle\Entity\Issue $issue
     * @return Post
     */
    public function addIssue(\AppBundle\Entity\Issue $issue)
    {
        $this->issue[] = $issue;

        return $this;
    }

    /**
     * Remove issue
     *
     * @param \AppBundle\Entity\Issue $issue
     */
    public function removeIssue(\AppBundle\Entity\Issue $issue)
    {
        $this->issue->removeElement($issue);
    }

    /**
     * Get issue
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIssue()
    {
        return $this->issue;
    }

    /**
     * Add tag
     *
     * @param  \AppBundle\Entity\Tag $tag
     * @return Post
     */
    public function addTag(\AppBundle\Entity\Tag $tag)
    {
        $this->tag[] = $tag;

        return $this;
    }

    /**
     * Remove tag
     *
     * @param \AppBundle\Entity\Tag $tag
     */
    public function removeTag(\AppBundle\Entity\Tag $tag)
    {
        $this->tag->removeElement($tag);
    }

    /**
     * Get tag
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Set photo
     *
     * @param  array $photo
     * @return Post
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return array
     */
    public function getPhoto()
    {
        return $this->photo;
    }
}
