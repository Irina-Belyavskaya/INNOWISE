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
        $pageInfo = ['title' => 'User Page', 'records' => $records, 'count' => $result['count'], 'currentPage' => $result['page'], 'checkedId' => $checkedId, 'source' => $source];
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
            $this->model->addUser($_POST['name'], $_POST['email'], $_POST['gender'], $_POST['status']);
            $this->view->redirect('/' . $GLOBALS['baseUrl']);
        }
    }

    public function changeAction() {
        $user = $this->model->findUser($_GET['id_user']);
        if ($user) {
            $userInfo = ['title' => 'Change user information','id' => $user['id_user'] ,'name' => $user['FIO'], 'email' => $user['Email'], 'gender' => $user["Gender"], 'status' => $user['Status']];
            $this->view->render($userInfo);
        } else {
            View::errorCode(404);
        }
    }

    public function updateAction() {
        if (!empty($_POST)) {
            $user = $this->model->findUser($_POST['id_user']);
            if ($user['Email'] !== $_POST['email']) {
                if (!$this->model->checkUniqEmail($_POST['email'])) {
                    $this->view->redirect('/' . $GLOBALS['baseUrl']);
                    return;
                }
            }
            $this->model->changeUserInfo($_POST['name'], $_POST['email'], $_POST['gender'], $_POST['status'], $_POST['id_user']);
            $this->view->redirect('/' . $GLOBALS['baseUrl']);
        }
    }

    public function deleteAction() {
        if (isset($_POST['usersId'])) {
            $ids = explode(",",$_POST['usersId']);
            foreach ($ids as $id) {
                if (!$this->model->deleteUser($id)) {
                    View::errorCode(404);
                }
            }
        }
        if (isset($_GET['id_user'])) {
            if (!$this->model->deleteUser($_GET['id_user'])) {
                View::errorCode(404);
            }
        }
        $this->view->redirect('/' . $GLOBALS['baseUrl']);
    }

    private function getCheckedIds() {
        return $_POST ? explode(",", $_POST['checkedId']) : [''];
    }
}