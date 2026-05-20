<html>
    <head>
        <title>Expense Report</title>
    </head>
 <body>
     <div class="containers">
         <h2 style="text-align: center; color: green">{{ @$report }}</h2>
         <fieldset>
             <legend>Report Filters</legend>
             <p style="margin: 5px 0; padding-left: 20px;"><strong>Late Payments</strong></p>
         </fieldset>

         <table style="margin-top: 20px; border-color: #000;border-collapse: collapse; width: 100%;text-align:center" cellpadding="5" border="1px" >
             <thead style="background-color: #B0C4DE;border-color: #000">
                <th style="border-color: #000">#</th>
                <th style="border-color: #000">Contract Name</th>
                <th style="border-color: #000">Agreement Date</th>
                <th style="border-color: #000">Due Date</th>
                <th style="border-color: #000">Due Amount</th>
                <th style="border-color: #000">Pay Date</th>
                <th style="border-color: #000">Pay</th>

             </thead>
             <tbody style="border-color: #000">
                <?php $total = 0;?>
                 @forelse($late AS $key=>$data)
                    <tr id="{{ $data->id }}">
                        <td>{{ $key+1 }}</td>
                        <td>{{ $data->parentAgreement->contract_name }}</td>
                        <td>{{ get_date($data->parentAgreement->agreement_date) }}</td>
                        <td>{{ get_date($data->due_date) }}</td>
                        <td>{{ round($data->due_amount) }}</td>
                        <td><input type="date" class="pay_date" name="pay_date" value="{{ date('Y-m-d') }}"></td>
                        <td><button class="paid" onclick="removeRow({{ $data->id }})" amount="{{ $data->due_amount }}">Paid</button></td>
                        <?php $total += $data->due_amount ?>
                    </tr>
                 @empty
                 No Record Found
                 @endforelse
             </tbody>
         </table>

     </div>
 </body>
<script src="{{ asset('assets/modules/jquery.min.js') }} "></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment-with-locales.min.js"></script>
<script>
    function removeRow(id){
        var pay_date = $('#'+id).find('.pay_date').val();
        var schedule_id = id;
        $.ajax({
            url : "{{ url('report/late/paid') }}",
            type : "GET",
            data : { id:schedule_id, date:pay_date },
            sccess:function(data){
            }
        });
        $('#'+id).remove();
        alert("Payment paid successfully");

        window.location.reload();

        // total();
    }

    function total(){
        var total=0;
        $('.paid').each(function(i,val){
            total += eval($(this).attr('amount'));
        })
        $('#total').text(eval(total));
        if(total == 0){
            $('#total_row').remove();
        }

    }
</script>

</html>

