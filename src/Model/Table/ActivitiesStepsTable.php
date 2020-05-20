<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ActivitiesSteps Model
 *
 * @property \App\Model\Table\ActivitiesTable&\Cake\ORM\Association\BelongsTo $Activities
 * @property \App\Model\Table\StepsTable&\Cake\ORM\Association\BelongsTo $Steps
 *
 * @method \App\Model\Entity\ActivitiesStep get($primaryKey, $options = [])
 * @method \App\Model\Entity\ActivitiesStep newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ActivitiesStep[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ActivitiesStep|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ActivitiesStep saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ActivitiesStep patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ActivitiesStep[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ActivitiesStep findOrCreate($search, callable $callback = null, $options = [])
 */
class ActivitiesStepsTable extends Table
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

        $this->setTable('activities_steps');
        $this->setDisplayField('activity_id');
        $this->setPrimaryKey(['id']);

        $this->belongsTo('Activities', [
            'foreignKey' => 'activity_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Steps', [
            'foreignKey' => 'step_id',
            'joinType' => 'INNER',
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
            ->integer('required')
            ->allowEmptyString('required');

        $validator
            ->integer('steporder')
            ->allowEmptyString('steporder');

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
        $rules->add($rules->existsIn(['activity_id'], 'Activities'));
        $rules->add($rules->existsIn(['step_id'], 'Steps'));

        return $rules;
    }
}
