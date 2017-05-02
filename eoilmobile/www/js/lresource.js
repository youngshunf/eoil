
define(function(require, exports, module) {
    "use strict";

    var JSON_START = /^\[|^\{(?!\{)/;
    var JSON_ENDS = {
        '[': /]$/,
        '{': /}$/
    };
    var isObject = angular.isObject,
        isString = angular.isString,
        isDefined = angular.isDefined,
        isFunction = angular.isFunction,
        isArray = angular.isArray,
        isUndefined = angular.isUndefined,
        toJson = angular.toJson,
        fromJson = angular.fromJson,
        forEach = angular.forEach;

    function encodeUriQuery(val, pctEncodeSpaces) {
        return encodeURIComponent(val).
            replace(/%40/gi, '@').
            replace(/%3A/gi, ':').
            replace(/%24/gi, '$').
            replace(/%2C/gi, ',').
            replace(/%20/gi, (pctEncodeSpaces ? '%20' : '+'));
    }

    function isJsonLike(str) {
        var jsonStart = str.match(JSON_START);
        return jsonStart && JSON_ENDS[jsonStart[0]].test(str);
    }

    function paramSerializeWrapper(wrapperStr, isBody) {
        return function wrapParam(params) {
            if (!params) {
                return '';
            }
            if (isObject(params) && '[object File]' !== String(params) && wrapperStr) {
                if (isBody === true) {
                    return wrapperStr + '=' + encodeURIComponent(toJson(params));
                } else {
                    return wrapperStr + '=' + encodeUriQuery(toJson(params));
                }
            }
            return params;
        }
    }

    function responseTransformWrapper(noUnpack) {
        return function transformResponse(data) {
            if (isString(data) && isJsonLike(data)) {
                data = fromJson(data);
            }
            if (isObject(data)) {
                if (data && isDefined(data.result)) {
                    data.$$_code = Number(data.result);
                    data.$$_message = String(data.desc);
                }
            }
            return data;
        }
    }

    function LocalResourceProvider() {
        var provider = this;

        var defaults = this.defaults = {
            actionConfig: {
                isResource: true,
                responseType: 'json',
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                }
            }
        };

        var mockEnable = false;

        this.mockEnable = function(enable) {
            if (isDefined(enable)) {
                mockEnable = !!enable;
                return this;
            }
            return mockEnable;
        }

        //param serializer
        function paramSerializeDecorator(config) {
            if (config.paramWrapperStr) {
                config.paramSerializer = paramSerializeWrapper(config.paramWrapperStr);
                if (config.method === 'POST' && isUndefined(config.transformRequest)) {
                    config.transformRequest = paramSerializeWrapper(config.paramWrapperStr, true);
                }
            }
            return config;
        }

        //transform response use _noUnpack
        function noUnpackTransformDecorator(config) {
            config.transformResponse = responseTransformWrapper(config._noUnpack);
            return config;
        }

        var defaultActionConfigDecorators = [paramSerializeDecorator, noUnpackTransformDecorator];

        this.$get = ['$resource', function($resource) {
            var copy = angular.copy, extend = angular.extend;
            function resourceFactory(url, paramDefaults, actions, options) {
                var config, decoratorChain, actions = copy(actions);
                if (isObject(actions)) {
                    forEach(actions, function(config, name) {
                        config = extend({}, provider.defaults.actionConfig, config);
                        if (config.decorators) {
                            decoratorChain = config.decorators;
                            if (isFunction(decoratorChain)) {
                                decoratorChain = [decoratorChain];
                            }
                        } else {
                            decoratorChain = defaultActionConfigDecorators;
                        }
                        forEach(decoratorChain, function(fn) {
                            config = fn(config);
                        });
                        actions[name] = config;
                    });
                }
                return $resource(url, paramDefaults, actions, options);
            }
            return resourceFactory;
        }];
    }

    module.exports = angular.module(require('../module').name).provider('lResource', LocalResourceProvider);
});
