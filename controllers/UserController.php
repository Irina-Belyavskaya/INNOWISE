<?php

namespace controllers;

use core\Controller;
use core\Database;
use core\View;
class UserController extends Controller
{
    public function indexAction() {
        if ($_POST)
            $checkedId = explode(",", $_POST['checkedId']);
        else
            $checkedId = ['-1'];
        $result = $this->pagination();
        $pageInfo = ['records' => $this->model->getLimitUsers($result['from'], $result['limit']), 'count' => $result['count'], 'currentPage' => $result['page'],'checkedId' => $checkedId];
        if (!$pageInfo) {
            View::errorCode(500);
        }
        $this->view->render('User Page', $pageInfo);
    }

    public function pagination() {
        // Get current page
        if ($_GET) {
            $page = $_GET['page'];
        } else {
            $page = 1;
        }

        // Get users for current page
        $limit = 4;
        $from = ($page - 1) * $limit;
        $count = ceil($this->model->getUsersCount() / $limit);
        return ['from' => $from, 'limit' => $limit, 'count' => $count, 'page' => $page];
    }

    public function addAction() {
        $this->view->render('Add user');
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
            $userInfo = ['id' => $user['id_user'] ,'name' => $user['FIO'], 'email' => $user['Email'], 'gender' => $user["Gender"], 'status' => $user['Status']];
            $this->view->render('Change user information', $userInfo);
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
}