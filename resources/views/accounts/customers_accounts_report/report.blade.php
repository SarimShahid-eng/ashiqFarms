
<html>
    <head>
        <title>Users Accounts Report</title>
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

        </style>
    </head>
 <body>
     <div class="containers">
         <h2 style="text-align: center; color: green">{{ @$report }}</h2>
         <fieldset>
             <legend>Report Filters</legend>
             <p style="margin: 5px 0; padding-left: 20px;">@if(isset($opening_balance))<strong>Bank : </strong>{{ @$balance[0]->parentBank->bank_name }}<strong> Branch : </strong>{{ @$balance[0]->parentBankBranch->branch_name }}  <strong>Branch Opening Balance:</strong>  {{ round(@$opening_balance->opening_balance) }}<strong>@endif Date : </strong>{{ @date("m/d/Y",strtotime($from_date)) }} <strong> To </strong> {{ @date("m/d/Y",strtotime($to_date)) }}</p>
         </fieldset>
         
         <table style="border:1px solid black; margin-top:10px;"  class="display_style" id="colorBar">
             <tr>
                 <td><button color="#00FF00" style="background-color:#00FF00; width:20px; height:20px" class="get_color"></button></td>
                 <td><button color="#FF0000" style="background-color:#FF0000; width:20px; height:20px" class="get_color"></button></td>
                 <td><button color="#CCFF00" style="background-color:#CCFF00; width:20px; height:20px" class="get_color"></button></td>
                 <td><button color="#FF9900" style="background-color:#FF9900; width:20px; height:20px" class="get_color"></button></td>
                 <td><button color="#0099FF" style="background-color:#0099FF; width:20px; height:20px" class="get_color"></button></td>
                 <td><button color="#fbfbfb" style="background-color:#fbfbfb; width:20px; height:20px" class="get_color"></button></td>
                 <td></td>
                 <td><a href="#" id="removeColorBar">X</a></td>
             </tr>
         </table>
         
         <table style="margin-top: 20px; border-color: #000;border-collapse: collapse; width: 100%;" cellpadding="5" border="1px">
             <thead style="background-color: #B0C4DE;border-color: #000">
                <th style="border-color: #000">#</th>
                <th style="border-color: #000">Date</th>
                <th style="border-color: #000">User</th>
                <th style="border-color: #000">Bank & Branches</th>
                
                <th style="border-color: #000">Amount</th>
                <th style="border-color: #000">Cheque/Card/Voucher No</th>
                <th style="border-color: #000">Mode</th>
                <th style="border-color: #000">Type</th>
                <th style="border-color: #000">Note</th>
        
                @if(isset($edit) && $edit != NULL)
                 <th style="border-color: #000" class="hide_row">Edit</th>
                 @else
                 <th style="border-color: #000" class="hide_row">Hide</th>
                @endif
             </thead>
             <tbody style="border-color: #000">
                 <?php $total = 0; $in = 0; $out = 0; $opening = @$opening_balance->opening_balance; $grand_total = 0;  ?>
                 @forelse($balance  AS $key=>$data)
                    <tr id="{{ $data->id }}" @if(!empty($data->column_color))style="border-color: #000;background-color:{{ $data->column_color }}" @else style="border-color:#000" @endif>
                        <td style="border-color: #000">{{ $key+1 }}</td>
                        <td  onclick="columnColor({{ $data->id  }})") >{{ get_date($data->balance_date) }}</td>
                        <td style="border-color: #000" class="customer">{{ $data->parentCustomer->name }}</td>

                        <td style="border-color: #000">{{ @$data->parentbank->bank_name }} > {{ @$data->parentBankBranch->branch_name }}</td>
                        <td style="border-color: #000" class="amount" type="{{ $data->type }}" amount="{{ $data->amount }}">{{ round($data->amount) }}</td>
                        <td style="border-color: #000"> {{ @$data->parentReason->reason }}</td>
                        <td style="border-color: #000"> {{ @$data->parentTransaction->mode }}</td>
                        <td style="border-color: #000">
                            @if($data->type == 'in')
                                IN                                  
                            @else
                                OUT
                            @endif    
                        </td>
                        <td style="border-color: #000">{{ $data->note }}</td>
                        @if(isset($edit) && $edit != NULL)
                            <td style="border-color: #000" class="hide_row">
                                <a href="" id="edit" data-edit="{{ $data->id }}"><i class="fas fa-edit"></i>Edit</a>
                                <a href="" id="delete" data-delete="{{ $data->id }}"><i class="fas fa-edit"></i>Del</a>
                            </td>
                        @else
                        <td style="border-color: #000" class="hide_row"><button style="color: #0000EE;cursor: pointer; background: none; border: 0; text-decoration: underline" onclick="removeRow({{ $data->id }})">Hide</button></td>
                        @endif
                        <?php 
                            if($data->type == 'in'){
                                $in += $data->amount;
                            }elseif($data->type == 'out'){
                                $out += $data->amount;
                            }
                        ?>
                    </tr>
                 @empty 
                 @endforelse
                 <?php 
                    $total += $in-$out;
                    if(isset($opening_balance)){
                        $grand_total += (($opening+$in)-$out);
                    }
                    // $total += ($total-$out);
                 ?>
                 <tr style="border-color: #000" id="total_row">
                     <td colspan="4" style="border-color: #000">Total</td>
                     <td style="border-color: #000" id="total" >{{ round($total) }}</td>
                     <td style="border-color: #000"></td>
                     <td style="border-color: #000"></td>
                     <td></td>
                     <td style="border-color: #000" class="hide_row"></td>
                 </tr>
                 @if(isset($opening_balance))
                 <tr style="border-color: #000" id="total_row">
                    <td colspan="4" style="border-color: #000">Grand Total</td>
                    <td style="border-color: #000" id="grand_total" >{{ round($grand_total) }}</td>
                    <td style="border-color: #000"></td>
                    <td style="border-color: #000"></td>
                    <td></td>
                    <td style="border-color: #000" class="hide_row"></td>
                </tr>
                @endif
             </tbody>
             <input type="hidden" name="opening" value="{{ $opening }}" id="opening">
         </table>
         <a href="javascript:void(0)" class="print" style="text-align: right; display: block; text-decoration: none; color: #000">Print</a>
     </div>
 </body>
 <script src="{{ asset('assets/modules/jquery.min.js') }} "></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment-with-locales.min.js"></script>
