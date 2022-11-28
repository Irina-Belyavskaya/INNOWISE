<?php

namespace controllers;

use core\Controller;
use core\Database;
use core\View;
use OpenApi\Annotations as OA;
/**
 * @OA\Info(
 *   title="PHP API",
 *   version="1.0",
 *   description="Swagger OpenApi description"
 * )
 */
class UserController extends Controller
{
    public function apiAction() {
        require_once ($_SERVER['DOCUMENT_ROOT']."/INNOWISE/documentation/api.php");
    }

    /**
     * @OA\Get(
     *   path="/INNOWISE/controllers/UserController.php",
     *   summary="Get users",
     *   tags={"Users"},
     *   @OA\Parameter(
     *     name="source",
     *     in="query",
     *     required=true,
     *     description="The name of source passed to get users",
     *     @OA\Schema(
     *       type="string"
     *     )
     *   ),
     *   @OA\Response(
     *     response="200",
     *     description="List of users"
     *   ),
     *   @OA\Response(
     *     response="404",
     *     description="Not found"
     *   )
     * )
     */
    public function indexAction() {
        $checkedId = $this->getCheckedIds();
        $result = $this->pagination();
        $pageInfo = ['title' => 'User Page','records' => $this->model->getLimitUsers($result['from'], $result['limit']), 'count' => $result['count'], 'currentPage' => $result['page'],'checkedId' => $checkedId];
        if (!$pageInfo) {
            View::errorCode(500);
        }
        $this->view->render($pageInfo);
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
        $this->view->render(['title' => 'Add user']);
    }

    /**
     * @OA\Post(
     *   path="/INNOWISE/controllers/UserController.php",
     *   summary="Add user",
     *   tags={"Users"},
     *   @OA\Parameter(
     *     name="source",
     *     in="query",
     *     required=true,
     *     description="The name of source passed to get users",
     *     @OA\Schema(
     *       type="string"
     *     )
     *   ),
     *   @OA\RequestBody(
     *    required=true,
     *    description="Pass user information",
     *    @OA\JsonContent(
     *       required={"name","email","gender","status"},
     *       @OA\Property(property="name", type="string", format="name", example="Vanya Gener"),
     *       @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
     *       @OA\Property(property="gender", type="string", format="female/male", example="male"),
     *       @OA\Property(property="status", type="string", format="active/inactive", example="active")
     *    ),
     *   ),
     *   @OA\Response(
     *     response="200",
     *     description="Ok"
     *   ),
     *   @OA\Response(
     *     response="422",
     *     description="Unprocessable Entity"
     *   )
     * )
     */
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

    /**
     * @OA\Patch(
     *   path="/INNOWISE/controllers/UserController.php",
     *   summary="Change user information",
     *   tags={"Users"},
     *   @OA\Parameter(
     *     name="source",
     *     in="query",
     *     required=true,
     *     description="The name of source passed to get users",
     *     @OA\Schema(
     *       type="string"
     *     )
     *   ),
     *   @OA\RequestBody(
     *    required=true,
     *    description="Pass new user information",
     *    @OA\JsonContent(
     *       required={"name","email","gender","status"},
     *       @OA\Property(property="name", type="string", format="name", example="Vanya Gener"),
     *       @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
     *       @OA\Property(property="gender", type="string", format="female/male", example="male"),
     *       @OA\Property(property="status", type="string", format="active/inactive", example="active")
     *    ),
     *   ),
     *   @OA\Response(
     *     response="200",
     *     description="Ok"
     *   ),
     *   @OA\Response(
     *     response="422",
     *     description="Unprocessable Entity"
     *   )
     * )
     */
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


    /**
     * @OA\Delete(
     *   path="/INNOWISE/controllers/UserController.php",
     *   summary="Delete user",
     *   tags={"Users"},
     *   @OA\Parameter(
     *     name="source",
     *     in="query",
     *     required=true,
     *     description="The name of source passed to get users like in query string",
     *     @OA\Schema(
     *       type="string"
     *     )
     *   ),
     *     @OA\Parameter(
     *     name="id",
     *     in="query",
     *     required=true,
     *     description="The id passed to delete user as string in query",
     *     @OA\Schema(
     *       type="string"
     *     )
     *   ),
     *   @OA\RequestBody(
     *    required=false,
     *    description="Users ids which you want to delete",
     *    @OA\JsonContent(
     *       required={"usersIds"},
     *       @OA\Property(property="usersIds", type="string", format="numbers", example="25,45,78")
     *    ),
     *   ),
     *   @OA\Response(
     *     response="200",
     *     description="Ok"
     *   ),
     *   @OA\Response(
     *     response="404",
     *     description="Not found"
     *   ),
     * )
     */
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