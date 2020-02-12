<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PathwaysSteps Model
 *
 * @property \App\Model\Table\StepsTable&\Cake\ORM\Association\BelongsTo $Steps
 * @property \App\Model\Table\PathwaysTable&\Cake\ORM\Association\BelongsTo $Pathways
 *
 * @method \App\Model\Entity\PathwaysStep get($primaryKey, $options = [])
 * @method \App\Model\Entity\PathwaysStep newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PathwaysStep[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PathwaysStep|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PathwaysStep saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PathwaysStep patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PathwaysStep[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PathwaysStep findOrCreate($search, callable $callback = null, $options = [])
 */
class PathwaysStepsTable extends Table
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

        $this->setTable('pathways_steps');
        $this->setDisplayField('step_id');
        $this->setPrimaryKey(['step_id', 'pathway_id']);

        $this->belongsTo('Steps', [
            'foreignKey' => 'step_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Pathways', [
            'foreignKey' => 'pathway_id',
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
            ->dateTime('date_start')
            ->allowEmptyDateTime('date_start');

        $validator
            ->dateTime('date_complete')
            ->allowEmptyDateTime('date_complete');

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
        $rules->add($rules->existsIn(['step_id'], 'Steps'));
        $rules->add($rules->existsIn(['pathway_id'], 'Pathways'));

        return $rules;
    }
}
