<?php
namespace App\Entity\TOTD;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\User\User;
use App\Entity\Core\PKNGEntity;
use App\Util\Annotation\TargetService;
use Symfony\Component\Serializer\Annotation\Groups;