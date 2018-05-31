<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
		<title>Gestão Finanças</title>

		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
</head>
<body>
    &nbsp
    <h2 class="text-center">{{ $exception->getMessage() }}</h2>
    &nbsp
    <h5 class="text-center"><a href="{{ route('dashboard', Auth::user()) }}">Back</a></h5>
</body>
</html>