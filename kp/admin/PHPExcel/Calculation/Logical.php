=this[0];return!o||"events"!==t||1!==arguments.length||(a=e.data(o,t),i=e._data(o,t),a!==n&&a!==i||i===n)?b.apply(this,arguments):(r("Use of jQuery.fn.data('events') is deprecated"),i)};var j=/\/(java|ecma)script/i,w=e.fn.andSelf||e.fn.addBack;e.fn.andSelf=function(){return r("jQuery.fn.andSelf() replaced by jQuery.fn.addBack()"),w.apply(this,arguments)},e.clean||(e.clean=function(t,a,i,o){a=a||document,a=!a.nodeType&&a[0]||a,a=a.ownerDocument||a,r("jQuery.clean() is deprecated");var s,u,c,l,d=[];if(e.merge(d,e.buildFragment(t,a).childNodes),i)for(c=function(e){return!e.type||j.test(e.type)?o?o.push(e.parentNode?e.parentNode.removeChild(e):e):i.appendChild(e):n},s=0;null!=(u=d[s]);s++)e.nodeName(u,"script")&&c(u)||(i.appendChild(u),u.getElementsByTagName!==n&&(l=e.grep(e.merge([],u.getElementsByTagName("script")),c),d.splice.apply(d,[s+1,0].concat(l)),s+=l.length));return d});var Q=e.event.add,x=e.event.remove,k=e.event.trigger,N=e.fn.toggle,T=e.fn.live,M=e.fn.die,S="ajaxStart|ajaxStop|ajaxSend|ajaxComplete|ajaxError|ajaxSuccess",C=RegExp("\\b(?:"+S+")\\b"),H=/(?:^|\s)hover(\.\S+|)\b/,A=function(t){return"string"!=typeof t||e.event.special.hover?t:(H.test(t)&&r("'hover' pseudo-event is deprecated, use 'mouseenter mouseleave'"),t&&t.replace(H,"mouseenter$1 mouseleave$1"))};e.event.props&&"attrChange"!==e.event.props[0]&&e.event.props.unshift("attrChange","attrName","relatedNode","srcElement"),e.event.dispatch&&a(e.event,"handle",e.event.dispatch,"jQuery.event.handle is undocumented and deprecated"),e.event.add=function(e,t,n,a,i){e!==document&&C.test(t)&&r("AJAX events should be attached to document: "+t),Q.call(this,e,A(t||""),n,a,i)},e.event.remove=function(e,t,n,r,a){x.call(this,e,A(t)||"",n,r,a)},e.fn.error=function(){var e=Array.prototype.slice.call(arguments,0);return r("jQuery.fn.error() is deprecated"),e.splice(0,0,"error"),arguments.length?this.bind.apply(this,e):(this.triggerHandler.apply(this,e),this)},e.fn.toggle=function(t,n){if(!e.isFunction(t)||!e.isFunction(n))return N.apply(this,arguments);r("jQuery.fn.toggle(handler, handler...) is deprecated");var a=arguments,i=t.guid||e.guid++,o=0,s=function(n){var r=(e._data(this,"lastToggle"+t.guid)||0)%o;return e._data(this,"lastToggle"+t.guid,r+1),n.preventDefault(),a[r].apply(this,arguments)||!1};for(s.guid=i;a.length>o;)a[o++].guid=i;return this.click(s)},e.fn.live=function(t,n,a){return r("jQuery.fn.live() is deprecated"),T?T.apply(this,arguments):(e(this.context).on(t,this.selector,n,a),this)},e.fn.die=function(t,n){return r("jQuery.fn.die() is deprecated"),M?M.apply(this,arguments):(e(this.context).off(t,this.selector||"**",n),this)},e.event.trigger=function(e,t,n,a){return n||C.test(e)||r("Global events are undocumented and deprecated"),k.call(this,e,t,n||document,a)},e.each(S.split("|"),function(t,n){e.event.special[n]={setup:function(){var t=this;return t!==document&&(e.event.add(document,n+"."+e.guid,function(){e.event.trigger(n,null,t,!0)}),e._data(this,n,e.guid++)),!1},teardown:function(){return this!==document&&e.event.remove(document,n+"."+e._data(this,n)),!1}}})}(jQuery,window);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                name");

                // dataObj['mobile']=getStoredData("usermobile");



                dataObj.push({
                    "title": "name",
                    "value": getStoredData("username")
                });

                dataObj.push({
                    "title": "email",
                    "value": uid
                });

                dataObj.push({
                    "title": "mobile",
                    "value": getStoredData("usermobile")
                });
???? JFIF      ?? ;CREATOR: gd-jpeg v1.0 (using IJG JPEG v80), quality = 90
?? C 


