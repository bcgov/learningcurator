<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Activities Model
 *
 * @property \App\Model\Table\StatusesTable&\Cake\ORM\Association\BelongsTo $Statuses
 * @property \App\Model\Table\MinistriesTable&\Cake\ORM\Association\BelongsTo $Ministries
 * @property \CakeDC\Users\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \CakeDC\Users\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \CakeDC\Users\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\ActivityTypesTable&\Cake\ORM\Association\BelongsTo $ActivityTypes
 * @property \App\Model\Table\ReportsTable&\Cake\ORM\Association\HasMany $Reports
 * @property \App\Model\Table\CompetenciesTable&\Cake\ORM\Association\BelongsToMany $Competencies
 * @property \App\Model\Table\StepsTable&\Cake\ORM\Association\BelongsToMany $Steps
 * @property \App\Model\Table\TagsTable&\Cake\ORM\Association\BelongsToMany $Tags
 * @property \CakeDC\Users\Model\Table\UsersTable&\Cake\ORM\Association\BelongsToMany $Users
 *
 * @method \App\Model\Entity\Activity newEmptyEntity()
 * @method \App\Model\Entity\Activity newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Activity[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Activity get($primaryKey, $options = [])
 * @method \App\Model\Entity\Activity findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Activity patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Activity[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Activity|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Activity saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Activity[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Activity[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Activity[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Activity[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ActivitiesTable extends Table
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

        $this->setTable('activities');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Statuses', [
            'foreignKey' => 'status_id',
        ]);
        $this->belongsTo('Ministries', [
            'foreignKey' => 'ministry_id',
        ]);


        $this->belongsTo('CakeDC/Users.Users', [
            'foreignKey' => 'approvedby_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('CakeDC/Users.Users', [
            'foreignKey' => 'createdby_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('CakeDC/Users.Users', [
            'foreignKey' => 'modifiedby_id',
            'joinType' => 'INNER',
        ]);

        $this->belongsToMany('CakeDC/Users.Users', [
            'foreignKey' => 'activity_id',
            'targetForeignKey' => 'user_id',
            'joinTable' => 'activities_users',
        ]);

        $this->belongsTo('ActivityTypes', [
            'foreignKey' => 'activity_types_id',
            'joinType' => 'INNER',
        ]);

        $this->hasMany('Reports', [
            'foreignKey' => 'activity_id',
        ]);
        $this->belongsToMany('Competencies', [
            'foreignKey' => 'activity_id',
            'targetForeignKey' => 'competency_id',
            'joinTable' => 'activities_competencies',
        ]);
        $this->belongsToMany('Steps', [
            'foreignKey' => 'activity_id',
            'targetForeignKey' => 'step_id',
            'joinTable' => 'activities_steps',
        ]);
        $this->belongsToMany('Tags', [
            'foreignKey' => 'activity_id',
            'targetForeignKey' => 'tag_id',
            'joinTable' => 'activities_tags',
        ]);

        $this->addBehavior('Search.Search');

	    $this->searchManager()
                ->value('name')
                ->value('description')
                ->add('search', 'Search.Like', [ 
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
            ->notEmptyString('name');

        $validator
            ->scalar('hyperlink')
            ->maxLength('hyperlink', 255)
            ->allowEmptyString('hyperlink');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->scalar('licensing')
            ->allowEmptyString('licensing');

        $validator
            ->scalar('moderator_notes')
            ->allowEmptyString('moderator_notes');

        $validator
            ->scalar('isbn')
            ->maxLength('isbn', 100)
            ->allowEmptyString('isbn');

        $validator
            ->scalar('meta_title')
            ->maxLength('meta_title', 255)
            ->allowEmptyString('meta_title');

        $validator
            ->scalar('meta_description')
            ->allowEmptyString('meta_description');

        $validator
            ->integer('featured')
            ->allowEmptyString('featured');

        $validator
            ->integer('moderation_flag')
            ->allowEmptyString('moderation_flag');

        $validator
            ->scalar('file_path')
            ->maxLength('file_path', 255)
            ->allowEmptyFile('file_path');

        $validator
            ->scalar('image_path')
            ->maxLength('image_path', 255)
            ->allowEmptyFile('image_path');

        $validator
            ->integer('hours')
            ->allowEmptyString('hours');

        $validator
            ->integer('recommended')
            ->allowEmptyString('recommended');

        $validator
            ->scalar('estimated_time')
            ->maxLength('estimated_time', 100)
            ->allowEmptyString('estimated_time');

        $validator
            ->scalar('slug')
            ->maxLength('slug', 255)
            ->allowEmptyString('slug');

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
        $rules->add($rules->existsIn(['status_id'], 'Statuses'), ['errorField' => 'status_id']);
        $rules->add($rules->existsIn(['ministry_id'], 'Ministries'), ['errorField' => 'ministry_id']);
        $rules->add($rules->existsIn(['approvedby_id'], 'Users'), ['errorField' => 'approvedby_id']);
        $rules->add($rules->existsIn(['createdby_id'], 'Users'), ['errorField' => 'createdby_id']);
        $rules->add($rules->existsIn(['modifiedby_id'], 'Users'), ['errorField' => 'modifiedby_id']);
        $rules->add($rules->existsIn(['activity_types_id'], 'ActivityTypes'), ['errorField' => 'activity_types_id']);

        return $rules;
    }
}
