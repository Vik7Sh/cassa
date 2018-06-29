<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <title>Cassa</title>
</head>
<body>
<h1 align="center">Каса!</h1>
<div class="row" align="center">
    <div class="col-md-4"></div>
    <div class="col-md-4">
        <table class="table table-striped table-bordered table-condensed">
            <thead>
            <tr>
                <th>Тип рахунка</th>
                <th>Баланс</th>
            </tr>
            </thead>
            <tbody>
            @foreach($acc as $account)
            <tr>
                <td>{{$account->name_acc}}</td>
                <td>{{$account->balance}}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-md-4"></div>
</div>
<div class="row" align="center">
    <div class="col-md-4"></div>
    <div class="col-md-4">
            <a class="btn btn-primary btn-lg" href="/cassa/create">Створити транзакцію</a>
    </div>
    <div class="col-md-4"></div>
</div><br>
<div class="row" align="center">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <table class="table table-striped table-bordered table-condensed">
            <thead>
            <tr>
                <th>№</th>
                <th>Час транзакції</th>
                <th>Категорія</th>
                <th>Тип транзакції</th>
                <th>Рахунок</th>
                <th>Сума</th>
                <th>Дія</th>
            </tr>
            </thead>
            <tbody>
            @foreach($alltrans as $alltr)
            <tr>
                <td>{{$alltr->id}}</td>
                <td>{{$alltr->created_at->format('d-m-Y')}}</td>
                <td>{{$alltr->categorie->name_cat}}</td>
                <td>{{$alltr->typetransaction->name_tra}}</td>
                <td>{{$alltr->account->name_acc}}</td>
                <td>{{$alltr->summ}}</td>
                {{--<td>{{$alltr->canceled}}</td>--}}
                @if($alltr->cancelled === 0)
                    <td>
                        <form action="/cassa/{{$alltr->id}}" method="POST">
                            {{method_field("PUT")}}
                            {{csrf_field()}}
                            <button type="submit" class="btn btn-danger btn-xs">Відмінити</button>
                        </form>
                    </td>
                @elseif($alltr->cancelled === 1)
                    <td>Відмінено {{$alltr->updated_at->format('d-m-Y')}}</td>
                @else($alltr->cancelled === 2)
                    <td>Відміна #{{$alltr->cancelled_id}} {{$alltr->updated_at->format('d-m-Y')}}</td>
                @endif
            </tr>
            @endforeach

            </tbody>
        </table>
    </div>
    <div class="col-md-1"></div>
</div>
{{--{{ dd($acc->toArray()) }}--}}
</body>
</html>