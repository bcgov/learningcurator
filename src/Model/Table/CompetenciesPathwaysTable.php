<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CompetenciesPathways Model
 *
 * @property \App\Model\Table\CompetenciesTable&\Cake\ORM\Association\BelongsTo $Competencies
 * @property \App\Model\Table\PathwaysTable&\Cake\ORM\Association\BelongsTo $Pathways
 *
 * @method \App\Model\Entity\CompetenciesPathway get($primaryKey, $options = [])
 * @method \App\Model\Entity\CompetenciesPathway newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CompetenciesPathway[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CompetenciesPathway|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CompetenciesPathway saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CompetenciesPathway patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CompetenciesPathway[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CompetenciesPathway findOrCreate($search, callable $callback = null, $options = [])
 */
class CompetenciesPathwaysTable extends Table
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

        $this->setTable('competencies_pathways');
        $this->setDisplayField('competency_id');
        $this->setPrimaryKey(['competency_id', 'pathway_id']);

        $this->belongsTo('Competencies', [
            'foreignKey' => 'competency_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Pathways', [
            'foreignKey' => 'pathway_id',
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
        $rules->add($rules->existsIn(['competency_id'], 'Competencies'));
        $rules->add($rules->existsIn(['pathway_id'], 'Pathways'));

        return $rules;
    }
}
