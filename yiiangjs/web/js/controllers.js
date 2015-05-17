    'use strict';
var controllers = angular.module('controllers', []);
controllers.controller('MainController', ['$rootScope', 'messageFactory', function ($rootScope, messageFactory) {
        $rootScope.$on('response error', function () {
            messageFactory.setMsg(null, 'Ошибка на сервере', 'alert-danger');
        });
    }]);


controllers.controller('FormController', ['$scope', 'dataFactory', 'formFactory', 'messageFactory', function ($scope, dataFactory, formFactory, messageFactory) {

        var store = this;
                /*
                 * загружаем из сервиса messageFactory сообщения.
                 */
        store.adMsg = messageFactory.getAdMsg();
        store.auMsg = messageFactory.getAuMsg();
        // выставляем кнопку Добавить\обновить как enabled
        store.sendButton = {active: true};
        
        /*
         * Загружаем из сервиса formFactory значения формы.
         * по дефолту стоят private: 0 и price: 0. Однако
         * при переходе на другую partial страницу у нас вызывается 
         * $locationChangeStart, который записывает текущие значения 
         * полей формы в formFactory, и при возвращении обратно
         * на страницу с формой метод formFactory.getForm() возвращает
         * уже сохраненные данные.
         * 
         */
        $scope.adform = formFactory.getForm();


                /*
                 * тут происходит загрузка данных. Сервис dataFactory отвечает 
                 * за http запросы к api сервера. В данном случае он загружает 
                 * объявления, категории, авторов, города, возвращает промис, а по 
                 * его выполнению записывает данные в свою переменную data, которая после 
                 * этого отдается нашему формконтроллеру через dataFactory.getData().
                 */
        dataFactory.load().then(function () {
            store.data = dataFactory.getData();
        });
        
        /*
         * У нас два закрываемых контейнера с сообщениями. эта функция срабатывает при
         * нажатии на Х(закрыть) на одном из них.
         */
        $scope.hideMsgs = function (msgBoxToHide) {
            messageFactory.hideMsgs(msgBoxToHide);
        };
        
                /*
                 * при нажатии на кнопку Добавить\Обновить
                 * 1) Кнопка становится неактивной
                 * 2) в переменную toSave записывается значение полей формы.
                 * 3)Затем toSave передается в наш dataFactory, который отсылает ее на сервер.
                 *  Там же в фактори обрабатываются статусы и в переменную сервиса data, которая залинкована с
                 *  переменной контроллера store.data вносятся изменения.
                 *  4) выводятся сообщения.
                 *  5) кнопка становится активной
                 *  6) форме возвращается значение нетронутости))
                 * 
                 */
        $scope.sendForm = function () {
            
            store.sendButton.active = false;
            var toSave = $scope.adform;

            dataFactory.save(toSave).then(function (response) {
                var resp = response.data;
                messageFactory.setMsg(store.adMsg, resp.ad.message, 'alert-info', 700);
                messageFactory.setMsg(store.auMsg, resp.author.message, 'alert-info', 300);
                $scope.adform = formFactory.resetForm();
                store.sendButton.active = true;
                $scope.adForm.$setPristine();
            });
        };

        /*
         * при удалении айди отправляется на сервер через наш сервис, затем резетается форма и появляется сообщение об удалении.
         * затем если объявлений больше нет, то выводится сообщение об этом.
         */
        $scope.delete = function (index) {
            dataFactory.delete(index).then(function (response) {
                $scope.adform = formFactory.resetForm();
                messageFactory.setMsg(store.adMsg, response.data.message, 'alert-warning', 300);
            }).then(function () {
                if (angular.equals({}, store.data.ads)) {
                        messageFactory.setMsg(store.auMsg, 'Больше нет объявлений', 'alert-danger', 1000);
                }
            });
        };
        
        /*
         * у нас есть выпадающий список авторов. При нажатии на его опции
         *  поля имя и мыло в форме заполняются и выводится сообщение.
         */
        $scope.auFill = function (mail, name) {
            $scope.adform.email = mail;
            $scope.adform.seller_name = name;
            messageFactory.setMsg(store.auMsg, 'Используется автор из списка', 'alert-warning', 300);
        };

        /*
         * при нажатии на кнопку Редактировать - отсылается на сервер id через наш сервис,
         * там обрабатывается ответ и возвращается модель заполненной формы.
         * затем эта модель присваивается нашей форме. выводим собщение.
         */
        $scope.edit = function (id) {
            dataFactory.edit(id).then(function (filledForm) {
                $scope.adform = filledForm;
                messageFactory.setMsg(store.adMsg,'Редактируем объявление №' + filledForm.id, 'alert-success', 300);
            });
        };

        /*
         * когда мы покидаем текущий partial.html, то вызывается запись формы в сервис.
         */
        $scope.$on('$locationChangeStart', function () {
            formFactory.setForm($scope.adform);

        });


    }]);


