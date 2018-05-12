<?php

namespace linkprofit\AmoCRM\services;

use linkprofit\AmoCRM\entities\Account;
use linkprofit\AmoCRM\entities\TaskType;
use linkprofit\AmoCRM\RequestHandler;

/**
 * Class AccountService
 * @package linkprofit\AmoCRM\services
 */
class AccountService implements AccountServiceInterface
{
    /**
     * @var \linkprofit\AmoCRM\RequestHandler
     */
    protected $request;

    /**
     * ServiceInterface constructor.
     *
     * @param RequestHandler $requestHandler
     */
    public function __construct(RequestHandler $requestHandler)
    {
        $this->request = $requestHandler;
    }

    /**
     * @return bool|array
     */
    public function getAllArray()
    {
        $this->send();

        return $this->request->getResponse();
    }

    /**
     * @return array|bool|\linkprofit\AmoCRM\entities\Account
     */
    public function getAccount()
    {
        $this->send([]);

        return $this->parseArrayToAccountEntity($this->request->getResponse());
    }

    /**
     * @return \linkprofit\AmoCRM\entities\CustomField[]
     */
    public function getCustomFields()
    {
        // TODO
    }

    /**
     * @return \linkprofit\AmoCRM\entities\User[]
     */
    public function getUsers()
    {
        // TODO
    }

    /**
     * @return \linkprofit\AmoCRM\entities\Pipeline[]
     */
    public function getPipelines()
    {
        // TODO
    }

    /**
     * @return \linkprofit\AmoCRM\entities\Group[]
     */
    public function getGroups()
    {
        // TODO
    }

    /**
     * @return \linkprofit\AmoCRM\entities\NoteTypes[]
     */
    public function getNoteTypes()
    {
        // TODO
    }

    /**
     * @return \linkprofit\AmoCRM\entities\TaskType[]
     */
    public function getTaskTypes()
    {
        $this->send(['with' => 'task_types']);

        return $this->parseArrayToTaskTypeEntities($this->request->getResponse()['_embedded']['task_types']);
    }

    /**
     * @return string
     */
    protected function getLink()
    {
        return 'https://' . $this->request->getSubdomain() . '.amocrm.ru/api/v2/account';
    }

    /**
     * @param array $with
     */
    private function send($with = ['with' => 'custom_fields,users,pipelines,groups,note_types,task_types'])
    {
        $link = $this->getLink() . '?' . http_build_query($with);
        $this->request->performRequest($link, [], 'application/json', 'GET');
    }

    /**
     * @param $array
     *
     * @return Account
     */
    private function parseArrayToAccountEntity($array)
    {
        $account = new Account();
        $account->set($array);

        return $account;
    }

    /**
     * @param array $array
     *
     * @return array
     */
    public function parseArrayToTaskTypeEntities(array $array)
    {
        $entities = [];

        foreach ($array as $item) {
            $entity = new TaskType();
            $entity->set($item);
            $entities[] = $entity;
        }

        return $entities;
    }
}