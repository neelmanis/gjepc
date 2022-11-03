

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>jQuery allow only numbers or numeric characters in textbox</title>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script type="text/javascript">
$(function () {
$('#txtNumeric').keydown(function (e) {
if (e.shiftKey || e.ctrlKey || e.altKey) {
e.preventDefault();
} else {
var key = e.keyCode;
if (!((key == 8) || (key == 46) || (key >= 35 && key <= 40) || (key >= 48 && key <= 57) || (key >= 96 && key <= 105))) {
e.preventDefault();
}
}
});
});
</script>
</head>
<body>
<div>
<input type="text" id="txtNumeric" />
</div>
</body>
</html>