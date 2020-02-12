<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ActivityTypes Model
 *
 * @method \App\Model\Entity\ActivityType get($primaryKey, $options = [])
 * @method \App\Model\Entity\ActivityType newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ActivityType[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ActivityType|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ActivityType saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ActivityType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ActivityType[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ActivityType findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ActivityTypesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('activity_types');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->scalar('color')
            ->maxLength('color', 255)
            ->allowEmptyString('color');

        $validator
            ->scalar('delivery_method')
            ->maxLength('delivery_method', 255)
            ->allowEmptyString('delivery_method');

        $validator
            ->scalar('image_path')
            ->maxLength('image_path', 255)
            ->allowEmptyFile('image_path');

        $validator
            ->integer('featured')
            ->allowEmptyString('featured');

        $validator
            ->integer('createdby')
            ->requirePresence('createdby', 'create')
            ->notEmptyString('createdby');

        $validator
            ->integer('modifiedby')
            ->requirePresence('modifiedby', 'create')
            ->notEmptyString('modifiedby');

        return $validator;
    }
}
