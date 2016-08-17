# Boxberry
Компонент для работы с [АПИ](http://api.boxberry.de) службы доставки [Boxberry](http://boxberry.ru).
Это универсальный механизм, который позволяет облегчить интеграцию обмена с АПИ-сервисами Boxberry. Не нужно углубленно изучать SOAP и JSON,
ограничиваясь только пониманием о структуре передаваемых данных.

## Установка компонента
Чтобы установить исходный код из репозитория:
```sh
    $ git clone git@github.com:AlekseyNikulin/Boxberry.git    
```
    
## Настройка
Для настройки приложения, откройте для изменений файл конфигурации **configure.php**:   
```php   
   // Корневая директория компонента. 
   define("BOXBERRY_DIR",__DIR__."/");
   
   // Адрес хоста источника данных.
   define("HOST","http://test.api.boxberry.de");   
```
   
### Soap   
Если у вас по каким-либо причинам не работает [curl](http://php.net/manual/ru/book.curl.php), 
отключена директива [allow_url_fopen](http://www.php.net/manual/ru/filesystem.configuration.php#ini.allow-url-fopen) и так далее,
то вполне вероятно Вы станете применять технологию обмена по стандарту [SOAP](http://www.tutorialspoint.com/soap/what_is_soap.htm).
    
#### Личный кабинет.
В АПИ личного кабинета вы можете создавать/изменять/удалять посылки, формировать акты-приема передачи, 
генерировать этикетки и т.д.   
```php   
   define("LC_SERVICE","/__soap/1c_lc.php?wsdl");   
```
   
#### Справочники
**В АПИ справочнков вам доступна информация:** 
   - о городах, в которых есть **ПВЗ** (пункты выдачи заказов Boxberry)
   - о городах, в которых есть курьерская доставка
   - исчерпывающая информация о ПВЗ
   - стоимость оказанных услуг
   - расчет стоимости доставки
   - отслеживать состояние посылки    
```php   
   define("PUBLIC_SERVICE","/__soap/1c_public.php?wsdl");   
```
   
**Список Soap методов**

Необходимо указать принадлежность метода к сервису.
Если этого не сделать, то передача аргументов для неописаного
метода будет осуществляться к сервису PUBLIC_SERVICE      
```php   
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
           'ListPointsForeign'
       ]
    ];   
```
   
### Json.
Обычно [JSON](http://www.w3schools.com/json/) не имеет избыточности, поэтому менее ресурсоемкий 
и более компактный. Все методы и сервисы, перечисленные в SOAP, заключены в одном источнике. 
Если используете JSON, то в настройках SOAP нет необходимости. 
```php         
   define("JSON_SERVICE","/json.php");            
```
   
## Запуск приложения
Откройте для изменений файл **index.php**

**Включение файла конфигурации**
```php    
    include_once(dirname(__FILE__)."/configure.php");    
```

**Включение файла с классом boxberry**
```php
    include_once(BOXBERRY_DIR."/boxberry.php");    
```

**Иницифлизация класса boxberry**
```php    
    $boxberry = new \boxberryApi\boxberry();        
```
    
**Тип передачи данных: soap/json** (в нижнем регистре)
```php
    $boxberry->type = "json";    
```
    
**Список (массив) аргументов, ожидаемых и используемых методом**

Индивидуальный токен (token) выдается каждому Клиенту индивидуально, после регистрации в системе службы доставки Boxberry 
и заключении договора.
Передача аргументов token и method обязательны: 
```php
    $boxberry->args = [
        'token'=>'******',
        'method'=>'ListPoints'
    ];    
```

**Получение результата**

Метод getData() класса boxberry возвращает масив (набор данных), полученный от АПИ Boxberry 
```php
    print_r($boxberry->getData());
    
```
    
###Всем успехов!
 
