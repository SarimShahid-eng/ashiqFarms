<html>
    <head>
        <title>Expense Report</title>
        {{-- <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}"> --}}

        <style>
            *{font-family: sans-serif}
            @media print{
                .print{display: none!important;}
                .hide_row{display:none!important;}
            }
            .display_style{
                display:none;
            }
            .acres,.material,.quantity,.unit_rate,.total,.note{max-width: 80px}

            table{position: relative;}
            .fixed_heads{position: sticky; top: 0; background-color: #fff; z-index: 9;}
            .fixed_head thead{position: sticky; top: 0px}
            
            
            /* Chrome, Safari, Edge, Opera */
            input[type=number]::-webkit-outer-spin-button,
            input[type=number]::-webkit-inner-spin-button {
              -webkit-appearance: none;
              margin: 0;
            }
            
            /* Firefox */
            input[type=number] {
              -moz-appearance: textfield;
            }

        </style>
    </head>
 <body>
     <div class="containers">
         <h2 style="text-align: center; color: green">{{ @$report }}</h2>
         <fieldset style="margin-bottom: 20px">
             <legend>Report Filters</legend>
             <p style="margin: 5px 0; padding-left: 20px;"><strong>Heads : </strong>{{ @$head->head_name }}    <strong>SubHead : </strong>{{ @$subhead }} <strong>Date : </strong>{{ get_date($from_date) }} <strong> To </strong> {{ get_date($to_date) }}</p>
         </fieldset>

         <table style="border:1px solid black; margin-top:10px;"  class="display_style fixed_heads" id="colorBar">
             <tr style="background-color: #fff;">
                 <td style="background-color: #fff;"><button color="#00FF00" style="background-color:#00FF00; width:20px; height:20px" class="get_color"></button></td>
                 <td style="background-color: #fff;"><button color="#FF0000" style="background-color:#FF0000; width:20px; height:20px" class="get_color"></button></td>
                 <td style="background-color: #fff;"><button color="#CCFF00" style="background-color:#CCFF00; width:20px; height:20px" class="get_color"></button></td>
                 <td style="background-color: #fff;"><button color="#FF9900" style="background-color:#FF9900; width:20px; height:20px" class="get_color"></button></td>
                 <td style="background-color: #fff;"><button color="#0099FF" style="background-color:#0099FF; width:20px; height:20px" class="get_color"></button></td>
                 <td style="background-color: #fff;"><button color="#fbfbfb" style="background-color:#fbfbfb; width:20px; height:20px" class="get_color"></button></td>
                 <td style="background-color: #fff;"><button color="#E20C0C" style="background-color:#E20C0C; width:20px; height:20px" class="get_color"></button></td>
                 <td style="background-color: #fff;"><button color="#EC4A4A" style="background-color:#EC4A4A; width:20px; height:20px" class="get_color"></button></td>
                 <td style="background-color: #fff;"><button color="#F60000" style="background-color:#F60000; width:20px; height:20px" class="get_color"></button></td>
                 <td style="background-color: #fff;"><button color="#34F934" style="background-color:#34F934; width:20px; height:20px" class="get_color"></button></td>
                 <td style="background-color: #fff;"><button color="#47D910" style="background-color:#47D910; width:20px; height:20px" class="get_color"></button></td>
                 <td style="background-color: #fff;"><button color="#33AD05" style="background-color:#33AD05; width:20px; height:20px" class="get_color"></button></td>
                 <td style="background-color: #fff;"><button color="#0B78AF" style="background-color:#0B78AF; width:20px; height:20px" class="get_color"></button></td>
                 <td style="background-color: #fff;"><button color="#136791" style="background-color:#136791; width:20px; height:20px" class="get_color"></button></td>
                 <td style="background-color: #fff;"><button color="#22B4FD" style="background-color:#22B4FD; width:20px; height:20px" class="get_color"></button></td>

                 <td style="background-color: #fff;"></td>
                 <td style="background-color: #fff;"><a href="javascript:void(0)" id="removeColorBar">X</a></td>
             </tr>
         </table>

        <div class="fixed_head">
            @if(Auth::User()->type == 'company')
            <button id="move_button" class="hide_row"  style="margin-bottom: 10px; padding: 10px 15px; font-size: 15px; font-weight: bold; background: #394eea; border: 0; color: #fff; float: right; border-radius: .25rem;box-shadow: 0 2px 6px #acb5f6;background-color: #6777ef; border-color: #6777ef;">Move</button>
            @endif
            <table style="border-color: #000;border-collapse: collapse; width: 100%;" cellpadding="5" border="1px">
                <thead style="background-color: #B0C4DE;border-color: #000">
                   <th style="border-color: #000">#</th>
                   <th style="border-color: #000">Expense Date</th>
                   <th style="border-color: #000">Head & Sub.Head & Child Subhead</th>
                   <th style="border-color: #000">Work</th>
                   <th style="border-color: #000">Acres</th>
                   <th style="border-color: #000">Material</th>
                   <th style="border-color: #000">Qty</th>
                   <th style="border-color: #000">Rate</th>
                   <th style="border-color: #000">Total</th>
                   <th style="border-color: #000">Type</th>
                   <th style="border-color: #000">Note</th>
                    @if(Auth::user()->type == 'company')
                    <th style="border-color: #000" class="hide_row">Added By</th>
                    @endif
                   @if(isset($edit) && $edit != NULL)
                    <th style="border-color: #000" class="hide_row">Edit</th>
                    @else
                    <th style="border-color: #000" class="hide_row">Hide</th>
                   @endif
                   @if(Auth::User()->type == 'company')
                    <th style="border-color: #000" class="hide_row">Move</th>
                   @endif
                </thead>
                <tbody style="border-color: #000">
                    <?php $total = 0; $expenses = 0; $payments = 0; $quantity = 0; $paid = 0?>
                    @forelse($expense  AS $key=>$data)
                        {{-- @if($data->head_id == 1 && $data->subhead_id = 2)
                            @if($data->payment_type != 0)
                       @if(@$data->parentHead->head_name != 'banana agreement' && isset($edit))
                                <tr id="{{ $data->id }}" @if(!empty($data->column_color))style="border-color: #000;background-color:{{ $data->column_color }}" @else style="border-color:#000" @endif>
            
                                    <td style="border-color: #000">{{ $key+1 }}</td>
            
                                    <td id="{{$data->id}}"  onclick="columnColor({{ $data->id  }})") >{{ get_date($data->expense_date) }}</td>
            
                                    <td style="border-color: #000">{{ @$data->parentHead->head_name }} > {{ @$data->parentsubhead->head_name }} > {{ @$data->parentChildSubhead->head_name }}</td>
                                    <td style="border-color: #000" class="work">{{ @$data->work }}</td>
                                    <td style="border-color: #000" class="acres">{{ @$data->acres }}</td>
                                    <td style="border-color: #000" class="meterial">{{ @$data->material }}</td>
                                    <td style="border-color: #000" class="quantity" quantity="{{ @$data->quantity }}">{{ number_format(@$data->quantity,2) }}</td>
                                    <td style="border-color: #000" class="unit_rate">{{ round(@$data->unit_rate) }}</td>
                                    <td style="border-color: #000" class="tot" type="{{$data->payment_type}}" amount="{{$data->total}}">
                                        <span><?=($data->payment_type == 0 || $data->payment_type == 2) ? '-' : ''?></span>{{ round(@$data->total) }}</td>
                                    <td style="border-color: #000">
                                        @if(@$data->payment_type == 1)
                                            Expense
                                        @elseif(@$data->payment_type == 2)
                                            Paid
                                            @else 
                                                Income   
                                        @endif
                                    </td>
                                    <td style="border-color: #000">{{ @$data->note }}</td>
                                    
                                    @if(Auth::user()->type == 'company')
                                    <td>{{ $data->parentUser->name }}</td>
                                    <input type="hidden" name="hidden_added_by" value="{{ $data->parentUser->name }}">
                                    @endif
                                    
                                    @if(isset($edit) && $edit != NULL)
                                        <td style="border-color: #000" class="hide_row">
                                            @if(@$data->parentHead->slug != 'banana_agreement')
                                            <a href="" id="edit" data-edit="{{ $data->id }}"><i class="fas fa-edit"></i>Edit</a>
                                            <a href="" id="delete" data-delete="{{ $data->id }}"><i class="fas fa-edit"></i>Del</a>
                                            @endif
                                        </td>
                                    @else
                                    <td style="border-color: #000" class="hide_row"><button style="color: #0000EE;cursor: pointer; background: none; border: 0; text-decoration: underline" onclick="removeRow({{ $data->id }},{{ $data->total }},{{ $data->payment_type }},{{ $type }})">Hide</button></td>
                                    @endif
                                        @if(Auth::User()->type == 'company')
                                            <input type="hidden" name="hidden_move" value="{{ $data->id }}">
                                            <td class="hide_row">
                                                @if($data->parentUser->type != 'company')
                                                    <a href=""><input type="checkbox" class="move" value="{{ $data->id }}" name="move[]"></a>
                                                @endif
                                            </td>
                                        @endif
                                    <?php
                                        if($data->payment_type == 1){
                                            $expenses += $data->total;
                                        }elseif($data->payment_type == 2){
                                                $paid += $data->total;
                                        }else{
                                            $payments += $data->total;
                                        }
                                        if(isset($data->quantity)){
                                            $quantity += $data->quantity;
                                        }
                                    ?>
                                </tr>
                            @endif
                        @else
                        <tr id="{{ $data->id }}" @if(!empty($data->column_color))style="border-color: #000;background-color:{{ $data->column_color }}" @else style="border-color:#000" @endif>
            
                            <td style="border-color: #000">{{ $key+1 }}</td>
    
                            <td id="{{$data->id}}"  onclick="columnColor({{ $data->id  }})") >{{ get_date($data->expense_date) }}</td>
    
                            <td style="border-color: #000">{{ @$data->parentHead->head_name }} > {{ @$data->parentsubhead->head_name }} > {{ @$data->parentChildSubhead->head_name }}</td>
                            <td style="border-color: #000" class="work">{{ @$data->work }}</td>
                            <td style="border-color: #000" class="acres">{{ @$data->acres }}</td>
                            <td style="border-color: #000" class="meterial">{{ @$data->material }}</td>
                            <td style="border-color: #000" class="quantity" quantity="{{ @$data->quantity }}">{{ round(@$data->quantity,2) }}</td>
                            <td style="border-color: #000" class="unit_rate">{{ round(@$data->unit_rate) }}</td>
                            <td style="border-color: #000" class="tot" type="{{$data->payment_type}}" amount="{{$data->total}}">
                                <span><?=($data->payment_type == 0 || $data->payment_type == 2) ? '-' : ''?></span>{{ round(@$data->total) }}</td>
                            <td style="border-color: #000">
                                @if(@$data->payment_type == 1)
                                    Expense
                                @elseif(@$data->payment_type == 2)
                                    Paid
                                    @else 
                                        Income   
                                @endif
                            </td>
                            <td style="border-color: #000">{{ @$data->note }}</td>
                            
                            @if(Auth::user()->type == 'company')
                            <td>{{ $data->parentUser->name }}</td>
                            <input type="hidden" name="hidden_added_by" value="{{ $data->parentUser->name }}">
                            @endif
                            
                            @if(isset($edit) && $edit != NULL)
                                <td style="border-color: #000" class="hide_row">
                                    @if(@$data->parentHead->slug != 'banana_agreement')
                                    <a href="" id="edit" data-edit="{{ $data->id }}"><i class="fas fa-edit"></i>Edit</a>
                                    <a href="" id="delete" data-delete="{{ $data->id }}"><i class="fas fa-edit"></i>Del</a>
                                    @endif
                                </td>
                            @else
                            <td style="border-color: #000" class="hide_row"><button style="color: #0000EE;cursor: pointer; background: none; border: 0; text-decoration: underline" onclick="removeRow({{ $data->id }},{{ $data->total }},{{ $data->payment_type }},{{ $type }})">Hide</button></td>
                            @endif
                                @if(Auth::User()->type == 'company')
                                    <input type="hidden" name="hidden_move" value="{{ $data->id }}">
                                    <td class="hide_row">
                                        @if($data->parentUser->type != 'company')
                                            <a href=""><input type="checkbox" class="move" value="{{ $data->id }}" name="move[]"></a>
                                        @endif
                                    </td>
                                @endif
                            <?php
                                if($data->payment_type == 1){
                                    $expenses += $data->total;
                                }elseif($data->payment_type == 2){
                                        $paid += $data->total;
                                }else{
                                    $payments += $data->total;
                                }
                                if(isset($data->quantity)){
                                    $quantity += $data->quantity;
                                }
                            ?>
                        </tr>
                       @endif
                      @endif      --}}
                      <tr id="{{ $data->id }}" @if(!empty($data->column_color))style="border-color: #000;background-color:{{ $data->column_color }}" @else style="border-color:#000" @endif>
            
                        <td style="border-color: #000">{{ $key+1 }}</td>

                        <td id="{{$data->id}}"  onclick="columnColor({{ $data->id  }})") >{{ get_date($data->expense_date) }}</td>

                        <td style="border-color: #000">{{ @$data->parentHead->head_name }} > {{ @$data->parentsubhead->head_name }} > {{ @$data->parentChildSubhead->head_name }}</td>
                        <td style="border-color: #000" class="work">{{ @$data->work }}</td>
                        <td style="border-color: #000" class="acres">{{ @$data->acres }}</td>
                        <td style="border-color: #000" class="meterial">{{ @$data->material }}</td>
                        <td style="border-color: #000" class="quantity" quantity="{{ @$data->quantity }}">{{ round(@$data->quantity,2) }}</td>
                        <td style="border-color: #000" class="unit_rate">{{ round(@$data->unit_rate) }}</td>
                        <td style="border-color: #000" class="tot" type="{{$data->payment_type}}" amount="{{$data->total}}">
                            <span><?=($data->payment_type == 0 || $data->payment_type == 2) ? '-' : ''?></span>{{ round(@$data->total) }}</td>
                        <td style="border-color: #000">
                            @if(@$data->payment_type == 1)
                                Expense
                            @elseif(@$data->payment_type == 2)
                                Paid
                                @else 
                                    Income   
                            @endif
                        </td>
                        <td style="border-color: #000">{{ @$data->note }}</td>
                        
                        @if(Auth::user()->type == 'company')
                        <td>{{ $data->parentUser->name }}</td>
                        <input type="hidden" name="hidden_added_by" value="{{ $data->parentUser->name }}">
                        @endif
                        
                        @if(isset($edit) && $edit != NULL)
                            <td style="border-color: #000" class="hide_row">
                                @if(@$data->parentHead->slug != 'banana_agreement')
                                <a href="" id="edit" data-edit="{{ $data->id }}"><i class="fas fa-edit"></i>Edit</a>
                                <a href="" id="delete" data-delete="{{ $data->id }}"><i class="fas fa-edit"></i>Del</a>
                                @endif
                            </td>
                        @else
                        <td style="border-color: #000" class="hide_row"><button style="color: #0000EE;cursor: pointer; background: none; border: 0; text-decoration: underline" onclick="removeRow({{ $data->id }},{{ $data->total }},{{ $data->payment_type }},{{ $type }})">Hide</button></td>
                        @endif
                            @if(Auth::User()->type == 'company')
                                <input type="hidden" name="hidden_move" value="{{ $data->id }}">
                                <td class="hide_row">
                                    @if($data->parentUser->type != 'company')
                                        <a href=""><input type="checkbox" class="move" value="{{ $data->id }}" name="move[]"></a>
                                    @endif
                                </td>
                            @endif
                        <?php
                            if($data->payment_type == 1){
                                $expenses += $data->total;
                            }elseif($data->payment_type == 2){
                                    $paid += $data->total;
                            }else{
                                $payments += $data->total;
                            }
                            if(isset($data->quantity)){
                                $quantity += $data->quantity;
                            }
                        ?>
                    </tr>
                   @empty
                   @endforelse
                    <?php $total = $expenses-($paid+$payments) ?>
                    <tr style="border-color: #000" id="total_row">
                        <td colspan="6" style="border-color: #000">Total</td>
                        <td id="total_quantity">{{ @round($quantity) }}</td>
                        <td></td>
                        <td style="border-color: #000" id="total" >{{ round($total) }}</td>
                        <td style="border-color: #000"></td>
                        <td style="border-color: #000"></td>
                        <td style="border-color: #000" class="hide_row"></td>
                    </tr>
                </tbody>
            </table>
        </div>

         <a href="javascript:void(0)" class="print" style="text-align: right; display: block; text-decoration: none; color: #000">Print</a>
     </div>
 </body>
 <script src="{{ asset('assets/modules/jquery.min.js') }} "></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment-with-locales.min.js"></script>
