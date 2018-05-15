<?php

namespace linkprofit\AmoCRM\services;

use linkprofit\AmoCRM\entities\Account;
use linkprofit\AmoCRM\entities\Field;
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
     * @var array
     */
    protected $fieldAssociation = [
        'contacts' => Field::CONTACT_ELEMENT_TYPE,
        'leads' => Field::LEAD_ELEMENT_TYPE,
        'companies' => Field::COMPANY_ELEMENT_TYPE,
        'customers' => Field::CUSTOMER_ELEMENT_TYPE,
        'catalogs' => true
    ];

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
     * TODO
     *
     * @return \linkprofit\AmoCRM\entities\Field[]
     */
    public function getCustomFields()
    {
        $this->send(['with' => 'custom_fields']);

        return $this->parseCustomFieldsArrayToFieldEntities($this->request->getResponse()['_embedded']['custom_fields']);
    }

    /**
     * TODO
     *
     * @return \linkprofit\AmoCRM\entities\User[]
     */
    public function getUsers() {}

    /**
     * TODO
     *
     * @return \linkprofit\AmoCRM\entities\Pipeline[]
     */
    public function getPipelines() {}

    /**
     * TODO
     *
     * @return \linkprofit\AmoCRM\entities\Group[]
     */
    public function getGroups() {}

    /**
     * TODO
     *
     * @return \linkprofit\AmoCRM\entities\NoteTypes[]
     */
    public function getNoteTypes() {}

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

    /**
     * @param array $array
     *
     * @return array
     */
    private function parseCustomFieldsArrayToFieldEntities(array $array)
    {
        $entities = [];

        foreach ($array as $elementTypeKey => $items) {
            if (!isset($this->fieldAssociation[$elementTypeKey])) {
                continue;
            }

            $elementType = $this->fieldAssociation[$elementTypeKey];

            if ($elementType === true) {
                $entities = array_merge($entities, $this->parseArrayToCatalogFieldEntities($items));
            } else {
                $entities = array_merge($entities, $this->parseArrayToFieldEntities($items, $elementType));
            }
        }

        return $entities;
    }

    /**
     * @param array $items
     * @param int $elementType
     *
     * @return array
     */
    private function parseArrayToFieldEntities(array $items, $elementType)
    {
        $entities = [];
        foreach ($items as $item) {
            $entities[] = $this->parseArrayToFieldEntity($item, $elementType);
        }

        return $entities;
    }

    /**
     * @param array $item
     * @param       $elementType
     *
     * @return \linkprofit\AmoCRM\entities\Field
     */
    private function parseArrayToFieldEntity(array $item, $elementType)
    {
        $entity = new Field();
        $entity->set($item);
        $entity->element_type = $elementType;

        return $entity;
    }

    /**
     * @param array $items
     *
     * @return array
     */
    private function parseArrayToCatalogFieldEntities(array $items)
    {
        $entities = [];
        foreach ($items as $elementType => $catalogItems) {
            $entities = array_merge($entities, $this->parseArrayToFieldEntities($catalogItems, $elementType));
        }
        return $entities;
    }
}