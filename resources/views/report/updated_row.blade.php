<td>1</td>
<td id="{{ @$expense->id }}" onclick="columnColor({{ @$expense->id }})")>
    {{ date('Y-m-d', strtotime(@$expense->expense_date)) }}</td>
<td>
    {{ @$expense->parentHead->head_name }} </td>
<td>
    {{ @$expense->parentsubhead->head_name }}
</td>
<td>

    {{ @$expense->parentChildSubhead->head_name }}
</td>
<td>

    {{ @$expense->parentForthSubhead->head_name }}
</td>
<td class="work">{{ @$expense->work }}</td>
<td class="acres">{{ @$expense->acres }}</td>
<td class="meterial">{{ @$expense->material }}</td>
<td class="quantity" quantity="{{ @$expense->quantity }}">{{ round(@$expense->quantity) }}</td>
<td class="unit_rate">{{ @$expense->unit_rate }}</td>
<td class="tot" type="{{ $expense->payment_type }}" amount="{{ $expense->total }}">
    <span><?= $expense->payment_type == 0 ? '-' : '' ?></span>{{ round(@$expense->total) }}</td>
<td>
    @if ($expense->payment_type == 0)
        Income
    @endif
    @if ($expense->payment_type == 1)
        Expense
    @endif
    @if ($expense->payment_type == 2)
        Paid
    @endif

</td>
<td>{{ @$expense->note }}</td>
<td class="hide_row">
    <a href="" id="edit" data-edit="{{ $data->id ?? @$expense->id }}"><i class="fas fa-edit"></i>Edit</a>
    <a href="" id="delete" data-delete="{{ $data->id ?? @$expense->id }}"><i class="fas fa-edit"></i>Del</a>
    {{-- <a href="" class="save" data-save="{{ @$expense->id }}">Save</a> --}}
</td>
<td class="hide_row"><a href=""><input type="checkbox" class="move" value="{{ $expense->id }}"
            name="move[]"></a></td>
