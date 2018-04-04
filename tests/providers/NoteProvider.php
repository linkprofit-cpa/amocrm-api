<?php

namespace linkprofit\AmoCRM\tests\providers;


class NoteProvider
{
    public function getNote()
    {
        $note = new \linkprofit\AmoCRM\entities\Note();
        $note->text = 'Заметка';
        $note->note_type = $note::COMMON;
        $note->responsible_user_id = 1924000;

        return $note;
    }
}