 <html>
    <head>
        <title>Expense Report</title>
        {{-- <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}"> --}}
           <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        <style>
            *{font-family: sans-serif}
            @media print{
                .print{display: none!important;}
                .hide_row{display:none!important;}
                .fixed_head thead,
                .fixed_heads{position: relative !important;}
                .mtbl thead th{border-top: 3px solid #000 !important; border-left: 4px solid #000 !important; border-bottom: 3px solid #000 !important;border-right: 5px solid #000 !important;}
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
             <div class="head_and_user_edit" style="display:flex; justify-content:space-between;">
                 
            
             <p style="margin: 5px 0; padding-left: 20px;"><strong>Heads : </strong>{{ @$head->head_name }}    <strong>SubHead : </strong>{{ @$subhead }} <strong>Date : </strong>{{ get_date($from_date) }} <strong> To </strong> {{ get_date($to_date) }}</p>
             
                 <select name="user_id" data-toggle="select2" id="user_id" class="form-control">
                                                    <option value="" selected>Select User</option>
                                        @foreach($users as $user)
                                        <option value="{{$user->id}}" >{{$user->name}}</option>
                                        @endforeach
    
                                                </select>
             </div>
         </fieldset>

         <table style="border:1px solid black; margin-top:10px;"  class="display_style fixed_heads" id="colorBar">
             <tr style="background-color: #fff;">
                 <td style="background-color: #fff;"><button color="#000" style="background-color:#000; width:20px; height:20px" class="get_color"></button></td>
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
            {{-- <button id="move_button" class="hide_row"  style="margin-bottom: 10px; padding: 10px 15px; font-size: 15px; font-weight: bold; background: #394eea; border: 0; color: #fff; float: right; border-radius: .25rem;box-shadow: 0 2px 6px #acb5f6;background-color: #6777ef; border-color: #6777ef;">Move</button> --}}
            @endif
            <table style="border-color: #000;border-collapse: collapse; width: 100%;" class="mtbl" cellpadding="5" border="1px">
                <thead style="background-color: #B0C4DE;border-color: #000">
                   <th style="border-color: #000">S/r.</th>
                   <th style="border-color: #000">Date</th>
                   <th style="border-color: #000">First Head </th>
                   <th style="border-color: #000">Sub.Head</th>
                    <th style="border-color: #000">Third Head </th>
                    <th style="border-color: #000">Fourth Head</th>
                   <th style="border-color: #000">Work</th>
                   <th style="border-color: #000">Acres</th>
                   <th style="border-color: #000">Material</th>
                   <th style="border-color: #000">Qty</th>
                   <th style="border-color: #000">Rate</th>
                   <th style="border-color: #000">Total</th>
                   <th style="border-color: #000">Type</th>
                   <th style="border-color: #000">Note</th>
                    {{-- @if(Auth::user()->type == 'company')
                    <th style="border-color: #000" class="hide_row">Added By</th>
                    @endif --}}
                   @if(isset($edit) && $edit != NULL)
                    <th style="border-color: #000" class="hide_row">Edit</th>
                    @else
                    <th style="border-color: #000" class="hide_row">Hide</th>
                   @endif
                   <th>Action</th>
                   <th>Move Entry</th>
                   {{-- @if(Auth::User()->type == 'company')
                    <th style="border-color: #000" class="hide_row">Move</th>
                   @endif --}}
                </thead>
                <tbody style="border-color: #000">
                    <!--<tr>-->
                        <!--<td>-->
                            <!--<select name="user_id" data-toggle="select2" id="user_id" class="form-control">-->
                            <!--                    <option value="" selected>Select User</option>-->
                            <!--        @foreach($users as $user)-->
                            <!--        <option value="{{$user->id}}" >{{$user->name}}</option>-->
                            <!--        @endforeach-->

                            <!--                </select>-->
                                            <!--</td>-->
                    <!--</tr>-->
                    <?php $total = 0; $expenses = 0; $payments = 0; $quantity = 0; $paid = 0; $acres=0?>
                    @forelse($expense  AS $key=>$data)

                      <tr id="{{ $data->id }}" @if(!empty($data->column_color))style="border-color: #000;background-color:{{ $data->column_color }};color:{{@$data->column_fonts}}" @else style="border-color:#000" @endif>

                        <td style="border-color: #000">{{ $key+1 }}</td>

                        <td id="{{$data->id}}"  onclick="columnColor({{ $data->id  }})") >{{ get_date($data->expense_date) }}</td>

                        <td style="border-color: #000" onclick="columnColor({{ $data->id  }},true)")>
                            {{ @$data->parentHead->head_name }} </td>
                        <td style="border-color: #000" onclick="columnColor({{ $data->id  }},true)")>

                             {{ @$data->parentsubhead->head_name }} </td>
                        <td style="border-color: #000" onclick="columnColor({{ $data->id  }},true)")>

                             {{ @$data->parentChildSubhead->head_name }}</td>
                        <td style="border-color: #000" onclick="columnColor({{ $data->id  }},true)")>

                              {{ @$data->parentForthSubhead->head_name }}</td>
                        <td style="border-color: #000" class="work">{{ @$data->work }}</td>
                        <td style="border-color: #000; text-align:right" class="acres">{{ @$data->acres }}</td>
                        <td style="border-color: #000" class="meterial">{{ @$data->material }}</td>
                        <td style="border-color: #000; text-align:right" class="quantity" quantity="{{ @$data->quantity }}">{{ round(@$data->quantity) }}</td>
                        <td style="border-color: #000; text-align:right" class="unit_rate">{{ @$data->unit_rate }}</td>
                        <td style="border-color: #000; text-align:right" class="tot" type="{{$data->payment_type}}" amount="{{$data->total}}">
                            <span><?=($data->payment_type == 0 || $data->payment_type == 2) ? '-' : ''?></span>{{ @$data->total }}</td>
                        <td style="border-color: #000">
                            @if(@$data->payment_type == 1)
                                Expense
                            @elseif(@$data->payment_type == 2)
                                Paid
                                @else
                                    Income
                            @endif
                        </td>
                        <td style="border-color: #000;    font-size: 12px;">{{ @$data->note }}</td>

                        @if(Auth::user()->type == 'company')
                        <input type="hidden" name="hidden_added_by" value="{{ @$data->parentUser->name }}">
                        @endif
                                                <!--<td><h1>{{$edit}}</h1></td>-->
                        @if(isset($edit) && $edit != NULL)

                            <td style="border-color: #000" class="hide_row">
                        
                                <a href="" id="edit" data-edit="{{ $data->id }}"><i class="fas fa-edit"></i>Edit</a>
                                <a href="" id="delete" data-delete="{{ $data->id }}"><i class="fas fa-edit"></i>Del</a>
                        
                            </td>
                        @else
                        <td style="border-color: #000" class="hide_row"><button style="color: #0000EE;cursor: pointer; background: none; border: 0; text-decoration: underline" onclick="removeRow({{ $data->id }},{{ $data->total }},{{ $data->payment_type }},{{ $type }})">Hide</button></td>
                        @endif
                            @if(Auth::User()->type == 'company')
                                <input type="hidden" name="hidden_move" value="{{ $data->id }}">
                                {{-- <td class="hide_row">
                                    @if($data->parentUser->type != 'company')
                                        <a href=""><input type="checkbox" class="move" value="{{ $data->id }}" name="move[]"></a>
                                    @endif
                                </td> --}}
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

                        <td class="hide_row"><a href=""><input type="checkbox" class="move" value="{{ $data->id }}" name="move" @if($data->is_move==1) checked @endif></a></td>
                        <td class="hide_row"><a href=""><input type="checkbox" class="moveEntryToAnotherUser"value="{{ $data->id }}" name="moveEntryToAnotherUser"
                        ></a></td>

                    </tr>
                    @php
                        @$acres += preg_replace('/\D/', '', $data->acres)
                    @endphp
                   @empty
                   @endforelse
                    <?php $total = $expenses-($paid+$payments) ?>
                    <tr style="border-color: #000" id="total_row">
                        <td colspan="8" style="border-color: #000">Total</td>
                        {{-- <td>{{ $acres }}</td> --}}
                        <td></td>
                        <td id="total_quantity">{{ @round($quantity) }}</td>
                        <td></td>
                        <td style="border-color: #000" id="total" >{{ $total }}</td>
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
 <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment-with-locales.min.js"></script>
