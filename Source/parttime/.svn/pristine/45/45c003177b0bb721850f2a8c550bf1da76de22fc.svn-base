<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Demo</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
</head>
<body>
<script>
$(document).ready(function() {
    var data = {};
    var baseUri = 'https://api.aweber.com/1.0';
    $.ajax({
        url: baseUri + "/accounts?accessToken=Ag9OGz32cbWgY2gR1J1XyOwE&tokenSecret=taWZFmoDmmKM7DsHsDaKQeJgcPhlfyB0rgZbuyqS",
	type: "GET",
        contentType: "application/json",
        accepts: "application/json",
        cache: false,
        dataType: 'json',
        data: JSON.stringify(data),
    }).then(function(data) {
        console.log(data);
    });
});	
</script>
</body>
</html>
