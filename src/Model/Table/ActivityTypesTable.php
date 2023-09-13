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
 * @method \App\Model\Entity\ActivityType newEmptyEntity()
 * @method \App\Model\Entity\ActivityType newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\ActivityType[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ActivityType get($primaryKey, $options = [])
 * @method \App\Model\Entity\ActivityType findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\ActivityType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ActivityType[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ActivityType|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ActivityType saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ActivityType[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ActivityType[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\ActivityType[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ActivityType[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
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
            ->scalar('slug')
            ->maxLength('slug', 255)
            ->requirePresence('slug', 'create')
            ->notEmptyString('slug');

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
        // #TODO Investigate re-enabling these validators to 
        // simply not check for UUID validity as 
        // BC Gov GUID doesn't conform to any standard
        // that CakePHP (or internet validators) finds 
        // acceptable. The creation of BC Gov GUID may
        // predate the creation of standards in this 
        // area, but in any case, we have to disable
        // the following for the system to work with 
        // BC Gov GUID as the primary key.
        // $validator
        //     ->uuid('createdby')
        //     ->requirePresence('createdby', 'create')
        //     ->notEmptyString('createdby');

        // $validator
        //     ->uuid('modifiedby')
        //     ->requirePresence('modifiedby', 'create')
        //     ->notEmptyString('modifiedby');

        return $validator;
    }
}
