<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Competencies Model
 *
 * @property \App\Model\Table\ActivitiesTable&\Cake\ORM\Association\BelongsToMany $Activities
 * @property \App\Model\Table\PathwaysTable&\Cake\ORM\Association\BelongsToMany $Pathways
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsToMany $Users
 *
 * @method \App\Model\Entity\Competency get($primaryKey, $options = [])
 * @method \App\Model\Entity\Competency newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Competency[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Competency|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Competency saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Competency patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Competency[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Competency findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CompetenciesTable extends Table
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

        $this->setTable('competencies');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsToMany('Activities', [
            'foreignKey' => 'competency_id',
            'targetForeignKey' => 'activity_id',
            'joinTable' => 'activities_competencies',
        ]);
        $this->belongsToMany('Pathways', [
            'foreignKey' => 'competency_id',
            'targetForeignKey' => 'pathway_id',
            'joinTable' => 'competencies_pathways',
        ]);
        $this->belongsToMany('Users', [
            'foreignKey' => 'competency_id',
            'targetForeignKey' => 'user_id',
            'joinTable' => 'competencies_users',
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
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->scalar('image_path')
            ->maxLength('image_path', 255)
            ->allowEmptyFile('image_path');

        $validator
            ->scalar('color')
            ->maxLength('color', 255)
            ->allowEmptyString('color');

        $validator
            ->scalar('featured')
            ->maxLength('featured', 255)
            ->allowEmptyString('featured');

        $validator
            ->integer('createdby')
            ->requirePresence('createdby', 'create')
            ->notEmptyString('createdby');

        $validator
            ->integer('modifiedby')
            ->requirePresence('modifiedby', 'create')
            ->notEmptyString('modifiedby');

        return $validator;
    }
}
