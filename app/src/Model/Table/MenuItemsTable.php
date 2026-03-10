<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MenuItems Model
 *
 * @property \App\Model\Table\OrdersTable&\Cake\ORM\Association\HasMany $Orders
 *
 * @method \App\Model\Entity\MenuItem newEmptyEntity()
 * @method \App\Model\Entity\MenuItem newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\MenuItem> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MenuItem get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\MenuItem findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\MenuItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\MenuItem> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\MenuItem|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\MenuItem saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\MenuItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\MenuItem>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\MenuItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\MenuItem> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\MenuItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\MenuItem>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\MenuItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\MenuItem> deleteManyOrFail(iterable $entities, array $options = [])
 */
class MenuItemsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('menu_items');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('Orders', [
            'foreignKey' => 'menu_item_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('name')
            ->maxLength('name', 120)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->integer('price_cents')
            ->requirePresence('price_cents', 'create')
            ->notEmptyString('price_cents');

        $validator
            ->scalar('ingredients')
            ->maxLength('ingredients', 500)
            ->notEmptyString('ingredients');

        $validator
            ->scalar('image_name')
            ->maxLength('image_name', 255)
            ->notEmptyString('image_name');

        return $validator;
    }
}
