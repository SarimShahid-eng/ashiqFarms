@if(isset($balance) && $balance != NULL)
    <?php $banks_arr = array(); ?>
    <td>#</td>
    <td style="width:100px"><input type="date" value="{{ date('Y-m-d',strtotime(@$balance->balance_date)) }}" name="date" class="date"></td>
    
    <td style="width: 100px;">
        <select name="user" id="user" class="users">
            @forelse($customers AS $customer)
                <option value="{{ $customer->id }}" @if($balance->customer_id === $customer->id) selected @endif >{{ $customer->name }}</option>
            @empty 
                <option value="">No Users</option>
            @endforelse
        </select>
    </td>
    
    <td  style="width: 350px;">
        <select name="bank_id" id="bank" class="bank_id">
            @forelse($customerBanksBranches AS $bank)
            @if(!in_array($bank->bank_id,$banks_arr)){
                <?php $banks_arr[] = $bank->bank_id; ?>
                <option value="{{ $bank->bank_id }}" @if($balance->bank_id == $bank->id) selected @endif >{{ $bank->parentBank->bank_name }}</option>
                {{-- $html .= '<option value="'.$data->bank_id.'">'.$data->parentBank->bank_name.'</option>'; --}}
            }
            @endif
            @empty 
                <option value="">No Bank</option>
            @endforelse
        </select>
        
        <select name="branch_id" id="bank_branch" class="branch_id">
            @forelse($branches AS $branch)
                <option value="{{ $branch->id }}" @if($balance->bank_branch_id == $branch->id) selected @endif>{{ $branch->branch_name }}</option>
            @empty 
                <option value="">No Branches</option>
            @endforelse
        </select>
    </td>

    <td style="max-width:50px;" ><input type="{{ $balance->type }}" step="any" value="{{ $balance->amount }}" name="amount" class="amounts" style="
        width: 100%;"></td>
    
    <td style="width: 150px;">
        <select class="reason_id" name="reason_id" id="reason_id" style="width: 100%;">
            <option value="">Select Reason</option>
            @forelse($reasons AS $reason)
                <option value="{{ $reason->id }}" @if(@$balance->reason_id == $reason->id) selected @endif>{{ $reason->reason }}</option>
            @empty 
                <option value="">No modes</option>
            @endforelse
        </select>
    </td>
    
    <td style="width: 150px;">
        <select class="mode" name="mode" id="mode" style="width: 100%;">
            @forelse($transactions AS $t)
                <option value="{{ $t->id }}" @if(@$balance->transaction_id == $t->id) selected @endif>{{ $t->mode }}</option>
            @empty 
                <option value="">No modes</option>
            @endforelse
        </select>
    </td>
    <td style="width:50px;">
        <select name="type" id="type" class="type">
            <option value="in" @if($balance->type == 'in') selected @endif>IN</option>
            <option value="out" @if($balance->type == 'out') selected @endif>OUT</option>
        </select>
    </td>

    <td style="width:150px;"><input type="text" value="{{ $balance->note }}" name="note" class="note" style="
        width: 100%; max-width: initial;"></td>

    <td class="" style="border-color: #000;width: 120;">
        {{-- <a href="" id="edit" data-edit="{{ $balance->id }}"><i class="fas fa-edit"></i>Edit</a> --}}
        <a href="" id="delete" data-delete="{{ $balance->id }}"><i class="fas fa-edit"></i>Del</a>
        <a href="" id="save" data-save="{{ $balance->id }}"><i class="fas fa-edit"></i>Save</a>
    </td>

@endif