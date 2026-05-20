@if(isset($edit) && $edit == TRUE)
    @forelse($expense_data AS $data)
        <tr class="d{{$data->id}}">
            <td> 
                <select  id="head" class="form-control" name="head[]" required>
                    <option value="">Select</option>
                        @forelse($heads AS $head)
                            <option value="{{ $head->id }}" @if($data->head_id == $head->id) selected @endif>{{ $head->head_name }}</option>
                        @empty
                        <p>No Head</p>
                        @endforelse
                </select>
            </td>

            <td>
                <select id="subhead" class="form-control" name="subhead[]" required>
                    <option value="">Select</option>
                        @forelse($subheads AS $subhead)
                            <option value="{{ $subhead->id }}" @if($data->subhead_id == $subhead->id) selected @endif>{{ $subhead->head_name }}</option>
                        @empty
                        <p>No SubHead</p>
                        @endforelse
                </select>
            </td>

            <td><input type="text" class="form-control" name="work[]" required value="{{ $data->work }}"></td>
            <td><input type="number" step="0.01" class="form-control" name="acres[]" required value="{{ $data->acres }}"></td>
            <td><input type="text" class="form-control" name="material[]" required value="{{ $data->material }}"></td>
            <td><input type="number" step="0.01" class="form-control" name="quantity[]" required value="{{ $data->quantity }}"></td>
            <td><input type="number" step="0.01" class="form-control" name="unit_rate[]" required value="{{ $data->unit_rate }}"></td>
            <td><input type="number" step="0.01" class="form-control" name="total[]" required value="{{ $data->total }}"></td>
            {{-- <td><a href="" class="btn btn-danger" onclick="deleteData(1)">Delete</a></td> --}}
            <td><button type="button" class="btn btn-danger" onclick="deleteData({{ $data->id }})">Delete</button></td>
        </tr>

        <tr class="d{{$data->id}}">
            <td><label for="">Note</label></td>
            <td colspan="10"><input type="text" class="form-control" name="note[]" value="{{ @$data->note }}"></td>
            
            <input type="hidden" value="{{ $data->id }}" name="expense_id[]" >
            <input type="hidden" value="{{ $data->user_id }}" name="user_id[]">
            <input type="hidden" value="{{ $data->expense_date }}" name="expense_date[]">
            <input type="hidden" value="{{ $data->payment_type }}" name="payment_type[]">
        </tr>
        
    @empty
    <tr>
        <td colspan="9">No Record Found</td>
    </tr>
    @endforelse
 @else
    <tr>
        <td style="width: 200px;"> 
            <select  id="head" class="form-control main_head"  name="head[]" required>
                <option value="">Select</option>
                    @forelse($heads AS $head)
                        <option value="{{ $head->id }}">{{ $head->head_name }}</option>
                    @empty
                    <p>empty</p>
                    @endforelse
            </select>

            <table style="width: 100%">
                <tr>
                    <td><label for="">Note</label></td>
                </tr>
            </table>
        </td>

        <td style="position: relative; width: 200px;">
            <select id="subhead" class="form-control subhead" name="subhead[]" required>
                <option value="">Select</option>
                    {{-- @forelse($subheads AS $subhead)
                        <option value="{{ $subhead->id }}">{{ $subhead->head_name }}</option>
                    @empty
                    <p>empty</p>
                    @endforelse --}}
            </select>
            <table style="width: 100%">
                <tr>
                    <td>&nbsp;</td>
                </tr>
            </table>
            <div style="position: absolute;width: 735px;bottom: 5px;">
                <table style="width: 100%">
                    <tr>
                        <td><input type="text" class="form-control" name="note[]"></td>
                    </tr>
                </table>
            </div>

        </td>

        <td style="width: 200px;"><input type="text" class="form-control" name="work[]" required>
            <table style="width: 100%">
                <tr>
                    <td>&nbsp;</td>
                </tr>
            </table></td>
        <td><input type="number"  step="0.01" class="form-control" name="acres[]" required>
            <table style="width: 100%">
                <tr>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </td>
        <td><input type="text" class="form-control" name="material[]" required>
            <table style="width: 100%">
                <tr>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </td>
        <td><input type="number" class="form-control" name="quantity[]" required>
            <table style="width: 100%">
                <tr>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </td>
        <td><input type="number"class="form-control" name="unit_rate[]" required>
            <table style="width: 100%">
                <tr>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </td>
        <td><input type="number" step="0.01" class="form-control" name="total[]" required>
            <table style="width: 100%">
                <tr>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </td>
        <td>
            <button type="button" class="btn btn-primary add_row" style="margin-bottom: 10px;">Add</button> 
            <button type="button" class="btn btn-danger delete_row" >Delete</button>
            
        </td>
    </tr>


    {{-- <input type="hidden" name="expense_id" value=""> --}}
    <input type="hidden" value="{{ Auth::id() }}" name="user_id">
    <input type="hidden" value="" name="expense_date" id="expense_date">
    <input type="hidden" value="1" name="payment_type">
@endif