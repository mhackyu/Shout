<?php

namespace AppBundle\Twig\Extension;

use AppBundle\Entity\Shout;
use AppBundle\Entity\User;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class LoveExtension
 * This Twig extension handles love reactions inside Twig template.
 * @author Mark Christian Paderes <markpaderes0932@yahoo.com>
 * @package AppBundle\Twig\Extension
 */
class LoveExtension extends \Twig_Extension
{
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'love_extension';
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('isLove', [$this, 'isLoveFilter']),
            new \Twig_SimpleFilter('numOfLove', [$this, 'numOfLoveFilter'])
        ];
    }

    public function isLoveFilter(User $user, Shout $shout)
    {
        $heart = $this->doctrine->getRepository('AppBundle:Love')
            ->findOneBy([
                'user' => $user,
                'shout' => $shout
            ]);

        if ($heart) {
            return true;
        }

        return false;
    }

    public function numOfLoveFilter(Shout $shout)
    {
        $love = $this->doctrine->getRepository('AppBundle:Love')
            ->findBy([
                'shout' => $shout
            ]);

        return count($love);
    }
}
