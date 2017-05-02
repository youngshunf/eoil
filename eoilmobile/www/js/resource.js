
define(function(require, exports, module) {
    'use strict';

    require('../base/my');

    var URL_HTTP_START = new RegExp("^https?://");
    var PUBLIC_URL_REGEX = new RegExp("^/common/");
    var HTTP_AUTH_FAIL_MESSAGE_MATCH = /^登录校验失败$/;

    function resourceHttpInterceptor($q, _ENV,_SITE, my, tokenStore) {

        return {
            request: function(config) {
                return _.flow(urlRewrite, tokenAppend)(config);
            },
            response: function(response) {
            	     
                return _.flow(resultCheck, resultUnpack)(response);
            },
            responseError: function(rejection) {
                if (rejection.status === 401) {
                    return $q.reject(new Error(401));
                }
                return $q.reject(rejection);
            }
        }

        function urlRewrite(config) {
            if (!config.isResource) {
                return config;
            }
            var originUrl = config.url;
            if (PUBLIC_URL_REGEX.test(originUrl)) {
                config.url = _ENV.api_url + originUrl;
            } else {
            		if(_SITE.appType==4 && config.appType==4){
            			 config.url = _ENV.crm_apiUrl + originUrl;
            		}else{
                // prepend /e/entCode
                var urlSegment = '';
                if (my.isLogined() && my.entCode) {
                    urlSegment = '/e/' + my.entCode;
                }
                config.url = _ENV.api_url + urlSegment + originUrl;
               }
            }
            return config;
        }

        function tokenAppend(config) {
            if (!config.isResource) {
                return config;
            }
            var tokenHeaders = tokenStore.headers();
            config.headers = config.headers || {};
            tokenHeaders && _.isObject(tokenHeaders) && _.forEach(tokenHeaders, function(value, name) {
                config.headers[name] = String(value);
            });
            return config;
        }

        function resultCheck(response) {
            var config = response.config || {};
            if (!config.isResource) {
                return response;
            }
            if (_.isObject(response.data)) {

                if (_.isInteger(response.data.$$_code) && response.data.$$_code !== 0&&response.data.$$_code !== -11) {
                    // mod code xuzj, add -800 check
                    if (response.data.$$_code === -800 || response.data.$$_code === -7)
                        return $q.reject(new Error(response.data.$$_code))
                    else
                        return $q.reject(new Error(response.data.$$_message));
                    // end xzj
                }
                if (response.data.$$_message && HTTP_AUTH_FAIL_MESSAGE_MATCH.test(response.data.$$_message)) {
                    return $q.reject(new Error(401));
                }
            }
            return response;
        }

        function resultUnpack(response, config) {
            var config = response.config || {};
            if (!config.isResource) {
                return response;
            }
            //error promise
            if (response.then) {
                return response;
            }
            //no unpack
            if (config._noUnpack) {
                return response;
            }
            if (_.isObject(response.data) && response.data.$$_code === 0) {
                response.data = response.data.data;
            }
            
            return response;
        }
    }

    resourceHttpInterceptor.$inject = ['$q', '_ENV','_SITE','my', 'tokenStore'];

    module.exports = angular.module(require('../module').name).factory('resourceHttpInterceptor', resourceHttpInterceptor);
});
