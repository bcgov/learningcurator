<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * PathwaysSteps Controller
 *
 * @property \App\Model\Table\PathwaysStepsTable $PathwaysSteps
 * @method \App\Model\Entity\PathwaysStep[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PathwaysStepsController extends AppController
{
    /**
     * Reorder steps along a pathway
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function reorder ()
    {

        $count = 0;
        foreach($this->request->getData()['steps'] as $s) {
            $order = $this->request->getData()['steporder'][$count];
            $count++;
            $pathStep = $this->PathwaysSteps->get($s);
            $new['sortorder'] = $order;
            $pathwaysStep = $this->PathwaysSteps->patchEntity($pathStep, $new);
            if (!$this->PathwaysSteps->save($pathwaysStep)) {
                echo 'Something went wrong! Sorry!';
                exit;
            }
        }
        return $this->redirect($this->referer());
        
    }
}
