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
        $records = [];
        switch ($_GET['source']) {
            case 'gorest':
                $users = $this->apiModel->getUsers();
                if (!isset($users['errorCode'])) {
                    $result = $this->pagination(count($users));
                    $records = array_slice($users, $result['from'], $result['limit']);
                    $source = 'gorest';
                } else {
                    View::error($users);
                }
                break;
            case 'local':
                $count = $this->model->getUsersCount();
                if (!isset($count['errorCode'])) {
                    $result = $this->pagination($count);
                    $records = $this->model->getLimitUsers($result['from'], $result['limit']);
                } else {
                    View::error($count);
                }
                break;
        }
        if (!isset($records['errorCode'])) {
            $checkedId = $this->getCheckedIds();
            $pageInfo = ['title' => 'Database', 'records' => $records, 'count' => $result['count'], 'currentPage' => $result['page'], 'checkedIds' => $checkedId, 'source' => $source];
            $this->view->render($pageInfo);
        } else {
            View::error($records);
        }
    }

    public function addAction() {
        $this->view->render(['title' => 'Add user']);
    }

    public function createAction () {
        if (!empty($_POST)) {
            $error = [];
            $source = 'local';
            switch ($_GET['source']) {
                case 'gorest':
                    $error = $this->apiModel->addUser($_POST['name'], $_POST['email'], $_POST['gender'], $_POST['status']);
                    $source = 'gorest';
                    break;
                case 'local':
                    $error = $this->model->addUser($_POST['name'], $_POST['email'], $_POST['gender'], $_POST['status']);
                    break;
            }
            if ($error)
                View::error($error);
            else
                $this->view->redirect('/' . $GLOBALS['baseUrl'].'?source='.$source);
        }
    }

    public function changeAction() {
        $user = [];
        switch ($_GET['source']) {
            case 'local':
                $user = $this->model->findUser($_GET['id']);
                break;
            case 'gorest':
                $user = $this->apiModel->findUser($_GET['id']);
        }
        if (!isset($user['errorCode'])) {
            $userInfo = ['title' => 'Change user information', 'id' => $user['id'], 'name' => $user['name'], 'email' => $user['email'], 'gender' => $user["gender"], 'status' => $user['status'], 'source' => $_GET['source']];
            $this->view->render($userInfo);
        } else {
            View::error($user);
        }
    }

    public function updateAction() {
        if (!empty($_POST)) {
            $error = [];
            switch ($_GET['source']) {
                case 'local':
                    $user = $this->model->findUser($_POST['id']);
                    if ($user['email'] !== $_POST['email']) {
                        if (!$this->model->checkUniqEmail($_POST['email'])) {
                            View::error(['errorCode' => '422', 'errorText' => 'Unprocessable Entity. This email is already in use.']);
                        }
                    }
                    $error = $this->model->changeUserInfo($_POST['name'], $_POST['email'], $_POST['gender'], $_POST['status'], $_POST['id']);
                    break;
                case 'gorest':
                    $error = $this->apiModel->changeUserInfo($_POST['name'], $_POST['email'], $_POST['gender'], $_POST['status'], $_POST['id']);
                    break;
            }
            if ($error)
                View::error($error);
            else
                $this->view->redirect('/' . $GLOBALS['baseUrl'].'?source='.$_GET['source']);
        }
    }

    public function deleteAction() {
        if (isset($_POST['usersIds'])) {
            $ids = explode(",",$_POST['usersIds']);
            foreach ($ids as $id) {
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
                $error = $this->apiModel->deleteUser($id);
                if (isset($user['errorCode']))
                    View::error($error);
                break;
        }
    }

    private function getCheckedIds() {
        return $_POST ? explode(",", $_POST['checkedIds']) : [''];
    }
}