<?php

namespace controllers;

use core\Controller;
use core\View;
class UsersController extends Controller
{
    public function showMainAction() {
        $vars = ['records' => $this->model->getRecords()];
         if (!$vars) {
             View::errorCode(500);
         }
        $this->view->render('Users Page', $vars);
    }

    public function addAction () {
        if (!empty($_POST)) {
            $this->model->addUser($_POST['name'], $_POST['email'], $_POST['gender'], $_POST['status']);
            $this->view->redirect('/' . $GLOBALS['baseUrl']);
        }
    }

    public function showAddAction() {
        $this->view->render('Add user');
    }

    public function changeAction() {
        $user = $this->model->findRecord($_GET['id_user']);
        if ($user) {
            $vars = ['id' => $user[0] ,'name' => $user[1], 'email' => $user[2], 'gender' => $user[3], 'status' => $user[4]];
            $this->view->render('Change user information', $vars);
        } else {
            View::errorCode(404);
        }
    }

    public function updateAction() {
        if (!empty($_POST)) {
            $this->model->changeUserInfo($_POST['name'], $_POST['email'], $_POST['gender'], $_POST['status'], $_POST['id_user']);
            $this->view->redirect('/' . $GLOBALS['baseUrl']);
        }
    }

    public function deleteAction() {
        if (!$this->model->deleteUser($_GET['id_user'])) {
            View::errorCode(404);
        }
        $this->view->redirect('/' . $GLOBALS['baseUrl']);
    }
}