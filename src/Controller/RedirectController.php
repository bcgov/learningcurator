<?php
declare(strict_types=1);

namespace App\Controller;
Use Cake\ORM\TableRegistry;
use Cake\Utility\Text;

/**
 * Categories Controller
 *
 * @property \App\Model\Table\CategoriesTable $Categories
 * @method \App\Model\Entity\Category[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RedirectController extends AppController
{

    /**
     * Redirect after login method
     * When the learner first visits /login a cookie is created with 
     * the path of where they want to go after they login.
     * After successful SSO login, the learrner is directed here,
     * where we read the cookie and redirect them to their destination.
     *
     * @return \Cake\Http\Response|null|void Redirects to destination
     */
    public function index()
    {
        // #TODO this is maybe insecure? Should probably strip the 
        // domain off and only store the relative path, then hardcode
        // the domain and add the path ... you know?
        if(isset($_COOKIE['RedirectionTo'])) {
            $goto = $_COOKIE['RedirectionTo'] . $_COOKIE['hash'];
            setcookie('RedirectionTo', '', time()-3600);
            unset($_COOKIE['RedirectionTo']);
            setcookie('hash', '', time()-3600);
            unset($_COOKIE['hash']);
            return $this->redirect($goto);
        } else {
            return $this->redirect(['Topics' => 'index']);
        }
    }

}
