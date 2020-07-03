<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CategoriesTopics Model
 *
 * @property \App\Model\Table\CategoriesTable&\Cake\ORM\Association\BelongsTo $Categories
 * @property \App\Model\Table\TopicsTable&\Cake\ORM\Association\BelongsTo $Topics
 *
 * @method \App\Model\Entity\CategoriesTopic get($primaryKey, $options = [])
 * @method \App\Model\Entity\CategoriesTopic newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CategoriesTopic[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CategoriesTopic|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CategoriesTopic saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CategoriesTopic patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CategoriesTopic[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CategoriesTopic findOrCreate($search, callable $callback = null, $options = [])
 */
class CategoriesTopicsTable extends Table
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

        $this->setTable('categories_topics');
        $this->setDisplayField('category_id');
        $this->setPrimaryKey(['category_id', 'topic_id']);

        $this->belongsTo('Categories', [
            'foreignKey' => 'category_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Topics', [
            'foreignKey' => 'topic_id',
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
        $rules->add($rules->existsIn(['category_id'], 'Categories'));
        $rules->add($rules->existsIn(['topic_id'], 'Topics'));

        return $rules;
    }
}
