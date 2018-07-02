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

    <title>Transactions</title>

</head>
<body>
    <h1 align="center">Створення транзакції!</h1>
    @if(session()->has('error'))
    <div class="row">
        <div class="alert alert-danger col-md-6 col-md-offset-3" role="alert">{{ session()->get('error') }}</div>
    </div>
    @endif

    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <form class="form-horizontal" action="/cassa" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="select_account">Рахунок</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="select_account" name="account_id">
                            <option style="color:darkgrey" value="null" data-id-account="0"> --Вибрати рахунок--  </option>
                            @foreach($accounts as $account)
                                <option data-id-account = "{{$account->id}}" value="{{$account->id}}" @if(intval(old("account_id")) === intval($account->id)) selected @endif>{{$account->name_account}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Транзакція</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="select_transaction" name="type_transaction_id">
                            <option style="color:darkgrey" value="null" data-id-transaction="0"> --Вибрати транзакцію--  </option>
                            @foreach($transactions as $typeTransaction)
                                <option data-id-transaction="{{$typeTransaction->id}}" value="{{$typeTransaction->id}}" @if(intval(old("type_transaction_id")) === intval($typeTransaction->id)) selected @endif>{{$typeTransaction->name_transaction}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Категорія</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="select_category" name="category_id">
                            <option style="color:darkgrey" value="null" data-id-category="0"> --Вибрати категорію--  </option>
                            @foreach($categories as $category)
                                <option data-account="{{$category->account_id}}" data-type="{{$category->type_transaction_id}}" value="{{$category->id}}" @if(intval(old("category_id")) === intval($category->id)) selected @endif>{{$category->name_category}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Сума</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="decimal" name="summ" @if(old('summ')) value="{{ old('summ') }}" @endif>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default">Підтвердити</button>
                    </div>
                </div>
            </form>

        </div>
        <div class="col-md-3"></div>
    </div>

    <script type="text/javascript">

        $('#decimal').keypress(function(evt){
            return (/^[+]?\d+(?:\.?\d{0,2})$/).test($(this).val()+evt.key);
        });

        $('.form-control').on('change', function() {
            var ida = $('#select_account option:selected').attr('data-id-account'),
                idt = $('#select_transaction option:selected').attr('data-id-transaction');

            $('#select_account').on('change', function () {
                $('#select_category option:selected').each(function(){
                    this.selected=false;
                });
            });
            $('#select_transaction').on('change', function () {
                $('#select_category option:selected').each(function(){
                    this.selected=false;
                });
            });


            if ((ida === '0') || (idt === '0')){
                $('#select_category option').hide();
            }
            if ((ida === '1') && (idt === '1')){
                $("#select_category option").hide();
                $("#select_category option[data-account ='1'][data-type ='1']").show();
            }
            if ((ida === '1') && (idt === '2')){
                $("#select_category option").hide();
                $("#select_category option[data-account ='1'][data-type ='2']").show();
            }
            if ((ida === '2') && (idt === '1')){
                $("#select_category option").hide();
                $("#select_category option[data-account ='2'][data-type ='1']").show();
            }
            if ((ida === '2') && (idt === '2')){
                $("#select_category option").hide();
                $("#select_category option[data-account ='2'][data-type ='2']").show();
            }

        });


    </script>

</body>
</html>