<script>

    function removeRow(id,ammount,type,report_type){
        $('#'+id).remove();
        total();
    }

    var row_id ='';
    var fonts =false;
    //change the column color
    function columnColor(id,type=false){
        row_id =id;
        fonts  =type;
        console.log(type);
        $('#colorBar').removeClass('display_style');
        $('.fixed_head thead').css('top', '30px');
    }
    //for print
    $('.print').click(function(){
        window.print();
    });
    //dispaly the color bar
    $(document).on('click','.get_color',function(){
      var type ='background';
      console.log(fonts);

      if(fonts){
       $('#'+row_id).css('color',$(this).attr('color'));
        type ='fonts';
      }else{
        $('#'+row_id).css('background-color',$(this).attr('color'));
      }
      var color = $(this).attr('color');

      $.ajax({
        url  : "{{ url('report/column_color') }}/"+row_id,
        type : "get",
        data : { colorCode:color,'type':type },
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
        var first_head = $('#'+row_id).find('.first_head').val();
        var second_head = $('#'+row_id).find('.second_head').val();
        var third_head = $('#'+row_id).find('.third_head').val();
        var forth_head = $('#'+row_id).find('.forth_head').val();
        var user_id = $('#user_id').val();
        // console.log(headsubhead);

        $.ajax({
            url : "{{ url('report/update') }}",
            type:"GET",
            data:{user_id:user_id,
                id:row_id,date:date,work:work,acres:acres,material:material,quantity:quantity,rate:rate,total:tot,type:type,note:note,first_head:first_head,second_head:second_head,third_head:third_head,forth_head:forth_head},
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
          var fixedTotal = parseFloat(total.toFixed(2));
            obj.parent().parent().find('.total').val(fixedTotal);
        // obj.parent().parent().find('.total').val(total);

    }
    //move function
    $(document).on('click','.moveEntryToAnotherUser',function(){
        var id =$(this).val();
        var user_id=$("#user_id").val()
   if(user_id === "" || user_id === null){
       var $checkbox = $(this);
       $checkbox.prop('checked', false);
       alert('select a user first to move entry')
   }
        if (this.checked && (user_id !== "" || user_id !== null)) {
            
            $.ajax({
                url : "{{ route('reports.moveEntryToAnotherUser') }}",
                type : "get",
                data : {id:id,user_id:user_id},
                success:function(data){
                    alert('Entries Moved Successfully');
                    // location.reload();
                }
            });
}

        // }else{
        //     alert("Please Check The Boxes");
        // }

    });
    $(document).on('click','.move',function(){
        var id =$(this).val();
        // var checkedNum = $('input[name="move"]:checked').length;

        // if (checkedNum > 0) {

            var boolean = $(this).is(":checked");

            $.ajax({
                url : "{{ route('reports.move') }}",
                type : "get",
                data : {id:id,boolean:boolean},
                success:function(data){
                    alert('Entries Moved Successfully');
                    // location.reload();
                }
            });

        // }else{
        //     alert("Please Check The Boxes");
        // }

    });

</script>
</html>

