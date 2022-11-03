p:last-child {
    margin-bottom: 0;
}
blockquote small {
    color: #999999;
    display: block;
    line-height: 1.6;
}
blockquote small:before {
    content: "— ";
}
blockquote.pull-right {
    border-left: 0 none;
    border-right: 5px solid #4baad3;
    padding-left: 0;
    padding-right: 15px;
}
blockquote.pull-right p, blockquote.pull-right small {
    text-align: right;
}
blockquote.pull-right small:before {
    content: "";
}
blockquote.pull-right small:after {
    content: " —";
}
q:before, q:after, blockquote:before, blockquote:after {
    content: "";
}
address {
    display: block;
    font-style: normal;
    line-height: 1.6;
    margin-bottom: 27px;
}
code, pre {
    font-family: Monaco,Menlo,Consolas,"Courier New",monospace;
}
code {
    background-color: #f9f2f4;
    border-radius: 0;
    color: #c7254e;
    font-size: 90%;
    padding: 2px 4px;
    white-space: nowrap;
}
pre {
    background-color: #f5f5f5;
    border: 1px solid #cccccc;
    border-radius: 0;
    color: #333333;
    display: block;
    font-size: 16px;
    line-height: 1.6;
    margin: 0 0 13.5px;
    padding: 13px;
    word-break: break-all;
    word-wrap: break-word;
}
pre.prettyprint {
    margin-bottom: 27px;
}
pre code {
    background-color: transparent;
    border: 0 none;
    color: inherit;
    font-size: inherit;
    padding: 0;
    white-space: pre-wrap;
}
.pre-scrollable {
    max-height: 340px;
    overflow-y: scroll;
}
.container {
    margin-left: auto;
    margin-right: auto;
    padding-left: 10px;
    padding-right: 10px;
}
.container:before, .container:after {
    content: " ";
    display: table;
}
.container:after {
    clear: both;
}
.container:before, .container:after {
    content: " ";
    display: table;
}
.container:after {
    clear: both;
}
.row {
    margin-left: -10px;
    margin-right: -10px;
}
.row:before, .row:after {
    content: " ";
    display: table;
}
.row:after {
    clear: both;
}
.row:before, .row:after {
    content: " ";
    display: table;
}
.row:after {
    clear: both;
}
.col-xs-1, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9, .col-xs-10, .col-xs-11, .col-xs-12, .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12, .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12, .col-lg-1, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-10, .col-lg-11, .col-lg-12 {
    min-height: 1px;
    padding-left: 10px;
    padding-right: 10px;
    position: relative;
}
.col-xs-1, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9, .col-xs-10, .col-xs-11 {
    float: left;
}
.col-xs-1 {
    width: 8.33333%;
}
.col-xs-2 {
    width: 16.6667%;
}
.col-xs-3 {
    width: 25%;
}
.col-xs-4 {
    width: 33.3333%;
}
.col-xs-5 {
    width: 41.6667%;
}
.col-xs-6 {
    width: 50%;
}
.col-xs-7 {
    width: 58.3333%;
}
.col-xs-8 {
    width: 66.6667%;
}
.col-xs-9 {
    width: 75%;
}
.col-xs-10 {
    width: 83.3333%;
}
.col-xs-11 {
    width: 91.6667%;
}
.col-xs-12 {
    width: 100%;
}
@media (min-width: 768px) {
.container {
    max-width: 740px;
}
.col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11 {
    float: left;
}
.col-sm-1 {
    width: 8.33333%;
}
.col-sm-2 {
    width: 16.6667%;
}
.col-sm-3 {
    width: 25%;
}
.col-sm-4 {
    width: 33.3333%;
}
.col-sm-5 {
    width: 41.6667%;
}
.col-sm-6 {
    width: 50%;
}
.col-sm-7 {
    width: 58.3333%;
}
.col-sm-8 {
    width: 66.6667%;
}
.col-sm-9 {
    width: 75%;
}
.col-sm-10 {
    width: 83.3333%;
}
.col-sm-11 {
    width: 91.6667%;
}
.col-sm-12 {
    width: 100%;
}
.col-sm-push-1 {
    left: 8.33333%;
}
.col-sm-push-2 {
    left: 16.6667%;
}
.col-sm-push-3 {
    left: 25%;
}
.col-sm-push-4 {
    left: 33.3333%;
}
.col-sm-push-5 {
    left: 41.6667%;
}
.col-sm-push-6 {
    left: 50%;
}
.col-sm-push-7 {
    left: 58.3333%;
}
.col-sm-push-8 {
    left: 66.6667%;
}
.col-sm-push-9 {
    left: 75%;
}
.col-sm-push-10 {
    left: 83.3333%;
}
.col-sm-push-11 {
    left: 91.6667%;
}
.col-sm-pull-1 {
    right: 8.33333%;
}
.col-sm-pull-2 {
    right: 16.6667%;
}
.col-sm-pull-3 {
    right: 25%;
}
.col-sm-pull-4 {
    right: 33.3333%;
}
.col-sm-pull-5 {
    right: 41.6667%;
}
.col-sm-pull-6 {
    right: 50%;
}
.col-sm-pull-7 {
    right: 58.3333%;
}
.col-sm-pull-8 {
    right: 66.6667%;
}
.col-sm-pull-9 {
    right: 75%;
}
.col-sm-pull-10 {
    right: 83.3333%;
}
.col-sm-pull-11 {
    right: 91.6667%;
}
.col-sm-offset-1 {
    margin-left: 8.33333%;
}
.col-sm-offset-2 {
    margin-left: 16.6667%;
}
.col-sm-offset-3 {
    margin-left: 25%;
}
.col-sm-offset-4 {
    margin-left: 33.3333%;
}
.col-sm-offset-5 {
    margin-left: 41.6667%;
}
.col-sm-offset-6 {
    margin-left: 50%;
}
.col-sm-offset-7 {
    margin-left: 58.3333%;
}
.col-sm-offset-8 {
    margin-left: 66.6667%;
}
.col-sm-offset-9 {
    margin-left: 75%;
}
.col-sm-offset-10 {
    margin-left: 83.3333%;
}
.col-sm-offset-11 {
    margin-left: 91.6667%;
}
}
@media (min-width: 992px) {
.container {
    max-width: 960px;
}
.col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11 {
    float: left;
}
.col-md-1 {
    width: 8.33333%;
}
.col-md-2 {
    width: 16.6667%;
}
.col-md-3 {
    width: 25%;
}
.col-md-4 {
    width: 33.3333%;
}
.col-md-5 {
    width: 41.6667%;
}
.col-md-6 {
    width: 50%;
}
.col-md-7 {
    width: 58.3333%;
}
.col-md-8 {
    width: 66.6667%;
}
.col-md-9 {
    width: 75%;
}
.col-md-10 {
    width: 83.3333%;
}
.col-md-11 {
    width: 91.6667%;
}
.col-md-12 {
    width: 100%;
}
.col-md-push-0 {
    left: auto;
}
.col-md-push-1 {
    left: 8.33333%;
}
.col-md-push-2 {
    left: 16.6667%;
}
.col-md-push-3 {
    left: 25%;
}
.col-md-push-4 {
    left: 33.3333%;
}
.col-md-push-5 {
    left: 41.6667%;
}
.col-md-push-6 {
    left: 50%;
}
.col-md-push-7 {
    left: 58.3333%;
}
.col-md-push-8 {
    left: 66.6667%;
}
.col-md-push-9 {
    left: 75%;
}
.col-md-push-10 {
    left: 83.3333%;
}
.col-md-push-11 {
    left: 91.6667%;
}
.col-md-pull-0 {
    right: auto;
}
.col-md-pull-1 {
    right: 8.33333%;
}
.col-md-pull-2 {
    right: 16.6667%;
}
.col-md-pull-3 {
    right: 25%;
}
.col-md-pull-4 {
    right: 33.3333%;
}
.col-md-pull-5 {
    right: 41.6667%;
}
.col-md-pull-6 {
    right: 50%;
}
.col-md-pull-7 {
    right: 58.3333%;
}
.col-md-pull-8 {
    right: 66.6667%;
}
.col-md-pull-9 {
    right: 75%;
}
.col-md-pull-10 {
    right: 83.3333%;
}
.col-md-pull-11 {
    right: 91.6667%;
}
.col-md-offset-0 {
    margin-left: 0;
}
.col-md-offset-1 {
    margin-left: 8.33333%;
}
.col-md-offset-2 {
    margin-left: 16.6667%;
}
.col-md-offset-3 {
    margin-left: 25%;
}
.col-md-offset-4 {
    margin-left: 33.3333%;
}
.col-md-offset-5 {
    margin-left: 41.6667%;
}
.col-md-offset-6 {
    margin-left: 50%;
}
.col-md-offset-7 {
    margin-left: 58.3333%;
}
.col-md-offset-8 {
    margin-left: 66.6667%;
}
.col-md-offset-9 {
    margin-left: 75%;
}
.col-md-offset-10 {
    margin-left: 83.3333%;
}
.col-md-offset-11 {
    margin-left: 91.6667%;
}
}
@media (min-width: 1200px) {
.container {
    max-width: 1160px;
}
.col-lg-1, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-10, .col-lg-11 {
    float: left;
}
.col-lg-1 {
    width: 8.33333%;
}
.col-lg-2 {
    width: 16.6667%;
}
.col-lg-3 {
    width: 25%;
}
.col-lg-4 {
    width: 33.3333%;
}
.col-lg-5 {
    width: 41.6667%;
}
.col-lg-6 {
    width: 50%;
}
.col-lg-7 {
    width: 58.3333%;
}
.col-lg-8 {
    width: 66.6667%;
}
.col-lg-9 {
    width: 75%;
}
.col-lg-10 {
    width: 83.3333%;
}
.col-lg-11 {
    width: 91.6667%;
}
.col-lg-12 {
    width: 100%;
}
.col-lg-push-0 {
    left: auto;
}
.col-lg-push-1 {
    left: 8.33333%;
}
.col-lg-push-2 {
    left: 16.6667%;
}
.col-lg-push-3 {
    left: 25%;
}
.col-lg-push-4 {
    left: 33.3333%;
}
.col-lg-push-5 {
    left: 41.6667%;
}
.col-lg-push-6 {
    left: 50%;
}
.col-lg-push-7 {
    left: 58.3333%;
}
.col-lg-push-8 {
    left: 66.6667%;
}
.col-lg-push-9 {
    left: 75%;
}
.col-lg-push-10 {
    left: 83.3333%;
}
.col-lg-push-11 {
    left: 91.6667%;
}
.col-lg-pull-0 {
    right: auto;
}
.col-lg-pull-1 {
    right: 8.33333%;
}
.col-lg-pull-2 {
    right: 16.6667%;
}
.col-lg-pull-3 {
    right: 25%;
}
.col-lg-pull-4 {
    right: 33.3333%;
}
.col-lg-pull-5 {
    right: 41.6667%;
}
.col-lg-pull-6 {
    right: 50%;
}
.col-lg-pull-7 {
    right: 58.3333%;
}
.col-lg-pull-8 {
    right: 66.6667%;
}
.col-lg-pull-9 {
    right: 75%;
}
.col-lg-pull-10 {
    right: 83.3333%;
}
.col-lg-pull-11 {
    right: 91.6667%;
}
.col-lg-offset-0 {
    margin-left: 0;
}
.col-lg-offset-1 {
    margin-left: 8.33333%;
}
.col-lg-offset-2 {
    margin-left: 16.6667%;
}
.col-lg-offset-3 {
    margin-left: 25%;
}
.col-lg-offset-4 {
    margin-left: 33.3333%;
}
.col-lg-offset-5 {
    margin-left: 41.6667%;
}
.col-lg-offset-6 {
    margin-left: 50%;
}
.col-lg-offset-7 {
    margin-left: 58.3333%;
}
.col-lg-offset-8 {
    margin-left: 66.6667%;
}
.col-lg-offset-9 {
    margin-left: 75%;
}
.col-lg-offset-10 {
    margin-left: 83.3333%;
}
.col-lg-offset-11 {
    margin-left: 91.6667%;
}
}
table {
    background-color: transparent;
    max-width: 100%;
}
th {
    text-align: left;
}
.table {
    margin-bottom: 27px;
    width: 100%;
}
.table thead > tr > th, .table tbody > tr > th, .table tfoot > tr > th, .table thead > tr > td, .table tbody > tr > td, .table tfoot > tr > td {
    border-top: 1px solid #dddddd;
    line-height: 1.6;
    padding: 8px;
    vertical-align: top;
}
.table thead > tr > th {
    border-bottom: 2px solid #dddddd;
    vertical-align: bottom;
}
.table caption + thead tr:first-child th, .table colgroup + thead tr:first-child th, .table thead:first-child tr:first-child th, .table caption + thead tr:first-child td, .table colgroup + thead tr:first-child td, .table thead:first-child tr:first-child td {
    border-top: 0 none;
}
.table tbody + tbody {
    border-top: 2px solid #dddddd;
}
.table .table {
    background-color: #ffffff;
}
.table-condensed thead > tr > th, .table-condensed tbody > tr > th, .table-condensed tfoot > tr > th, .table-condensed thead > tr > td, .table-condensed tbody > tr > td, .table-condensed tfoot > tr > td {
    padding: 5px;
}
.table-bordered {
    border: 1px solid #dddddd;
}
.table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td {
    border: 1px solid #dddddd;
}
.table-bordered > thead > tr > th, .table-bordered > thead > tr > td {
    border-bottom-width: 2px;
}
.table-striped > tbody > tr:nth-child(2n+1) > td, .table-striped > tbody > tr:nth-child(2n+1) > th {
    background-color: #f9f9f9;
}
.table-hover > tbody > tr:hover > td, .table-hover > tbody > tr:hover > th {
    background-color: #f5f5f5;
}
table col[class*="col-"] {
    display: table-column;
    float: none;
}
table td[class*="col-"], table th[class*="col-"] {
    display: table-cell;
    float: none;
}
.table > thead > tr > td.active, .table > tbody > tr > td.active, .table > tfoot > tr > td.active, .table > thead > tr > th.active, .table > tbody > tr > th.active, .table > tfoot > tr > th.active, .table > thead > tr.active > td, .table > tbody > tr.active > td, .table > tfoot > tr.active > td, .table > thead > tr.active > th, .table > tbody > tr.active > th, .table > tfoot > tr.active > th {
    background-color: #f5f5f5;
}
.table > thead > tr > td.success, .table > tbody > tr > td.success, .table > tfoot > tr > td.success, .table > thead > tr > th.success, .table > tbody > tr > th.success, .table > tfoot > tr > th.success, .table > thead > tr.success > td, .table > tbody > tr.success > td, .table > tfoot > tr.success > td, .table > thead > tr.success > th, .table > tbody > tr.success > th, .table > tfoot > tr.success > th {
    background-color: #c6f1d3;
    border-color: #c6f1d3;
}
.table-hover > tbody > tr > td.success:hover, .table-hover > tbody > tr > th.success:hover, .table-hover > tbody > tr.success:hover > td {
    background-color: #b1ecc3;
    border-color: #b1ecc3;
}
.table > thead > tr > td.danger, .table > tbody > tr > td.danger, .table > tfoot > tr > td.danger, .table > thead > tr > th.danger, .table > tbody > tr > th.danger, .table > tfoot > tr > th.danger, .table > thead > tr.danger > td, .table > tbody > tr.danger > td, .table > tfoot > tr.danger > td, .table > thead > tr.danger > th, .table > tbody > tr.danger > th, .table > tfoot > tr.danger > th {
    background-color: #f1d3c6;
    border-color: #f1d3c6;
}
.table-hover > tbody > tr > td.danger:hover, .table-hover > tbody > tr > th.danger:hover, .table-hover > tbody > tr.danger:hover > td {
    background-color: #ecc3b1;
    border-color: #ecc3b1;
}
.table > thead > tr > td.warning, .table > tbody > tr > td.warning, .table > tfoot > tr > td.warning, .table > thead > tr > th.warning, .table > tbody > tr > th.warning, .table > tfoot > tr > th.warning, .table > thead > tr.warning > td, .table > tbody > tr.warning > td, .table > tfoot > tr.warning > td, .table > thead > tr.warning > th, .table > tbody > tr.warning > th, .table > tfoot > tr.warning > th {
    background-color: #f1e8c6;
    border-color: #f1e8c6;
}
.table-hover > tbody > tr > td.warning:hover, .table-hover > tbody > tr > th.warning:hover, .table-hover > tbody > tr.warning:hover > td {
    background-color: #ece0b1;
    border-color: #ece0b1;
}
@media (max-width: 768px) {
.table-responsive {
    border: 1px solid #dddddd;
    margin-bottom: 15px;
    overflow-x: scroll;
    overflow-y: hidden;
    width: 100%;
}
.table-responsive > .table {
    background-color: #fff;
    margin-bottom: 0;
}
.table-responsive > .table > thead > tr > th, .table-responsive > .table > tbody > tr > th, .table-responsive > .table > tfoot > tr > th, .table-responsive > .table > thead > tr > td, .table-responsive > .table > tbody > tr > td, .table-responsive > .table > tfoot > tr > td {
    white-space: nowrap;
}
.table-responsive > .table-bordered {
    border: 0 none;
}
.table-responsive > .table-bordered > thead > tr > th:first-child, .table-responsive > .table-bordered > tbody > tr > th:first-child, .table-responsive > .table-bordered > tfoot > tr > th:first-child, .table-responsive > .table-bordered > thead > tr > td:first-child, .table-responsive > .table-bordered > tbody > tr > td:first-child, .table-responsive > .table-bordered > tfoot > tr > td:first-child {
    border-left: 0 none;
}
.table-responsive > .table-bordered > thead > tr > th:last-child, .table-responsive > .table-bordered > tbody > tr > th:last-child, .table-responsive > .table-bordered > tfoot > tr > th:last-child, .table-responsive > .table-bordered > thead > tr > td:last-child, .table-responsive > .table-bordered > tbody > tr > td:last-child, .table-responsive > .table-bordered > tfoot > tr > td:last-child {
    border-right: 0 none;
}
.table-responsive > .table-bordered > thead > tr:last-child > th, .table-responsive > .table-bordered > tbody > tr:last-child > th, .table-responsive > .table-bordered > tfoot > tr:last-child > th, .table-responsive > .table-bordered > thead > tr:last-child > td, .table-responsive > .table-bordered > tbody > tr:last-child > td, .table-responsive > .table-bordered > tfoot > tr:last-child > td {
    border-bottom: 0 none;
}
}
fieldset {
    border: 0 none;
    margin: 0;
    padding: 0;
}
legend {

    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    border-color: -moz-use-text-color -moz-use-text-color #e5e5e5;
    border-image: none;
    border-style: none none solid;
    border-width: 0 0 1px;
    color: #333333;
    display: block;
    font-size: 25.5px;
    line-height: inherit;
    margin-bottom: 27px;
    padding: 0;
    width: 100%;
}
label {
    display: inline-block;
    font-weight: bold;
    margin-bottom: 5px;
}
input[type="search"] {
    box-sizing: border-box;
}
input[type="radio"], input[type="checkbox"] {
    line-height: normal;
    margin: 4px 0 0;
}
input[type="file"] {
    display: block;
}
select[multiple], select[size] {
    height: auto;
}
select optgroup {
    font-family: inherit;
    font-size: inherit;
    font-style: inherit;
}
input[type="file"]:focus, input[type="radio"]:focus, input[type="checkbox"]:focus {
    outline: thin dotted #333;
    outline-offset: -2px;
}
.form-control:-moz-placeholder {
    color: #999999;
}
.form-control::-moz-placeholder {
    color: #999999;
}
.form-control {
    background-color: #ffffff;
    border: 1px solid #cccccc;
    border-radius: 0;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
    color: #555555;
    display: block;
    font-size: 17px;
    height: 49px;
    line-height: 1.6;
    padding: 10px 12px;
    transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
    vertical-align: middle;
    width: 100%;
}
.form-control:focus {
    border-color: #66afe9;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset, 0 0 8px rgba(102, 175, 233, 0.6);
    outline: 0 none;
}
.form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
    background-color: #eeeeee;
    cursor: not-allowed;
}
textarea.form-control {
    height: auto;
}
.form-group {
    margin-bottom: 15px;
}
.radio, .checkbox {
    display: block;
    margin-bottom: 10px;
    margin-top: 10px;
    min-height: 27px;
    padding-left: 20px;
    vertical-align: middle;
}
.radio label, .checkbox label {
    cursor: pointer;
    display: inline;
    font-weight: normal;
    margin-bottom: 0;
}
.radio input[type="radio"], .radio-inline input[type="radio"], .checkbox input[type="checkbox"], .checkbox-inline input[type="checkbox"] {
    float: left;
    margin-left: -20px;
}
.radio + .radio, .checkbox + .checkbox {
    margin-top: -5px;
}
.radio-inline, .checkbox-inline {
    cursor: pointer;
    display: inline-block;
    font-weight: normal;
    margin-bottom: 0;
    padding-left: 20px;
    vertical-align: middle;
}
.radio-inline + .radio-inline, .checkbox-inline + .checkbox-inline {
    margin-left: 10px;
    margin-top: 0;
}
input[type="radio"][disabled], input[type="checkbox"][disabled], .radio[disabled], .radio-inline[disabled], .checkbox[disabled], .checkbox-inline[disabled], fieldset[disabled] input[type="radio"], fieldset[disabled] input[type="checkbox"], fieldset[disabled] .radio, fieldset[disabled] .radio-inline, fieldset[disabled] .checkbox, fieldset[disabled] .checkbox-inline {
    cursor: not-allowed;
}
.input-sm {
    border-radius: 0;
    font-size: 15px;
    height: 34px;
    line-height: 1.5;
    padding: 5px 10px;
}
select.input-sm {
    height: 34px;
    line-height: 34px;
}
textarea.input-sm {
    height: auto;
}
.input-lg {
    border-radius: 0;
    font-size: 22px;
    height: 51px;
    line-height: 1.33;
    padding: 10px 16px;
}
select.input-lg {
    height: 51px;
    line-height: 51px;
}
textarea.input-lg {
  