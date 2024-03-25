<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * StatsPerpath Model
 *
 * @property \App\Model\Table\PathwaysTable&\Cake\ORM\Association\BelongsTo $Pathways
 *
 * @method \App\Model\Entity\StatsPerpath newEmptyEntity()
 * @method \App\Model\Entity\StatsPerpath newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\StatsPerpath[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\StatsPerpath get($primaryKey, $options = [])
 * @method \App\Model\Entity\StatsPerpath findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\StatsPerpath patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\StatsPerpath[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\StatsPerpath|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\StatsPerpath saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\StatsPerpath[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\StatsPerpath[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\StatsPerpath[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\StatsPerpath[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class StatsPerpathTable extends Table
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

        $this->setTable('stats_perpath');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Pathways', [
            'foreignKey' => 'pathways_id',
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
            ->integer('pathways_id')
            ->notEmptyString('pathways_id');

        $validator
            ->integer('steps')
            ->requirePresence('steps', 'create')
            ->notEmptyString('steps');

        $validator
            ->integer('activities')
            ->requirePresence('activities', 'create')
            ->notEmptyString('activities');

        $validator
            ->integer('follows')
            ->requirePresence('follows', 'create')
            ->notEmptyString('follows');

        $validator
            ->integer('launches')
            ->requirePresence('launches', 'create')
            ->notEmptyString('launches');

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
        $rules->add($rules->existsIn('pathways_id', 'Pathways'), ['errorField' => 'pathways_id']);

        return $rules;
    }
}
