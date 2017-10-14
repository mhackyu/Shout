<?php
/**
 * shout - User.php
 * Author: Mark Christian Paderes
 * Email: markpaderes0932@yahoo.com
 *
 * User: Paderes
 * Date: 8/19/2017
 * Time: 2:54 PM
 */

namespace AppBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ORM\Table(name="users")
 * @UniqueEntity(fields="email", message="Email already taken")
 * @UniqueEntity(fields="username", message="Username already taken")
 */
class User implements UserInterface, \Serializable, AdvancedUserInterface
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=25, unique=true)
     * @Assert\NotBlank()
     * @Assert\Length(min=6, max=20)
     */
    private $username;
    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;
    /**
     * @ORM\Column(type="string", length=60, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $confirmationToken;

    /**
     * @ORM\Column(type="boolean")
     */
    private $enabled;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;
    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     * @Assert\Length(min=6, max=20)
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $role;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     * @Assert\Length(min=3, max=60)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     * @Assert\Length(min=3, max=60)
     */
    private $lastName;

//    /**
//     * @ORM\Column(type="date")
//     * @Assert\Date()
//     */
//    private $dob;

    /**
     * @ORM\Column(type="string", length=6)
     * @Assert\Choice(choices={"male", "female"})
     */
    private $gender;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\File(mimeTypes={"image/png", "image/jpg", "image/jpeg"})
     */
    private $avatar;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $about;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Shout", mappedBy="user")
     */
    private $shout;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Love", mappedBy="user")
     */
    private $love;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Loud", mappedBy="user")
     */
    private $loud;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Advice", mappedBy="user")
     */
    private $advice;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\FoundHelpful", mappedBy="user")
     */
    private $foundHelpful;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\UserReview", mappedBy="user")
     * @ORM\OrderBy({"id" = "DESC"})
     */
    private $userReview;

    public function __construct()
    {
        $this->isActive = true;
        $this->enabled = false;
        $this->shout = new ArrayCollection();
        $this->love = new ArrayCollection();
        $this->loud = new ArrayCollection();
        $this->foundHelpful = new ArrayCollection();
        $this->userReview = new ArrayCollection();
// may not be needed, see section on salt below
// $this->salt = md5(uniqid(null, true));
    }
    public function getUsername()
    {
        return $this->username;
    }
    public function getSalt()
    {
// you *may* need a real salt depending on your encoder
// see section on salt below
        return null;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function getRoles()
    {
//        return $this->role;
        return array($this->role);
    }
    public function setRole($role)
    {
        $this->role = $role;
    }
    public function eraseCredentials()
    {
    }
    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
// see section on salt below
// $this->salt,
        ));
    }
    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
// see section on salt below
// $this->salt
            ) = unserialize($serialized);
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
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * @return mixed
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param mixed $plainPassword
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * @return mixed
     */
    public function getShout()
    {
        return $this->shout;
    }

    /**
     * @param mixed $shout
     */
    public function setShout($shout)
    {
        $this->shout = $shout;
    }

    /**
     * @return mixed
     */
    public function getLove()
    {
        return $this->love;
    }

    /**
     * @param mixed $love
     */
    public function setLove($love)
    {
        $this->love = $love;
    }

    /**
     * @return mixed
     */
    public function getAdvice()
    {
        return $this->advice;
    }

    /**
     * @param mixed $advice
     */
    public function setAdvice($advice)
    {
        $this->advice = $advice;
    }

    /**
     * @return mixed
     */
    public function getLoud()
    {
        return $this->loud;
    }

    /**
     * @param mixed $loud
     */
    public function setLoud($loud)
    {
        $this->loud = $loud;
    }

    /**
     * @return mixed
     */
    public function getFoundHelpful()
    {
        return $this->foundHelpful;
    }

    /**
     * @param mixed $foundHelpful
     */
    public function setFoundHelpful($foundHelpful)
    {
        $this->foundHelpful = $foundHelpful;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

//    /**
//     * @return mixed
//     */
//    public function getDob()
//    {
//        return $this->dob;
//    }
//
//    /**
//     * @param mixed $dob
//     */
//    public function setDob($dob)
//    {
//        $this->dob = $dob;
//    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param mixed $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * @return mixed
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param mixed $avatar
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    }

    /**
     * @return mixed
     */
    public function getAbout()
    {
        return $this->about;
    }

    /**
     * @param mixed $about
     */
    public function setAbout($about)
    {
        $this->about = $about;
    }

    /**
     * @return mixed
     */
    public function getUserReview()
    {
        return $this->userReview;
    }

    /**
     * @param mixed $userReview
     */
    public function setUserReview($userReview)
    {
        $this->userReview = $userReview;
    }

    public function isEnabled()
    {
        // TODO: Implement isEnabled() method.
        return $this->enabled;
    }

    public function isAccountNonExpired()
    {
        // TODO: Implement isAccountNonExpired() method.
        return true;
    }

    public function isAccountNonLocked()
    {
        // TODO: Implement isAccountNonLocked() method.
        return true;
    }

    public function isCredentialsNonExpired()
    {
        // TODO: Implement isCredentialsNonExpired() method.
        return true;
    }

    /**
     * @return mixed
     */
    public function getConfirmationToken()
    {
        return $this->confirmationToken;
    }

    /**
     * @param mixed $confirmationToken
     */
    public function setConfirmationToken($confirmationToken)
    {
        $this->confirmationToken = $confirmationToken;
    }

    /**
     * @param mixed $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }
}
