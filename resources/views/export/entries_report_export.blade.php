@php 
    $expens = 0;
    $income = 0;
    $paid = 0;
    $payment_type = "Income";
@endphp
<table border>
    <thead>
        <tr>
            <th >#</th>
            <th width="20">Expense Date</th>
            <th width="20">Heads</th>
            <th width="20">Subhead</th>
            <th width="20">Child Head</th>
            <th width="20">Fourth Head</th>
            <th width="20">Work</th>
            <th width="20">Acres</th>
            <th width="20">Material</th>
            <th width="20">Qty</th>
            <th width="20">Rate</th>
            <th width="20">Total</th>
            <th width="20">Type</th>
            <th width="20">Note</th>
        </tr>
    <tbody>
        @foreach ($report_data as $key => $data)        
        <tr>
            
            @if($data->payment_type == 1)
                @php $expens += $data->total @endphp
            @elseif($data->payment_type == 2)
                @php $paid += $data->total @endphp
            @else
                @php $income += $data->total @endphp
            @endif
            @if($data->payment_type == 1)
                @php $payment_type = "Expense" @endphp
            @elseif($data->payment_type == 2)
                @php $payment_type = "Paid" @endphp
            @else
                @php $payment_type = "Income" @endphp
            @endif
            <td>{{$key+1}}</td>
            <td>{{ date('d-M-Y',strtotime($data->expense_date)) }}</td>
            @if(isset($data->parentHead->head_name))
                <td>{{$data->parentHead->head_name}}</td>
            @else
                <td></td>    
            @endif
            @if(isset($data->parentSubhead->head_name))
                <td>{{$data->parentSubhead->head_name}}</td>
            @else
                <td></td>    
            @endif
            @if(isset($data->parentChildSubhead->head_name))
                <td>{{$data->parentChildSubhead->head_name}}</td>
            @else
                <td></td>    
            @endif
            @if(isset($data->parentForthSubhead->head_name))
                <td>{{$data->parentForthSubhead->head_name}}</td>
            @else
                <td></td>    
            @endif
            @if(isset($data->work))
                <td>{{$data->work}}</td>
            @else
                <td></td>    
            @endif
            @if(isset($data->acres))
                <td>{{$data->acres}}</td>
            @else
                <td></td>    
            @endif
            @if(isset($data->material))
                <td>{{$data->material}}</td>
            @else
                <td></td>    
            @endif
           
            @if(isset($data->quantity))
                <td>{{ round(@$data->quantity) }}</td>
            @else
                <td></td>    
            @endif
            @if(isset($data->unit_rate))
            <td>{{ round(@$data->unit_rate) }}</td>
            @else
                <td></td>    
            @endif
            @if(isset($data->total))
            <td>{{ round(@$data->total) }}</td>
            @else
                <td></td>    
            @endif
            @if(isset($data->payment_type))
            <td>{{ @$data->payment_type = $payment_type }}</td>
            @else
                <td></td>    
            @endif
            @if(isset($data->note))
            <td>{{ round(@$data->note) }}</td>
            @else
                <td></td>    
            @endif
        </tr>
        
        @endforeach
    </tbody>
 
    </table>