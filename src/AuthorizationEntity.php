<?php

namespace linkprofit\AmoCRM;


class AuthorizationEntity extends AbstractEntity
{
    /**
     * @var Connection
     */
    protected $connection;

    /**
     * AuthorizationEntity constructor.
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
        $this->link = $this->getLink();
    }

    /**
     * @return bool
     */
    public function authorize()
    {
        $this->composeFields();
        $this->performRequest();
        $this->encodeResponse();

        return $this->checkResponse();
    }

    /**
     * @return bool
     */
    protected function checkResponse()
    {
        if (isset($this->response['auth'])) {
            return true;
        }

        return false;
    }

    /**
     * @return string
     */
    protected function getLink()
    {
        return 'https://' . $this->connection->subdomain . '.amocrm.ru/private/api/auth.php?type=json';
    }

    /**
     * Fill fields for response
     */
    protected function composeFields()
    {
        $this->fields['USER_LOGIN'] = $this->connection->login;
        $this->fields['USER_HASH'] = $this->connection->apiHash;
    }
}