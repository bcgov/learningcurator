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
 * @method \App\Model\Entity\ActivitiesCompetency get($primaryKey, $options = [])
 * @method \App\Model\Entity\ActivitiesCompetency newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ActivitiesCompetency[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ActivitiesCompetency|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ActivitiesCompetency saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ActivitiesCompetency patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ActivitiesCompetency[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ActivitiesCompetency findOrCreate($search, callable $callback = null, $options = [])
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
        $this->setDisplayField('activity_id');
        $this->setPrimaryKey(['activity_id', 'competency_id']);

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
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['activity_id'], 'Activities'));
        $rules->add($rules->existsIn(['competency_id'], 'Competencies'));

        return $rules;
    }
}
