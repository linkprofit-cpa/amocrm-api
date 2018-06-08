<?php

namespace linkprofit\AmoCRM\entities;

/**
 * Class Field
 * @package linkprofit\AmoCRM\entities
 */
class Field extends BaseEntity
{
    /**
     * Обыное текстовое поле
     */
    const TEXT = 1;

    /**
     * Текстовое поле с возможностью передавать только цифры
     */
    const NUMERIC = 2;

    /**
     * Поле обозначающее только наличие или отсутствие свойства (например: "да"/"нет")
     */
    const CHECKBOX = 3;

    /**
     * Поле типа список с возможностью выбора одного элемента
     */
    const SELECT = 4;

    /**
     * Поле типа список c возможностью выбора нескольких элементов списка
     */
    const MULTISELECT = 5;

    /**
     * Поле типа дата возвращает и принимает значения в формате (Y-m-d H:i:s)
     */
    const DATE = 6;

    /**
     * Обычное текстовое поле предназначенное для ввода URL адресов
     */
    const URL = 7;

    /**
     * Поле textarea содержащее большое количество текста
     */
    const MULTITEXT = 8;

    /**
     * Поле textarea содержащее большое количество текста
     */
    const TEXTAREA = 9;

    /**
     * Поле типа переключатель
     */
    const RADIOBUTTON = 10;

    /**
     * Короткое поле адрес
     */
    const STREETADDRESS = 11;

    /**
     * Поле адрес (в интерфейсе является набором из нескольких полей)
     */
    const SMART_ADDRESS = 13;

    /**
     * Поле типа дата поиск по которому осуществляется без учета года, значения в формате (Y-m-d H:i:s)
     */
    const BIRTHDAY = 14;

    /**
     * Поле юридическое лицо (в интерфейсе является набором из нескольких полей)
     */
    const LEGAL_ENTITY = 15;

    /**
     * Поле состав каталога (поле доступно только в пользовательских списках)
     */
    const ITEMS = 16;

    /**
     * Контакт
     */
    const CONTACT_ELEMENT_TYPE = 1;

    /**
     * Сделка
     */
    const LEAD_ELEMENT_TYPE = 2;

    /**
     * Компания
     */
    const COMPANY_ELEMENT_TYPE = 3;

    /**
     * Покупатель
     */
    const CUSTOMER_ELEMENT_TYPE = 12;


    /**
     * @var string Название поля
     */
    public $name;

    /**
     * @var integer Тип поля
     */
    public $field_type;

    /**
     * @var integer Тип сущности
     */
    public $element_type;

    /**
     * @var string Уникальный идентификатор сервиса, по которому будет доступно удаление и изменение поля
     */
    public $origin;

    /**
     * @var bool
     */
    public $is_editable;

    /**
     * @var array Массив значений для списка или мультисписка. Значения указываются строковыми переменными, через запятую.
     */
    public $enums = [];

    /**
     * @var integer Уникальный идентификатор записи в клиентской программе (необязательный параметр). Информация о request_id нигде не сохраняется.
     */
    public $request_id;

    /**
     * @var bool Обязательность заполнения поля. Данное свойство применимо только для полей списка
     */
    public $is_required;

    /**
     * @var bool Возможность удалить поле в интерфейсе. Данное свойство применимо только для полей списка
     */
    public $is_deletable;

    /**
     * @var bool Видимость поля в интерфейсе. Данное свойство применимо только для полей списка
     */
    public $is_visible;

    /**
     * @var array
     */
    protected $fieldList = [
        'id', 'name', 'element_type',
        'field_type', 'origin',
        'is_editable', 'enums', 'request_id',
        'is_required', 'is_deletable', 'is_visible',
    ];

    /**
     * @param string $enum
     */
    public function linkEnum($enum)
    {
        $this->enums[] = $enum;
    }

    /**
     * @param array $enums
     */
    public function linkEnumArray(array $enums)
    {
        $this->enums = $enums;
    }
}