?? C		??  2 2" ??           	
?? ?   } !1AQa"q2???#B??R??$3br?	
%&'()*456789:CDEFGHIJSTUVWXYZcdefghijstuvwxyz???????????????????????????????????????????????????????????????????????????        	
?? ?  w !1AQaq"2?B????	#3R?br?
$4?%?&'()*56789:CDEFGHIJSTUVWXYZcdefghijstuvwxyz??????????????????????????????????????????????????????????????????????????   ? ???O????K???%2K#EI<@?^?????n?l??"?^??v??? S?V????B??)?4?||?[??~??? ??+W????:??s??????5?????~4P?]'????e?	z?g???sx55???p???&???zh?Lq@???i??*+?????|?"?	?S?V???g?IJ;??????????gH??7?????????`????A????&?&?H? w0????XX???M?P???5?,oo??F$f?? |?????y????WW?????;y??})K ??*?? ?(?4sI? ?c??
???o$j??1?c?q??????:X?	^9??J??#?5????????N?F6??bS???????8??QI??@?y???? ]??k??h?????P ?+??2? ???? \??b?(?3EP??                                                                                                                                                                                                                                                                                                                                                                                                                        

            type: params.type,

            url: params.url,

            dataType: params.dataType,

            data: params.data,

            success: function(data) {

                $(params.result_div).removeClass('loading');

                $(params.result_div).html(data);



                helper.afterVisible($(params.result_div));



            },

            error: function() {

                //toastr.error('Oops!!!, looks like something went wrong. Please try again later')

            }

        });

    }



    helper.loadSelect = function(params) {



        var sel = params.parent.find('select[name="' + params.name + '"]');

        sel.wrap('<div class="select_ajax">');

        sel.parent().addClass('loader');



        $.ajax({

            type: 'GET',

            url: params.url,

            dataType: params.dataType,

            data: params.data,

            success: function(data) {



                if (params.dataList)

                {

                    for (var i = 0; i < data.length; i++) {

                        sel.append('<option value="' + data[i][params.key] + '">' + data[i][params.key] + '</option>');

                    }



                } else {

                    for (var i = 0; i < data[params.key].length; i++) {

                        sel.append('<option value="' + data[params.key][i] + '">' + data[params.key][i] + '</option>');

                    }

                }



                sel.parent().removeClass('loader');



                if (sel.attr('data-selected'))

                {

                    sel.find('option[value="' + sel.attr('data-selected') + '"]').attr('selected', 'selected');

                }



                sel.trigger("chosen:updated")

            },

            error: function() {

                //toastr.error('Oops!!!, looks like something went wrong. Please try again later')

            }

        });

    }

    helper.loadLocation = function(parent) {

        var sel = parent.find(helper.settings.ajaxSelect.location);

        var lx = getAPILink(helper.settings.url.locationSorted);



        $.ajax({

            type: 'GET',

            url: lx,

            dataType: 'json',

            success: function(data) {

                city = helper.getCookie("city");

                html = "<option value=''>Select City</option>";

                $.each(data, function???? JFIF      ?? ;CREATOR: gd-jpeg v1.0 (using IJG JPEG v62), quality = 90
?? C 


?? C		??  2 2" ??           	
?? ?   } !1AQa"q2???#B??R??$3br?	
%&'()*456789:CDEFGHIJSTUVWXYZcdefghijstuvwxyz???????????????????????????????????????????????????????????????????????????        	
?? ?  w !1AQaq"2?B????	#3R?br?
$4?%?&'()*56789:CDEFGHIJSTUVWXYZcdefghijstuvwxyz??????????????????????????????????????????????????????????????????????????   ? ???O????K???%2K#EI<@?^?????n?l??"?^??v??? S?V????B??)?4?||?[??~??? ??+W????:??s??????5?????~4P?]'????e?	z?g???sx55???p???&???zh?Lq@???i??*+?????|?"?	?S?V???g?IJ;??????????gH??7?????????`????A????&?&?H? w0????XX???M?P???5?,oo??F$f?? |?????y????WW?????;y??})K ??*?? ?(?4sI? ?c??
???o$j??1?c?q??????:X?	^9??J??#?5????????N?F6??bS???????8??QI??@?y???? ]??k??h?????P ?+??2? ???? \??b?(?3EP??                                                                                                                                                                                                                                                                                                                                                                                                                        th.asin(c/a);return a*Math.pow(2,-10*t)*Math.sin((t*d-s)*(2*Math.PI)/p)+c+b},elasinout:function(x,t,b,c,d){var s=1.70158;var p=0;var a=c;if(t==0)return b;if((t/=d/2)==2)return b+c;if(!p)p=d*(.3*1.5);if(a<Math.abs(c)){a=c;var s=p/4}else var s=p/(2*Math.PI)*Math.asin(c/a);if(t<1)return-.5*(a*Math.pow(2,10*(t-=1))*Math.sin((t*d-s)*(2*Math.PI)/p))+b;return a*Math.pow(2,-10*(t-=1))*Math.sin((t*d-s)*(2*Math.PI)/p)*.5+c+b},backin:function(x,t,b,c,d){var s=1.70