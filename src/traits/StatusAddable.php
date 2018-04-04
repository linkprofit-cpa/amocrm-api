<?php

namespace linkprofit\AmoCRM\traits;

use linkprofit\AmoCRM\entities\Status;

/**
 * Class StatusAddable
 * @package linkprofit\AmoCRM\traits
 */
trait StatusAddable
{
    /**
     * @var Status[] Этапы воронки, необходимо передать хотя бы один этап, кроме успешно/неуспешно завершенного.
     * В качестве ключа необходимо передать идентификатор этапа, если он существует. Для этапов успешно/неуспешно завершенно (id 142/143 соответственно) возможно передать только поле name
     */
    public $statuses = [];

    use FieldList;

    /**
     * @param Status $status
     */
    public function addStatus(Status $status)
    {
        $this->statuses[] = $status;
    }
}