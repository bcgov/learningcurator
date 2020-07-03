<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PathwaysTopics Model
 *
 * @property \App\Model\Table\PathwaysTable&\Cake\ORM\Association\BelongsTo $Pathways
 * @property \App\Model\Table\TopicsTable&\Cake\ORM\Association\BelongsTo $Topics
 *
 * @method \App\Model\Entity\PathwaysTopic get($primaryKey, $options = [])
 * @method \App\Model\Entity\PathwaysTopic newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PathwaysTopic[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PathwaysTopic|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PathwaysTopic saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PathwaysTopic patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PathwaysTopic[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PathwaysTopic findOrCreate($search, callable $callback = null, $options = [])
 */
class PathwaysTopicsTable extends Table
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

        $this->setTable('pathways_topics');
        $this->setDisplayField('pathway_id');
        $this->setPrimaryKey(['pathway_id', 'topic_id']);

        $this->belongsTo('Pathways', [
            'foreignKey' => 'pathway_id',
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
        $rules->add($rules->existsIn(['pathway_id'], 'Pathways'));
        $rules->add($rules->existsIn(['topic_id'], 'Topics'));

        return $rules;
    }
}
