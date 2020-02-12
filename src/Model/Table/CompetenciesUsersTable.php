<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CompetenciesUsers Model
 *
 * @property \App\Model\Table\CompetenciesTable&\Cake\ORM\Association\BelongsTo $Competencies
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\CompetenciesUser get($primaryKey, $options = [])
 * @method \App\Model\Entity\CompetenciesUser newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CompetenciesUser[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CompetenciesUser|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CompetenciesUser saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CompetenciesUser patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CompetenciesUser[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CompetenciesUser findOrCreate($search, callable $callback = null, $options = [])
 */
class CompetenciesUsersTable extends Table
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

        $this->setTable('competencies_users');
        $this->setDisplayField('competency_id');
        $this->setPrimaryKey(['competency_id', 'user_id']);

        $this->belongsTo('Competencies', [
            'foreignKey' => 'competency_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
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
            ->scalar('priority')
            ->maxLength('priority', 255)
            ->allowEmptyString('priority');

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
        $rules->add($rules->existsIn(['competency_id'], 'Competencies'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
