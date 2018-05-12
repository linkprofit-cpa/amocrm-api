<?php

namespace linkprofit\AmoCRM\services;

use linkprofit\AmoCRM\entities\EntityInterface;
use linkprofit\AmoCRM\RequestHandler;

/**
 * Interface AccountServiceInterface
 *
 * @package linkprofit\AmoCRM\services
 */
interface AccountServiceInterface
{
    /**
     * ServiceInterface constructor.
     * @param RequestHandler $requestHandler
     */
    public function __construct(RequestHandler $requestHandler);

    /**
     * @return \linkprofit\AmoCRM\entities\Account
     */
    public function getAccount();

    /**
     * @return \linkprofit\AmoCRM\entities\CustomField[]
     */
    public function getCustomFields();

    /**
     * @return \linkprofit\AmoCRM\entities\User[]
     */
    public function getUsers();

    /**
     * @return \linkprofit\AmoCRM\entities\Pipeline[]
     */
    public function getPipelines();

    /**
     * @return \linkprofit\AmoCRM\entities\Group[]
     */
    public function getGroups();

    /**
     * @return \linkprofit\AmoCRM\entities\NoteTypes[]
     */
    public function getNoteTypes();

    /**
     * @return \linkprofit\AmoCRM\entities\TaskType[]
     */
    public function getTaskTypes();
}