<script>

    //remove the row
    function removeRow(id){
        $('#'+id).remove();
        total();
    }

    
    //display the color bar and get the row_id
    var row_id ='';
    function columnColor(id){
        row_id =id;
        $('#colorBar').removeClass('display_style');
    }
    
    //set the row color and save in database
    $(document).on('click','.get_color',function(){
      $('#'+row_id).css('background-color',$(this).attr('color'));
      var color = $(this).attr('color');
    
      $.ajax({
        url  : "{{ url('accounts/users_accounts/report/column_color') }}/"+row_id,
        type : "get",
        data : { colorCode:color },
        success:function(data){
            
        }
      });

    });
    //remove the color bar
   $(document).on('click','#removeColorBar',function(){
    $('#colorBar').addClass('display_style');
        
   });



   //edit the row 
    $(document).on('click','#edit',function(e){
        e.preventDefault();

        var row_id = $(this).data('edit');
        
        $.ajax({
            url : "{{ url('accounts/users_accounts/report/edit') }}/"+row_id,
            type: "get",
            data:{id:row_id},
            success:function(data){
                $('#'+row_id).html(data);
                total();
            }
        });
        

    }); 
    //for print
    $('.print').click(function(){
        window.print();
    });
    //save row will save and then embbed back
    $(document).on('click','#save',function(e){
        e.preventDefault;
        var row_id = $(this).data('save');
        var bank_id = $('#'+row_id).find('.bank_id').val();
        var branch_id = $('#'+row_id).find('.branch_id').val();
        var user_id = $('#'+row_id).find('.users').val();
        var amount = $('#'+row_id).find('.amounts').val();
        var type = $('#'+row_id).find('.type').val();
        var reason_id = $('#'+row_id).find('.reason_id').val();
        var mode = $('#'+row_id).find('.mode').val();
        var note = $('#'+row_id).find('.note').val();
        var created_at = $('#'+row_id).find('.date').val();
        
        $.ajax({
            url : "{{ url('accounts/users_accounts/report/update') }}",
            type:"GET",
            data:{ id:row_id, bank_id:bank_id, branch_id:branch_id, customer_id:user_id, amount:amount, type:type, note:note, created_at:created_at,mode:mode,reason_id:reason_id },
            success:function(data){
                $('#'+row_id).empty().append(data);
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
            url : "{{ url('accounts/users_accounts/report/delete') }}/"+id,
            tpye:"get",
            success:function(data){
                // window.location.reload();
                total();
            }
        });
        } 
    });

    var user_id = 0;
        //append the user banks
        $(document).on('change','#user',function(){
            var html = '<option value="">Select Branch</option>';
            $('#bank_branch').empty().append(html);
            
            user_id = $(this).val();
            
            $.ajax({
                url : "{{ url('accounts/users_accounts/users_banks') }}/"+user_id,
                type:"GET",
                success:function(data){
                    $('#bank').empty().append(data);
                }
            });
        });
        //append the user bank branches
        $(document).on('change','#bank',function(){
            
            // var html = '<option value="">Select Branch</option>';
            $('#bank_branch').empty();
            user_id = $('#user').val();
            var bank_id = $(this).val();

            $.ajax({
                url : "{{ url('accounts/users_accounts/users_branches') }}/"+bank_id+'/'+user_id,
                type : "GET",
                success:function(data){
                    $('#bank_branch').empty().append(data);
                }
            });
        });
    function total(){
        
        if($('#opening').val()){
            
            var opening = $('#opening').val();
            var in_pay=0;
            var out_pay=0;
            
            $('.amount').each(function(i,val){
                if($(this).attr('type')=='in'){
                    in_pay  += eval($(this).attr('amount'));
                }else{
                    out_pay += eval($(this).attr('amount'));       
                }
            });
            var opening_in = eval(parseInt(opening) + in_pay);
            $('#total').text(eval(in_pay-out_pay).toFixed(2));
            $('#grand_total').text(eval(opening_in-out_pay).toFixed(2));
            if(in_pay == 0 && out_pay == 0){
                $('#total').remove();
                $('#grand_total').remove();
            }
        }else{
            
            var in_pay=0;
            var out_pay=0;
            
            $('.amount').each(function(i,val){
                if($(this).attr('type')=='in'){
                    in_pay  += eval($(this).attr('amount'));
                }else{
                    out_pay += eval($(this).attr('amount'));       
                }
            });
            // var opening_in = eval(parseInt(opening) + in_pay);
            $('#total').text(eval(in_pay-out_pay).toFixed(2));
            if(in_pay == 0 && out_pay == 0){
                $('#total').remove();
            }
        }
            
    }
        
</script>
</html>

