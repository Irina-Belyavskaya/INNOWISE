<?php

namespace controllers;

use core\Controller;
use core\View;
use models\API\User;
class UserController extends Controller
{
    private User $apiModel;

    public function __construct($route) {
       parent::__construct($route);
       $this->apiModel = new User();
    }

    public function indexAction() {
        if (!isset($_GET['source']))
            $this->view->redirect('?source=local');
        $source = 'local';
        $result = [];
        switch ($_GET['source']) {
            case 'gorest':
                $users = $this->apiModel->getUsers();
                if (!$users['success']) {
                    View::error($users);
                }
                $result = $this->pagination(count($users['users']));
                $records = ['success' => $users['success'],'users' => array_slice($users['users'], $result['from'], $result['limit'])];
                $source = 'gorest';
                break;
            case 'local':
                $count = $this->model->getUsersCount();
                if (!$count['success']) {
                    View::error($count);
                }
                $result = $this->pagination($count['count']);
                $records = $this->model->getLimitUsers($result['from'], $result['limit']);
                break;
            default:
                $records = ['success' => false, 'errorCode' => '404','errorText' => 'Not found'];
        }
        if (!$records['success']) {
            View::error($records);
        }
        $checkedId = $this->getCheckedIds();
        $pageInfo = ['title' => 'Database', 'records' => $records['users'], 'count' => $result['count'], 'currentPage' => $result['page'], 'checkedIds' => $checkedId, 'source' => $source];
        $this->view->render($pageInfo);
    }

    public function addAction() {
        $this->view->render(['title' => 'Add user']);
    }

    public function createAction () {
        if (!empty($_POST)) {

            $source = 'local';
            switch ($_GET['source']) {
                case 'gorest':
                    $result = $this->apiModel->addUser($_POST);
                    $source = 'gorest';
                    break;
                case 'local':
                    $result = $this->model->addUser($_POST);
                    break;
                default:
                    $result = ['success' => false,'errorCode' => '422', 'errorText' => 'Unprocessable Entity. This email is already in use.'];
            }
            if (!$result['success'])
                View::error($result);
            $this->view->redirect('/' . $GLOBALS['baseUrl'].'?source='.$source);
        }
    }

    public function changeAction() {
        switch ($_GET['source']) {
            case 'local':
                $result = $this->model->findUser($_GET['id']);
                break;
            case 'gorest':
                $result = $this->apiModel->findUser($_GET['id']);
                break;
            default:
                $result = ['success' => false, 'errorCode' => '404', 'errorText' => 'Not found.'];
        }
        if (!$result['success']) {
            View::error($result);
        }
        $user = $result['user'];
        $userInfo = ['title' => 'Change user information', 'id' => $user['id'], 'name' => $user['name'], 'email' => $user['email'], 'gender' => $user["gender"], 'status' => $user['status'], 'source' => $_GET['source']];
        $this->view->render($userInfo);
    }

    public function updateAction() {
        if (!empty($_POST)) {
            $result = [];
            switch ($_GET['source']) {
                case 'local':
                    $user = $this->model->findUser($_POST['id']);
                    if (!$user['success'])
                        View::error($result);
                    $user = $user['user'];
                    if ($user['email'] !== $_POST['email']) {
                        if (!$this->model->checkUniqEmail($_POST['email'])) {
                            View::error(['errorCode' => '422', 'errorText' => 'Unprocessable Entity. This email is already in use.']);
                        }
                    }
                    $result = $this->model->changeUserInfo($_POST);
                    break;
                case 'gorest':
                    $result = $this->apiModel->changeUserInfo($_POST);
                    break;
            }
            if (!$result['success'])
                View::error($result);
            $this->view->redirect('/' . $GLOBALS['baseUrl'].'?source='.$_GET['source']);
        }
    }

    public function deleteAction() {
        if (isset($_POST['usersIds'])) {
            $ids = explode(",",$_POST['usersIds']);
            foreach ($ids as $id) {
                if ($id !== '')
                    $this->deleteUserById($id);
            }
        }
        if (isset($_GET['id'])) {
            $this->deleteUserById($_GET['id']);
        }
        $this->view->redirect('/' . $GLOBALS['baseUrl'].'?source='.$_GET['source']);
    }

    private function pagination($usersCount) {
        // Get current page
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 1;
        }

        // Get users for current page
        $limit = 4;
        $count = ceil($usersCount / $limit);
        if ($page > $count && $count != 0)
            $page = $count;
        $from = ($page - 1) * $limit;
        return ['from' => $from, 'limit' => $limit, 'count' => $count, 'page' => $page];
    }

    private function deleteUserById($id) {
        switch ($_GET['source']) {
            case 'local':
                if (!$this->model->deleteUser($id)) {
                    View::error(['errorCode' => '404', 'errorText' => 'Can`t find user with id = '.$id]);
                }
                break;
            case 'gorest':
                $result = $this->apiModel->deleteUser($id);
                if (!$result['success'])
                    View::error($result);
                break;
        }
    }

    private function getCheckedIds() {
        return $_POST ? explode(",", $_POST['checkedIds']) : [''];
    }
}