    'use strict';
var services = angular.module('services', []);

        /*
         * dataFactory - сервис для связи с серером по http
         */
services.factory('dataFactory', ['$http', function ($http) {
        var promise = null;
        var data = null;
        return {
            /*
             * если еще не загружали в текущей сессии данные с сервера,
             * то создается промис, который и возвращается из фактори. 
             * по окончанию загрузки в переменную data кладется response.data.
             * 
             * в дальнейшем эти данные можно получить функцией getData.
             */
            load: function () {
                if (promise === null) {
                    promise = $http.get('api/load').then(function (response) {
                        data = response.data;
                    });
                }
                return promise;
            },
            /*
             * в функции save мы возвращаем промис, по получении ответа 
             * редактируем массив data в зависимости от ответа, возвращаем 
             * response.
             */
            save: function (postData) {
                return  $http.post('api/save', postData).then(function (response) {
                    var resp = response.data;
                    var auId = resp.author.id;
                    var adId = resp.ad.id;
                    if (resp.author.status == 'success') {
                        if (resp.author.action == 'save') {
                            data.authors[auId] = {'email': postData.email, 'seller_name': postData.seller_name, 'id': auId};

                        } else if (resp.author.action == 'update') {

                            data.authors[auId].seller_name = postData.seller_name;
                        }
                    }
                    if (resp.ad.status == 'success') {
                        postData.author_id = auId;
                        postData.id = adId;
                        data.ads[adId] = postData;
                    }
                    return response;
                });
            },
            delete: function (id) {
                return $http.get('api/delete?id=' + id).then(function (response) {
                    if (response.data.status == 'success') {
                        delete(data.ads[id]);
                    }
                    return response;
                });
            },
            /*
             * при нажатии на кнопку Редактировать - возвращаем промис, по исполнению
             * которого из ответа сервера создается объект-форма. эта форма потом передается на вывод в контроллере.
             */
            edit: function (id) {
                return $http.get('api/edit?id=' + id).then(function(response){
                   var adData = response.data.ad;
                   var auData = response.data.author;
                   var form ={};
                       form.category_id = adData.category_id;
                       form.private = adData.private;
                       form.allow_mails = adData.allow_mails;
                       form.phone = adData.phone;
                       form.location_id = adData.location_id;
                       form.title = adData.title;
                       form.description= adData.description;
                       form.price= parseInt(adData.price, 10);
                       form.id = adData.id;
                       form.email = auData.email;
                       form.seller_name = auData.seller_name;
                       
                       return form;
                });
            },
            getData: function () {
                return data;
            }
        };

    }]);
        /*
         * сервис значений формы. В самом начале при создании контроллера
         * используется getForm , чтобы получить formVals. В дальнейшем используется резет.
         * при переходе на другой partial.html данные с формы записываются в переменную formVals.
         */
services.factory('formFactory', function () {
    var formVals = {private: 0, price: 0};
    return{
        setForm:function(form){
            formVals = form;
        },
        getForm:function(){
            return formVals;
        },
        resetForm: function(){
            return {private: 0, price: 0};
        }
    };
});

/*
 * интерцептор, который при получении ответа от сервера просматривает статус ответа,
 * и в случае ошибки делает броадкаст на рутскоуп об ошибке.
 * в мэинконтроллере прослушивается этот броадкаст, и в случае ошибки - появляется мессадж.
 */
services.factory('dataFactoryInterceptor', function($rootScope){
    return {
           responseError: function(response) {
        if (response.status > 299) {
            $rootScope.$broadcast('response error');
        }
        return response;
        }
    }
});

        /*
         * сервис всплывающих сообщений. есть два контейнера. При создании контроллера 
         * ему передаются ссылки на эти две переменные adMsg и auMsg. Затем в процессе работы с объявлениями 
         * для вывода сообщений используется функция setMsg. Ей передаются Контейнер, сообщение, класс сообщения, и задержка перед показом.
         * Если контейнер не указан, то используется adMsg.
         * 
         */
services.factory('messageFactory', ['$timeout', function($timeout){
    var adMsg = {message: '', class: 'alert-info', show: false};
    var auMsg = {message: '', class: 'alert-success', show:false};
    return {
        getAdMsg: function(){
            return adMsg;
        },
        getAuMsg: function(){
            return auMsg;
        },
        setMsg: function(msgBox, msg, clss, delay){
            if (!msgBox) msgBox = adMsg;
                msgBox.show = false;
                $timeout(function () {
                    msgBox.message = msg;
                    msgBox.class = clss;
                    msgBox.show = true; 
                    }, delay);
                
        },
        /*
         * функция для закрытия мессаджбоксов.
         */
        hideMsgs: function(msgBoxToHide){
               if (msgBoxToHide === 'hide auMsg box'){ auMsg.show = false;}
               else if(msgBoxToHide === 'hide adMsg box'){ adMsg.show = false;}
        }
    }
    
}]);


