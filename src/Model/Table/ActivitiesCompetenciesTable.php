<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ActivitiesCompetencies Model
 *
 * @property \App\Model\Table\ActivitiesTable&\Cake\ORM\Association\BelongsTo $Activities
 * @property \App\Model\Table\CompetenciesTable&\Cake\ORM\Association\BelongsTo $Competencies
 *
 * @method \App\Model\Entity\ActivitiesCompetency newEmptyEntity()
 * @method \App\Model\Entity\ActivitiesCompetency newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\ActivitiesCompetency[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ActivitiesCompetency get($primaryKey, $options = [])
 * @method \App\Model\Entity\ActivitiesCompetency findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\ActivitiesCompetency patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ActivitiesCompetency[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ActivitiesCompetency|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ActivitiesCompetency saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ActivitiesCompetency[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ActivitiesCompetency[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\ActivitiesCompetency[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ActivitiesCompetency[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class ActivitiesCompetenciesTable extends Table
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

        $this->setTable('activities_competencies');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Activities', [
            'foreignKey' => 'activity_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Competencies', [
            'foreignKey' => 'competency_id',
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
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

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
        $rules->add($rules->existsIn(['activity_id'], 'Activities'), ['errorField' => 'activity_id']);
        $rules->add($rules->existsIn(['competency_id'], 'Competencies'), ['errorField' => 'competency_id']);

        return $rules;
    }
}