<script>

    function removeRow(id,ammount,type,report_type){
        $('#'+id).remove();
        total();
    }

    var row_id ='';
    //change the column color
    function columnColor(id){
        row_id =id;
        $('#colorBar').removeClass('display_style');
        $('.fixed_head thead').css('top', '30px');
    }
    //for print
    $('.print').click(function(){
        window.print();
    });
    //dispaly the color bar
    $(document).on('click','.get_color',function(){
      $('#'+row_id).css('background-color',$(this).attr('color'));
      var color = $(this).attr('color');

      $.ajax({
        url  : "{{ url('report/column_color') }}/"+row_id,
        type : "get",
        data : { colorCode:color },
        success:function(data){
            console.log(data);
        }
      });

    });
    function formatMoney(number, decPlaces, decSep, thouSep) {
        decPlaces = isNaN(decPlaces = Math.abs(decPlaces)) ? 2 : decPlaces,
        decSep = typeof decSep === "undefined" ? "." : decSep;
        thouSep = typeof thouSep === "undefined" ? "," : thouSep;
        var sign = number < 0 ? "-" : "";
        var i = String(parseInt(number = Math.abs(Number(number) || 0).toFixed(decPlaces)));
        var j = (j = i.length) > 3 ? j % 3 : 0;

        return sign +
            (j ? i.substr(0, j) + thouSep : "") +
            i.substr(j).replace(/(\decSep{3})(?=\decSep)/g, "$1" + thouSep) +
            (decPlaces ? decSep + Math.abs(number - i).toFixed(decPlaces).slice(2) : "");
    }

    function total(){
        var payment=0;
        var expensene=0;
        var paid = 0;
        var total;
        var total_quantity=0;

        $('.tot').each(function(i,val){
           if($(this).attr('type')==0){
            payment  += eval($(this).attr('amount'));
           }else if($(this).attr('type')==2){
            paid += eval($(this).attr('amount'));
           }else{
            expensene += eval($(this).attr('amount'));
           }
        });

        $('.quantity').each(function(j,k){
            if($(this).attr('quantity').length > 0){
                total_quantity += eval($(this).attr('quantity'));
            }
            
            // console.log($(this).attr('quantity'));
        });
        // console.log(total_quantity);

        total = eval(expensene-(paid+payment));

        $('#total').text(formatMoney(total));
        $('#total_quantity').text(formatMoney(total_quantity));
        // if(payment==0 && expensene==0){
        //     $('#total_row').remove();
        // }

    }
    //remove teh
   $(document).on('click','#removeColorBar',function(){
    $('#colorBar').addClass('display_style');
    $('.fixed_head thead').css('top', '0px');
   });

    $(document).on('click','#edit',function(e){
        e.preventDefault();
       var row_id = $(this).data('edit');

        $.ajax({
            url : "{{ url('report/row') }}",
            type: "get",
            data:{id:row_id},
            success:function(data){
                $('#'+row_id).html(data);
                total();
            }
        });

    });
    //save row will save and then embbed back
    $(document).on('click','.save',function(e){
        e.preventDefault;
        var row_id = $(this).data('save');

        var date = $('#'+row_id).find('.date').val();
        var work = $('#'+row_id).find('.work').val();
        var acres = $('#'+row_id).find('.acres').val();
        var material = $('#'+row_id).find('.material').val();
        var quantity = $('#'+row_id).find('.quantity').val();
        var rate = $('#'+row_id).find('.unit_rate').val();
        var tot = $('#'+row_id).find('.total').val();
        var type = $('#'+row_id).find('.type').val();
        var note = $('#'+row_id).find('.note').val();
        var headsubhead = $('#'+row_id).find('.headsubhead').val();
        // console.log(headsubhead);

        $.ajax({
            url : "{{ url('report/update') }}",
            type:"GET",
            data:{id:row_id,date:date,work:work,acres:acres,material:material,quantity:quantity,rate:rate,total:tot,type:type,note:note,headsubehad:headsubhead},
            success:function(data){
                $('#'+row_id).html(data);
                // console.log(data);
                total();
            }
        });
        return false;
    });

    $(document).on('click','#delete',function(e){
        e.preventDefault();
        $(this).parent().parent().remove();
        var id = $(this).data('delete');
        var conf = confirm("are you sure?");

        if(conf == true){
            $.ajax({
            url : "{{ url('report/delete') }}",
            tpye:"get",
            data:{id:id},
            success:function(data){
                // window.location.reload();
                total();
            }
        });
        }
    });
    $(document).on('keyup','.unit_rate',function(){
        if($(this).parent().parent().find('.unit_rate').val() != ''){
                totals($(this));
            }
    });


    $(document).on('keyup','.quantity',function(){
        if($(this).parent().parent().find('.quantity').val() != ''){
            totals($(this));
        }
    });

    function totals(obj){

        var  quantity  = obj.parent().parent().find('.quantity').val();
        var  unit_rate = obj.parent().parent().find('.unit_rate').val();
        var  total = quantity * unit_rate;
        obj.parent().parent().find('.total').val(total);

    }
    //move function
    $(document).on('click','#move_button',function(){
        var arr = [];
        var checkedNum = $('input[name="move[]"]:checked').length;
        
        if (checkedNum > 0) {
            
            $('input[name="move[]"]:checked').each(function(j,k){
                arr.push($(this).val());
            });
            
            $.ajax({
                url : "{{ route('reports.move') }}",
                type : "get",
                data : {ids:arr},
                success:function(data){
                    alert('Entries Moved Successfully');
                    location.reload();
                }
            });

        }else{
            alert("Please Check The Boxes");
        }
        
    });

</script>
</html>

