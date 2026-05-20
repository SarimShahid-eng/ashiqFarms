    <td>#</td>

    <td>{{ date('m-d-Y',strtotime($row->balance_date)) }}</td>

    <td>{{ @$row->parentCustomer->name }}</td>

    <td>{{ @$row->parentBank->bank_name }} > {{ @$row->parentBankBranch->branch_name }}</td>

    <td class="amount" type="{{ $row->type }}" amount="{{ $row->amount }}">{{ round($row->amount) }}</td>

    <td>{{ @$row->parentReason->reason }}</td>

    <td>{{ @$row->parentTransaction->mode }}</td>

    <td>@if(@$row->type == 'in') IN @else OUT @endif</td>

    <td>{{ @$row->note }}</td>

    <td style="border-color: #000" class="hide_row">
        <a href="" id="edit" data-edit="{{ $row->id }}"><i class="fas fa-edit"></i>Edit</a>
        <a href="" id="delete" data-delete="{{ $row->id }}"><i class="fas fa-edit"></i>Del</a>
    </td>
