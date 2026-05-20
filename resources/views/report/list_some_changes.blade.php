<html>
    <head>
        <title>Expense Report</title>
    </head>
 <body>
     <div class="containers">
         {{-- <h2 style="text-align: center; color: green">{{ @$report }}</h2> --}}
         {{-- <fieldset>
             <legend>Report Filters</legend>
             <p style="margin: 5px 0; padding-left: 20px;"><strong>Late Payments</strong></p>
         </fieldset> --}}

         <table style="margin-top: 20px; border-color: #000;border-collapse: collapse; width: 100%;text-align:center" cellpadding="5" border="1px" >
             <thead style="background-color: #B0C4DE;border-color: #000">
                <th style="border-color: #000">#</th>
                <th style="border-color: #000">Expense Date</th>
                <th style="border-color: #000">Head </th>
                <th style="border-color: #000">Sub.Head</th>
                <th style="border-color: #000">Third Head</th>
                <th style="border-color: #000">Work</th>
                <th style="border-color: #000">Acres</th>
                <th style="border-color: #000">Material</th>
                <th style="border-color: #000">Qty</th>
                <th style="border-color: #000">Rate</th>
                <th style="border-color: #000">Total</th>
                <th style="border-color: #000">Type</th>
                <th style="border-color: #000">Note</th>
                {{-- <th style="border-color: #000">Added By</th> --}}
                 {{-- <th style="border-color: #000">Action</th> --}}

             </thead>
             <tbody >
                <?php $total = 0;?>
                 @forelse($expense AS $key=>$data)
                    @if($data->column_color!="#fbfbfb" && $data->column_color!='')
                    @php $total = $total+1; @endphp
                    <tr style="background-color:{{$data->column_color}};color:{{$data->column_fonts}}">
                    <td><?=$total?></td>
                    <td><?=get_date($data->expense_date)?></td>
                    <td>{{ @$data->parentHead->head_name }}  </td>
                    <td>{{ @$data->parentsubhead->head_name }}</td>
                    <td>{{ @$data->parentChildSubhead->head_name }}</td>
                    <td><?=$data->work ?></td>
                    <td><?=$data->acres ?></td>
                    <td><?=$data->material ?></td>
                    <td><?=$data->quantity ?></td>
                    <td><?=$data->unit_rate ?></td>
                   <td style="border-color: #000; text-align:right" class="tot" type="{{$data->payment_type}}" amount="{{$data->total}}">
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
                        {{-- <td>{{ @$data->parentUser->name }}</td> --}}

                        @endif
                        {{-- <td><button class="btn-click"  query="{{$data->expense_date}}">Report</button></td> --}}
                    </tr>
                    @endif

                 @empty
                 No Record Found
                 @endforelse
             </tbody>
         </table>

     </div>
 </body>
<script src="{{ asset('assets/modules/jquery.min.js') }} "></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script>


$(document).on('click', '.btn-click', function() {
    var query = $(this).attr('query');
    var user_id = "{{auth('web')->user()->id}}";
    var to_date = moment(query).format("YYYY-MM-DD");
    var from_date = moment(query).format("YYYY-MM-01");
    var string = `from_date=${from_date}&to_date=${to_date}&user_id=${user_id}`;
    var _url = "{{ route('reports.search') }}?"+string;
    window.open(_url,'targetWindow',
                                   `toolbar=no,
                                    location=no,
                                    status=no,
                                    menubar=no,
                                    scrollbars=yes,
                                    resizable=yes,
                                    width=${screen.width},
                                    height=${screen.height}`);
});

</script>

</html>

