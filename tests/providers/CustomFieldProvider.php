<?php

namespace linkprofit\AmoCRM\tests\providers;


class CustomFieldProvider
{
    public function getEmailField()
    {
        $emailField = new \linkprofit\AmoCRM\entities\CustomField('146785', 'email', 'EMAIL');
        $emailField->addValue(new \linkprofit\AmoCRM\entities\Value(
                'email@email.com', '304683'
            )
        );

        return $emailField;
    }

    public function getPhoneField()
    {
        $phoneField = new \linkprofit\AmoCRM\entities\CustomField('146783', 'Телефон', 'PHONE');
        $phoneField->addValue(new \linkprofit\AmoCRM\entities\Value(
            '89858881233', '304673'
        ));

        return $phoneField;
    }
}