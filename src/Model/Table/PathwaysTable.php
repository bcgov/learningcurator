<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Pathways Model
 *
 * @property \App\Model\Table\CategoriesTable&\Cake\ORM\Association\BelongsTo $Categories
 * @property \App\Model\Table\MinistriesTable&\Cake\ORM\Association\BelongsTo $Ministries
 * @property \App\Model\Table\CompetenciesTable&\Cake\ORM\Association\BelongsToMany $Competencies
 * @property \App\Model\Table\StepsTable&\Cake\ORM\Association\BelongsToMany $Steps
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsToMany $Users
 *
 * @method \App\Model\Entity\Pathway get($primaryKey, $options = [])
 * @method \App\Model\Entity\Pathway newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Pathway[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Pathway|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Pathway saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Pathway patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Pathway[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Pathway findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PathwaysTable extends Table
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

        $this->setTable('pathways');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Categories', [
            'foreignKey' => 'category_id',
        ]);
        $this->belongsTo('Ministries', [
            'foreignKey' => 'ministry_id',
        ]);
        $this->belongsTo('Statuses', [
            'foreignKey' => 'status_id',
        ]);
        $this->belongsToMany('Competencies', [
            'foreignKey' => 'pathway_id',
            'targetForeignKey' => 'competency_id',
            'joinTable' => 'competencies_pathways',
        ]);
        $this->belongsToMany('Steps', [
            'foreignKey' => 'pathway_id',
            'targetForeignKey' => 'step_id',
            'joinTable' => 'pathways_steps',
        ]);
        $this->belongsToMany('Topics', [
            'foreignKey' => 'pathway_id',
            'targetForeignKey' => 'topic_id',
            'joinTable' => 'pathways_topics',
        ]);
        $this->belongsToMany('Users', [
            'foreignKey' => 'pathway_id',
            'targetForeignKey' => 'user_id',
            'joinTable' => 'pathways_users',
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
            ->notEmptyString('name')
            ->add('name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('color')
            ->maxLength('color', 255)
            ->allowEmptyString('color');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->scalar('objective')
            ->allowEmptyString('objective');

        $validator
            ->scalar('file_path')
            ->maxLength('file_path', 255)
            ->allowEmptyFile('file_path');

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
        
        $validator
            ->integer('status_id')
            ->requirePresence('status_id', 'create')
            ->notEmptyString('status_id');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['name']));
        $rules->add($rules->existsIn(['category_id'], 'Categories'));
        $rules->add($rules->existsIn(['ministry_id'], 'Ministries'));
        $rules->add($rules->existsIn(['status_id'], 'Statuses'));

        return $rules;
    }
}
