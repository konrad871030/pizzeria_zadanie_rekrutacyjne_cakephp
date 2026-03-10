<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Order Entity
 *
 * @property int $id
 * @property int $menu_item_id
 * @property int $quantity
 * @property string $email
 * @property string $delivery_address
 * @property string $status
 * @property \Cake\I18n\DateTime $created_at
 * @property \Cake\I18n\DateTime|null $delivered_at
 *
 * @property \App\Model\Entity\MenuItem $menu_item
 */
class Order extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'menu_item_id' => true,
        'quantity' => true,
        'email' => true,
        'delivery_address' => true,
        'status' => true,
        'created_at' => true,
        'delivered_at' => true,
        'menu_item' => true,
    ];
}
