<?php
namespace App\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Nucleos\UserBundle\Model\User as BaseUser;
use App\Util\Annotation\TargetService;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity
 * @ORM\Table(name="FOSUser")
 * @ORM\AttributeOverrides({
 *      @ORM\AttributeOverride(name="emailCanonical",
 *          column=@ORM\Column(
 *              name     = "email_canonical",
 *              nullable = true,
 *              unique   = false
 *          )
 *      ),
 *      @ORM\AttributeOverride(name="email",
 *          column=@ORM\Column(
 *              name     = "email",
 *              nullable = true,
 *              unique   = false
 *          )
 *      )
 * })
 * @TargetService(uri="/api/f_o_s_users")
 */
class FOSUser extends BaseUser {
     /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @Groups({"default"})
     */
    protected $email;
}