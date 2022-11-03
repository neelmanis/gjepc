/*
 * JavaScript MD5 Demo JS
 * https://github.com/blueimp/JavaScript-MD5
 *
 * Copyright 2013, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

/*global document, md5 */

;(function () {
  'use strict'

  var input = document.getElementById('input')
  document.getElementById('input').addEventListener(
    'blur',
    function (event) {
      event.preventDefault()
      document.getElementById('result').value = md5(input.value)
    }
  )
}())

function runScript(e) {
    if (e.keyCode == 13) {
        document.getElementById('result').value = md5(input.value)
    }
}