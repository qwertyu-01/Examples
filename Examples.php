<?php

//Вывод текстового сообщения в лог бизнес-процесса
$this->WriteToTrackingService("Это тест");

//Получение значения переменной
$b = $this->GetRootActivity()->GetVariable('test');

//Сохранение значения в переменную
$fieldValue = 123123;
$this->SetVariable('ObjectID', $fieldValue);

//Получение значения поля документа
$documentService = $this->workflow->GetService("DocumentService");
$document = $documentService->getDocument($this->getDocumentId());
$fieldValue = $document['STAGE_ID'];

//Получить текущий бизнес-процесс
$rootActivity = $this->GetRootActivity();

//Подключение модуля CRM
\Bitrix\Main\Loader::includeModule('crm');

//Подключение модуля инфоблоков
CModule::IncludeModule("iblock")

//Подключение модуля с оберткой
if (\Bitrix\Main\Loader::includeModule('crm'))
{
    $this->WriteToTrackingService("Модуль подключен");
}
else
{
    $this->WriteToTrackingService("Модуль НЕ подключен");
}

//Обновление, например, сделки
$deal = new CCrmDeal();
$arFields = ['PARENT_ID_185' => 2];
$deal->update(5, $arFields); // первый параметр – ID сущности

//Получение сделки по ID
\Bitrix\Main\Loader::includeModule('crm');
$deal = new CCrmDeal();
$deal=$deal->GetByID(5); // параметр – ID сущности

//Обновление объекта в D7. Пример 1.
\Bitrix\Main\Loader::includeModule('crm');
use Bitrix\Crm\Service;
use Bitrix\Crm\Item;
$factory = Service\Container::getInstance()->getFactory(\CCrmOwnerType::Deal);
// CCrmOwnerType выбиать по ссылке
// https://dev.1c-bitrix.ru/api_d7/bitrix/crm/crm_owner_type/identifiers.php
$item = $factory->getItem(5);
if ($item)
{
    $item->setStageId('PREPARATION');
    $result = $item->save();
}

//Обновление объекта в D7. Пример 2.
use Bitrix\Crm\Service;
use Bitrix\Crm\Item;
if (\Bitrix\Main\Loader::includeModule('crm'))
{
	$factory = Service\Container::getInstance()->getFactory(\CCrmOwnerType::Deal);
	$item = $factory->getItem(5);
	if ($item)
	{
		$item->set('COMMENTS', 'новый комментарий');
		$item->save();
		echo($item->get('COMMENTS'));
	}
}
else
{ echo('модуль не подключен'); }

//Получение коллекции элементов, например, сделок
\Bitrix\Main\Loader::includeModule('crm');
$arOrder = ["ID"=>"ASC"];
$arFilter = ['ASSIGNED_BY_ID' => '6'];
$arSelectFields = ['ID'];
$deals = CCrmDeal::GetListEx($arOrder, $arFilter, $arGroupBy = false, $arNavStartParams = false, $arSelectFields);
// альтернативный вариант
//$deal = new CCrmDeal()
//$deals = $deal->GetListEx($arOrder, $arFilter, $arGroupBy = false, $arNavStartParams = false, $arSelectFields);
while ($newDeal = $deals->fetch())
{
    print_r($newDeal);
}


?>