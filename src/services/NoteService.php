<?php

namespace linkprofit\AmoCRM\services;

use linkprofit\AmoCRM\entities\EntityInterface;
use linkprofit\AmoCRM\entities\Note;

/**
 * Class NoteService
 * @package linkprofit\AmoCRM\services
 */
class NoteService extends BaseService
{
    /**
     * @var Note[]
     */
    protected $entities = [];

    /**
     * @param Note $note
     */
    public function add(EntityInterface $note)
    {
        if ($note instanceof Note) {
            $this->entities[] = $note;
        }
    }

    /**
     * @param $array
     * @return Note
     */
    public function parseArrayToEntity($array)
    {
        $task = new Note();
        $task->set($array);

        return $task;
    }

    /**
     * @return string
     */
    protected function getLink()
    {
        return 'https://' . $this->request->getSubdomain() . '.amocrm.ru/api/v2/notes';
    }

}