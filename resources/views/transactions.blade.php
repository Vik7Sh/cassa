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
                    <label class="col-sm-2 control-label" for="select_acc">Рахунок</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="select_acc" name="account_id">
                            <option style="color:darkgrey" value="null" data-idacc="0"> --Вибрати рахунок--  </option>
                            @foreach($acc as $account)
                                <option data-idacc = "{{$account->id}}" value="{{$account->id}}" @if(intval(old("account_id")) === intval($account->id)) selected @endif>{{$account->name_acc}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Транзакція</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="select_tr" name="type_transaction_id">
                            <option style="color:darkgrey" value="null" data-idtr="0"> --Вибрати транзакцію--  </option>
                            @foreach($tra as $typetr)
                                <option data-idtr="{{$typetr->id}}" value="{{$typetr->id}}" @if(intval(old("type_transaction_id")) === intval($typetr->id)) selected @endif>{{$typetr->name_tra}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Категорія</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="select_cat" name="categorie_id">
                            <option style="color:darkgrey" value="null" data-idcat="0"> --Вибрати категорію--  </option>
                            @foreach($cat as $categ)
                                <option data-account="{{$categ->account_id}}" data-type="{{$categ->type_transaction_id}}" value="{{$categ->id}}" @if(intval(old("categorie_id")) === intval($categ->id)) selected @endif>{{$categ->name_cat}}</option>
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
    {{--{{ dd($account->toArray()) }}--}}

    <script type="text/javascript">

        $('#decimal').keypress(function(evt){
            // return (/^[0-9]*\.?[0-9]*$/).test($(this).val()+evt.key);
            return (/^[+]?\d+(?:\.?\d{0,2})$/).test($(this).val()+evt.key);
        });
        // $('#decimal').keyup(function(){
        //     this.value = this.value.replace(/[^\d\.]/g,"");
        //     if(this.value.match(/\./g).length > 1) {
        //         this.value = this.value.substr(0, this.value.lastIndexOf("."));
        //     }
        // });

        $('.form-control').on('change', function() {
            var ida = $('#select_acc option:selected').attr('data-idacc'),
                idt = $('#select_tr option:selected').attr('data-idtr');
            // console.log('change acc ' + ida + ' change tr ' + idt) ;


            $('#select_acc').on('change', function () {
                $('#select_cat option:selected').each(function(){
                    this.selected=false;
                });
            });
            $('#select_tr').on('change', function () {
                $('#select_cat option:selected').each(function(){
                    this.selected=false;
                });
            });


            if ((ida === '0') || (idt === '0')){
                $('#select_cat option').hide();
            }
            if ((ida === '1') && (idt === '1')){
                $("#select_cat option").hide();
                $("#select_cat option[data-account ='1'][data-type ='1']").show();
            }
            if ((ida === '1') && (idt === '2')){
                $("#select_cat option").hide();
                $("#select_cat option[data-account ='1'][data-type ='2']").show();
            }
            if ((ida === '2') && (idt === '1')){
                $("#select_cat option").hide();
                $("#select_cat option[data-account ='2'][data-type ='1']").show();
            }
            if ((ida === '2') && (idt === '2')){
                $("#select_cat option").hide();
                $("#select_cat option[data-account ='2'][data-type ='2']").show();
            }

        });


    </script>

</body>
</html>
