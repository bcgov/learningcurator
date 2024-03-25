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
 * @property \App\Model\Table\TopicsTable&\Cake\ORM\Association\BelongsTo $Topics
 * @property \App\Model\Table\MinistriesTable&\Cake\ORM\Association\BelongsTo $Ministries
 * @property \App\Model\Table\StatusesTable&\Cake\ORM\Association\BelongsTo $Statuses
 * @property \App\Model\Table\CompetenciesTable&\Cake\ORM\Association\BelongsToMany $Competencies
 * @property \App\Model\Table\StepsTable&\Cake\ORM\Association\BelongsToMany $Steps
 * @property \CakeDC\Users\Model\Table\UsersTable&\Cake\ORM\Association\BelongsToMany $Users
 *
 * @method \App\Model\Entity\Pathway newEmptyEntity()
 * @method \App\Model\Entity\Pathway newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Pathway[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Pathway get($primaryKey, $options = [])
 * @method \App\Model\Entity\Pathway findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Pathway patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Pathway[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Pathway|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Pathway saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Pathway[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Pathway[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Pathway[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Pathway[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
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

        $this->belongsTo('Topics', [
            'foreignKey' => 'topic_id',
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
        $this->belongsToMany('CakeDC/Users.Users', [
            'foreignKey' => 'pathway_id',
            'targetForeignKey' => 'user_id',
            'joinTable' => 'pathways_users',
        ]);
        $this->hasMany('StatsPerpath',['foreignKey' => 'pathways_id',]);

        $this->addBehavior('Search.Search');

	    $this->searchManager()
                ->value('name')
                ->value('description')
                ->add('q', 'Search.Like', [ 
                    'before' => true,
                    'after' => true,
                    'fieldMode' => 'OR',
                    'comparison' => 'LIKE',
                    'wildcardAny' => '*',
                    'wildcardOne' => '?',
                    'fields' => ['name','description'],
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

        $validator
            ->scalar('slug')
            ->maxLength('slug', 255)
            ->allowEmptyString('slug');

        $validator
            ->scalar('estimated_time')
            ->maxLength('estimated_time', 255)
            ->allowEmptyString('estimated_time');
        
        $validator
            ->scalar('keywords')
            ->maxLength('keywords', 500)
            ->allowEmptyString('keywords');

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
        $rules->add($rules->isUnique(['name']), ['errorField' => 'name']);
        $rules->add($rules->existsIn(['topic_id'], 'Topics'), ['errorField' => 'topic_id']);
        $rules->add($rules->existsIn(['ministry_id'], 'Ministries'), ['errorField' => 'ministry_id']);
        $rules->add($rules->existsIn(['status_id'], 'Statuses'), ['errorField' => 'status_id']);

        return $rules;
    }
}
