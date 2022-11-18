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
        switch ($_GET['source']) {
            case 'gorest':
                $users = $this->apiModel->getUsers();
                $result = $this->pagination(count($users));
                $records = array_slice($users, $result['from'], $result['limit']);
                $source = 'gorest';
                break;
            case 'local':
                $result = $this->pagination($this->model->getUsersCount());
                $records = $this->model->getLimitUsers($result['from'], $result['limit']);
                $source = 'local';
                break;
        }
        $checkedId = $this->getCheckedIds();
        $pageInfo = ['title' => 'User Page', 'records' => $records, 'count' => $result['count'], 'currentPage' => $result['page'], 'checkedIds' => $checkedId, 'source' => $source];
        $this->view->render($pageInfo);
    }

    public function pagination($usersCount) {
        // Get current page
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 1;
        }

        // Get users for current page
        $limit = 4;
        $count = ceil($usersCount / $limit);
        if ($page > $count)
            $page = $count;
        $from = ($page - 1) * $limit;

        return ['from' => $from, 'limit' => $limit, 'count' => $count, 'page' => $page];
    }

    public function addAction() {
        $this->view->render(['title' => 'Add user']);
    }

    public function createAction () {
        if (!empty($_POST)) {
            switch ($_GET['source']) {
                case 'gorest':
                    $this->apiModel->addUser($_POST['name'], $_POST['email'], $_POST['gender'], $_POST['status']);
                    $this->view->redirect('/' . $GLOBALS['baseUrl'].'?source=gorest');
                    break;
                case 'local':
                    $this->model->addUser($_POST['name'], $_POST['email'], $_POST['gender'], $_POST['status']);
                    $this->view->redirect('/' . $GLOBALS['baseUrl']);
                    break;
            }
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
        if ($user) {
            $userInfo = ['title' => 'Change user information', 'id' => $user['id'], 'name' => $user['name'], 'email' => $user['email'], 'gender' => $user["gender"], 'status' => $user['status'], 'source' => $_GET['source']];
            $this->view->render($userInfo);
        } else {
            View::errorCode(404);
        }
    }

    public function updateAction() {
        if (!empty($_POST)) {
            switch ($_GET['source']) {
                case 'local':
                    $user = $this->model->findUser($_POST['id']);
                    if ($user['email'] !== $_POST['email']) {
                        if (!$this->model->checkUniqEmail($_POST['email'])) {
                            $this->view->redirect('/' . $GLOBALS['baseUrl'].'?source='.$_GET['source']);
                            return;
                        }
                    }
                    $this->model->changeUserInfo($_POST['name'], $_POST['email'], $_POST['gender'], $_POST['status'], $_POST['id']);
                    break;
                case 'gorest':
                    $this->apiModel->changeUserInfo($_POST['name'], $_POST['email'], $_POST['gender'], $_POST['status'], $_POST['id']);
                    break;
            }
            $this->view->redirect('/' . $GLOBALS['baseUrl'].'?source='.$_GET['source']);
        }
    }

    public function deleteAction() {
        if (isset($_POST['usersIds'])) {
            $ids = explode(",",$_POST['usersIds']);
            foreach ($ids as $id) {
                switch ($_GET['source']) {
                    case 'local':
                        if (!$this->model->deleteUser($id)) {
                            View::errorCode(404);
                        }
                        break;
                    case 'gorest':
                        $this->apiModel->deleteUser($id);
                        break;
                }
            }
        }
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            switch ($_GET['source']) {
                case 'local':
                    if (!$this->model->deleteUser($id)) {
                        View::errorCode(404);
                    }
                    break;
                case 'gorest':
                    $this->apiModel->deleteUser($id);
                    break;
            }
        }
        $this->view->redirect('/' . $GLOBALS['baseUrl'].'?source='.$_GET['source']);
    }

    private function getCheckedIds() {
        return $_POST ? explode(",", $_POST['checkedIds']) : [''];
    }
}