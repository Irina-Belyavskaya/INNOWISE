<?php
namespace models\API;
use core\Model;
use GuzzleHttp\Client;

class User extends Model
{
    private Client $client;

    public function __construct() {
        parent::__construct();
        $this->client = new Client();
    }

    public function getUsers() {
        try {
            $res = $this->client->request('GET', 'https://gorest.co.in/public/v2/users',
                ['headers' => ['Content-Type' => 'application/json',
                 'Authorization' => 'Bearer 71bfefe0630f565782d4be3712bebf90dfbe2d4d75b42e6e09b374e050ceb344',
                 'Accept' => 'application/json']
            ]);
            return json_decode($res->getBody(), true);
        } catch (\Exception $exception) {
            return  ['errorCode' => $exception->getCode(), 'errorText' => $exception->getMessage()];
        }
    }

    public function addUser($name,$email,$gender,$status) {
        try {
            $response = $this->client->request('POST', 'https://gorest.co.in/public/v2/users', [
                'json' => [
                    'name' => $name,
                    'email' => $email,
                    'gender' => $gender,
                    'status' => $status
                ],
                'headers' => ['Content-Type' => 'application/json',
                              'Authorization' => 'Bearer 71bfefe0630f565782d4be3712bebf90dfbe2d4d75b42e6e09b374e050ceb344',
                              'Accept' => 'application/json']
                ]
            );
            return [];
        } catch (\Exception $exception) {
            return  ['errorCode' => $exception->getCode(), 'errorText' => $exception->getMessage()];
        }
    }

    public function changeUserInfo($name,$email,$gender,$status,$id) {
        try {
            $this->client->request('PATCH', 'https://gorest.co.in/public/v2/users/' . $id, [
                    'json' => [
                        'name' => $name,
                        'email' => $email,
                        'gender' => $gender,
                        'status' => $status
                    ],
                    'headers' => ['Content-Type' => 'application/json',
                        'Authorization' => 'Bearer 71bfefe0630f565782d4be3712bebf90dfbe2d4d75b42e6e09b374e050ceb344',
                        'Accept' => 'application/json']
                ]
            );
            return [];
        } catch (\Exception $exception) {
            return  ['errorCode' => $exception->getCode(), 'errorText' => $exception->getMessage()];
        }
    }

    public function findUser($id) {
        try {
            $res = $this->client->request('GET', 'https://gorest.co.in/public/v2/users/'.$id,
                ['headers' => ['Content-Type' => 'application/json',
                    'Authorization' => 'Bearer 71bfefe0630f565782d4be3712bebf90dfbe2d4d75b42e6e09b374e050ceb344',
                    'Accept' => 'application/json']
                ]);
            return json_decode($res->getBody(), true);
        } catch (\Exception $exception) {
            return  ['errorCode' => $exception->getCode(), 'errorText' => $exception->getMessage()];
        }
    }

    public function deleteUser ($id) {
        try {
            $this->client->request('DELETE', 'https://gorest.co.in/public/v2/users/'.$id,
                ['headers' => ['Content-Type' => 'application/json',
                    'Authorization' => 'Bearer 71bfefe0630f565782d4be3712bebf90dfbe2d4d75b42e6e09b374e050ceb344',
                    'Accept' => 'application/json']
                ]);
            return [];
        } catch (\Exception $exception) {
            return  ['errorCode' => $exception->getCode(), 'errorText' => $exception->getMessage()];
        }
    }
}