<?
/**
 * @Description: Создано в России 
 * @User: aleksey.nikulin
 * @Date: 27.06.2016
 * @Time: 13:10
 * @Email: masterweb@e1.ru
 */

if((float)PHP_VERSION < "5.3") die("Version php should not be below 5.3");

// Корневая директория
define("BOXBERRY_DIR",__DIR__."/");

// Адрес ресурса
define("HOST","http://test.api.boxberry.de");

// Soap. Личный кабинет.
define("LC_SERVICE","/__soap/1c_lc.php?wsdl");

// Soap. Справочники
define("PUBLIC_SERVICE","/__soap/1c_public.php?wsdl");

// Json.
define("JSON_SERVICE","/json.php");

// Список Soap методов.
// Необходимо указать принадлежность метода к сервису.
// Если этого не сделать, то передача аргументов для неописаного
// метода будет производиться к сервису PUBLIC_SERVICE
$soap = [
    LC_SERVICE=>[
        'ParselCreate',
        'ParselCheck',
        'ParselList',
        'ParselDel',
        'ParselStory',
        'ParselSend',
        'ParselSendStory',
        'OrdersBalance',
        'ParselCreateSAP',
        'ChangeSettingsOrders',
        'SetHandBookStock',
        'GetHandBookStock',
        'ParcelCreateForeign',
        'ParcelSendForeign',
        'PaymentOrders'
    ],
    PUBLIC_SERVICE=>[
        'ListCities',
        'ListPoints',
        'ListZips',
        'ZipCheck',
        'ListStatuses',
        'ListStatusesFull',
        'ListServices',
        'PointsForParcels',
        'CourierListCities',
        'DeliveryCosts',
        'DeliveryCostsF',
        'PointsByPostCode',
        'PointsDescription',
        'ListPointsShort',
        'ListCountry',
        'ListPointsForeign',
        'GetTariffInfo'
    ]
];

define("SOAP",json_encode($soap));

