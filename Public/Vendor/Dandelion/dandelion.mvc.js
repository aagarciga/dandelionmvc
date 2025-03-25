/* 
 * Copyright (C) 2014 Alex
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

(function (global) {
    "use strict";

    // Dandelion MVC Namespace
    var dandelion = global.dandelion,
        document = global.document,
        mvc = dandelion.namespace('mvc');

        
    mvc.redirect = function (controller, action, data, method) {
        /**
         * Alex:
         * Para que esto funcione para todos los navegadores es necesario que el
         * formulario que se cree tenga un boton de submit, de lo contrario 
         * solo trabajara para Chrome y no para Firefox. hay que probar para IE
         */

        if (!type) {
            method = 'GET';
        }

        if (method === 'POST') {

            var _form = document.createElement('form'),
                _formAction = 'index.php?',
                key;

            if (controller === undefined) {
                throw new Error("Controller is required");
            }
            _formAction += 'controller=' + controller;

            if (action === undefined) {
                action = 'index';
            }

            _formAction += '&action=' + action;

            _form.action = _formAction;
            _form.method = method;

            if (typeof data === "object" && data) {
                for (key in data) {
                    var _inputHidden = document.createElement('input');
                    _inputHidden.type = 'hidden';
                    _inputHidden.name = key.toString();
                    _inputHidden.value = data[key];
                    _form.appendChild(_inputHidden);
                }
            }
            _form.submit();
        } else {
            var location = 'index.php?', key;
            location += 'controller=' + controller;
            location += '&action=' + action;
            if (typeof data === "object" && data) {
                for(key in data){
                    location += '&' + key + '=' + data[key];
                }
            }
            global.location = location;
        }
    };

}(window));


