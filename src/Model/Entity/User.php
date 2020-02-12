<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Authentication\PasswordHasher\DefaultPasswordHasher;
use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int $id
 * @property string $name
 * @property string $idir
 * @property int $ministry_id
 * @property int $role_id
 * @property string|null $image_path
 * @property string $email
 * @property string $password
 *
 * @property \App\Model\Entity\Ministry $ministry
 * @property \App\Model\Entity\Role $role
 * @property \App\Model\Entity\Activity[] $activities
 * @property \App\Model\Entity\Competency[] $competencies
 * @property \App\Model\Entity\Pathway[] $pathways
 */
class User extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'name' => true,
        'idir' => true,
        'ministry_id' => true,
        'role_id' => true,
        'image_path' => true,
        'email' => true,
        'password' => true,
        'ministry' => true,
        'role' => true,
        'activities' => true,
        'competencies' => true,
        'pathways' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password',
    ];
    
    protected function _setPassword(string $password) : ?string
    {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher())->hash($password);
        }
    }


}
