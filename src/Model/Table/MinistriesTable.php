<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Ministries Model
 *
 * @property \App\Model\Table\ActivitiesTable&\Cake\ORM\Association\HasMany $Activities
 * @property \App\Model\Table\PathwaysTable&\Cake\ORM\Association\HasMany $Pathways
 *
 * @method \App\Model\Entity\Ministry newEmptyEntity()
 * @method \App\Model\Entity\Ministry newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Ministry[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Ministry get($primaryKey, $options = [])
 * @method \App\Model\Entity\Ministry findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Ministry patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Ministry[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Ministry|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Ministry saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Ministry[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Ministry[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Ministry[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Ministry[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class MinistriesTable extends Table
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

        $this->setTable('ministries');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('Activities', [
            'foreignKey' => 'ministry_id',
        ]);
        $this->hasMany('Pathways', [
            'foreignKey' => 'ministry_id',
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
            ->scalar('elm_learner_group')
            ->maxLength('elm_learner_group', 255)
            ->requirePresence('elm_learner_group', 'create')
            ->notEmptyString('elm_learner_group');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->scalar('hyperlink')
            ->maxLength('hyperlink', 255)
            ->allowEmptyString('hyperlink');

        $validator
            ->scalar('image_path')
            ->maxLength('image_path', 255)
            ->allowEmptyFile('image_path');

        $validator
            ->scalar('color')
            ->maxLength('color', 255)
            ->allowEmptyString('color');

        $validator
            ->integer('featured')
            ->allowEmptyString('featured');

        return $validator;
    }
}
