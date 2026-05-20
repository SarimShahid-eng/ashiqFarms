<html>
    <head>
        <title>Expense Report</title>
    </head>
 <body>
     <div class="containers">
         <h2 style="text-align: center; color: green">{{ @$report }}</h2>
         <fieldset>
             <legend>Report Filters</legend>
             <p style="margin: 5px 0; padding-left: 20px;"><strong>Dues</strong></p>
         </fieldset>

         <table style="margin-top: 20px; border-color: #000;border-collapse: collapse; width: 100%;" cellpadding="5" border="1px">
             <thead style="background-color: #B0C4DE;border-color: #000">
                <th style="border-color: #000">#</th>
                <th style="border-color: #000">Contract Name</th>
                <th style="border-color: #000">Acres</th>
                <th style="border-color: #000">Agreement Amount</th>
                <th style="border-color: #000">Agreement Date</th>
                <th style="border-color: #000">Due Date</th>
                <th style="border-color: #000">Due Amount</th>

             </thead>
             <tbody style="border-color: #000">
                <?php $total = 0;?>
                 @forelse($dues AS $key=>$data)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $data->parentAgreement->contract_name }}</td>
                        <td>{{ $data->parentAgreement->acres }}</td>
                        <td>{{ round($data->parentAgreement->agreement_amount) }}</td>
                        <td>{{ get_date($data->parentAgreement->agreement_date) }}</td>
                        <td>{{ get_date($data->due_date) }}</td>
                        <td>{{ round($data->due_amount) }}</td>
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
</html>

