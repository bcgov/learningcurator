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
 * @property \App\Model\Table\CategoriesTable&\Cake\ORM\Association\BelongsTo $Categories
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\ActivityTypesTable&\Cake\ORM\Association\BelongsTo $ActivityTypes
 * @property \App\Model\Table\CompetenciesTable&\Cake\ORM\Association\BelongsToMany $Competencies
 * @property \App\Model\Table\StepsTable&\Cake\ORM\Association\BelongsToMany $Steps
 * @property \App\Model\Table\TagsTable&\Cake\ORM\Association\BelongsToMany $Tags
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsToMany $Users
 *
 * @method \App\Model\Entity\Activity get($primaryKey, $options = [])
 * @method \App\Model\Entity\Activity newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Activity[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Activity|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Activity saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Activity patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Activity[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Activity findOrCreate($search, callable $callback = null, $options = [])
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
        $this->belongsTo('Categories', [
            'foreignKey' => 'category_id',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'approvedby_id',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'createdby_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'modifiedby_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('ActivityTypes', [
            'foreignKey' => 'activity_types_id',
            'joinType' => 'INNER',
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
        $this->belongsToMany('Users', [
            'foreignKey' => 'activity_id',
            'targetForeignKey' => 'user_id',
            'joinTable' => 'activities_users',
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
        $rules->add($rules->existsIn(['status_id'], 'Statuses'));
        $rules->add($rules->existsIn(['ministry_id'], 'Ministries'));
        $rules->add($rules->existsIn(['category_id'], 'Categories'));
        $rules->add($rules->existsIn(['approvedby_id'], 'Users'));
        $rules->add($rules->existsIn(['createdby_id'], 'Users'));
        $rules->add($rules->existsIn(['modifiedby_id'], 'Users'));
        $rules->add($rules->existsIn(['activity_types_id'], 'ActivityTypes'));

        return $rules;
    }
}
