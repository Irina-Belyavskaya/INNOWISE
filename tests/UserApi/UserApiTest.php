<?php
namespace UserApi;
use controllers\UserController;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use models\API\User;
class UserApiTest extends \PHPUnit\Framework\TestCase
{
    private $mockObject;
    private $controller;
    private $route = ['controller' => 'user', 'action' => 'index'];

    protected function setUp(): void
    {
        $this->mockObject = $this->getMockBuilder(User::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->controller = new UserController($this->route);
        $_GET['source'] = 'gorest';
    }

    public function testGetUsers(): void
    {
        $this->route = ['controller' => 'user', 'action' => 'index'];
        $this->mockObject->expects($this->once())
            ->method('getUsers')
            ->will($this->returnValue(
                [
                    'success' => true,
                    'users' =>
                    [
                        [
                            "id" => 2911,
                            "name"=>"The Hon. Chidaakaash Desai",
                            "email" => "the_desai_chidaakaash_hon@bins.com",
                            "gender" => "male",
                            "status" => "inactive"
                        ],
                        [
                            "id" => 2311,
                            "name"=>"The Hon",
                            "email" => "the_des@bins.com",
                            "gender" => "male",
                            "status" => "inactive"
                        ]
                    ]
                ]
            ));
        $_GET['source'] = 'gorest';
        $this->controller->indexAction();

        $this->assertInstanceOf(User::class, $this->mockObject);
    }

    public function testAddUser() {
        $this->route = ['controller' => 'user', 'action' => 'create'];
        $user = [
            'name' => 'UserApiTests',
            'email' => 'user1@mail.ru',
            'gender' => 'male',
            'status' => 'active'
        ];
        $this->mockObject->expects($this->once())
            ->method('addUser')
            ->with($user)
            ->will($this->returnValue(['success' => true]));
        $this->controller->createAction();
    }

    public function testDeleteUser() {
        $this->route = ['controller' => 'user', 'action' => 'delete'];
        $id = 2311;
        $this->mockObject->expects($this->once())
            ->method('deleteUser')
            ->with($id)
            ->will($this->returnValue(['success' => true]));
        $this->controller->deleteAction();
    }

    protected function tearDown(): void
    {
        $this->mockObject = null;
        $this->controller = null;
    }
}