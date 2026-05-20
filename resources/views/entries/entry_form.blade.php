@if(isset($edit) && $edit == TRUE)
    @forelse($expense_data AS $data)
    @php $arr=[]; @endphp

        <tr class="d{{$data->id}}">
            <td style="width:100px">
                <select  id="" class="form-control main_head" data-toggle="select2"  name="head[]" ; required>
                    <option value="">Select</option>
                        @forelse($heads AS $head)
                            @if(@$head->sub[0])
                                @foreach($head->sub AS $k)
                                    @php
                                    if(@$k->parent_id==$data->head_id){
                                        $arr[] = $k;

                                    }
                                    @endphp
                                @endforeach
                            @endif
                            @if($head->parent_id == 0 && $head->child_id == 0)
                                <option value="{{ $head->id }}" @if($data->head_id == $head->id) selected @endif>{{ $head->head_name }}</option>
                            @endif    
                        @empty
                            <option value="">No Heads</option>
                        @endforelse
                </select>
            </td>

            <td>
                <select id="" class="form-control subhead" data-toggle="select2"  name="subhead[]" ; required>
                    <option value="">Select</option>
                        @forelse($arr AS $key=>$subhead)
                            <option value="{{ @$subhead->id }}" @if($data->subhead_id ==  @$subhead->id) selected @endif>{{  @$subhead->head_name }}</option>
                        @empty
                        <p>No SubHead</p>
                        @endforelse
                
                    </select>
            </td>

            <td style="position: relative">
                <select id="child_subhead" class="form-control child_subhead"  data-toggle="select2" name="child_subhead[]">
                    <option value="">Select Child Subhead</option>
                    
                    @forelse ($child_head AS $c)
                        @if($c->child_id == $data->subhead_id)
                            <option value="{{ $c->id }}" @if($c->id == $data->child_subhead_id) selected @endif>{{ $c->head_name }}</option>
                        @endif
                    @empty
                        <option value="">NO Child Subheads</option>
                    @endforelse

                </select>
            </td>
            <td >
                <select id="child_subhead" class="form-control forth_subhead"  data-toggle="select2" name="forth_subhead[]">
                    <option value="">Select Forth Subhead</option>
                    
                    @forelse ($forth_head AS $c)
                        @if($c->id == $data->forth_head)
                            <option value="{{ $c->id }}" @if($c->id == $data->forth_head) selected @endif>{{ $c->head_name }}</option>
                        @endif
                    @empty
                        <option value="">NO Child Subheads</option>
                    @endforelse

                </select>
            </td>


            <td><input type="text" class="form-control" name="work[]"  value="{{ @$data->work }}"></td>
            <td><input type="number" step="0.01" class="form-control" name="acres[]"  value="{{ $data->acres }}"></td>
            <td><input type="text" class="form-control" name="material[]"  value="{{ @$data->material }}"></td>
            <td><input type="number" step="0.01" class="form-control quantity" name="quantity[]" required value="{{ @$data->quantity }}"></td>
            <td><input type="number" step="0.01" class="form-control unit_rate" name="unit_rate[]" required value="{{ @$data->unit_rate }}"></td>
            <td><input type="number" step="0.01" class="form-control total" name="total[]" required value="{{ @$data->total }}"></td>
            @if(Auth::user()->type == "company" || Auth::user()->can('delete entries') )
                <td><button type="button" class="btn btn-danger" onclick="deleteData({{ $data->id }})">Delete</button></td>
            @endif

        </tr>

        <tr class="d{{$data->id}}">
            <td><label for="">Note</label></td>
            <td colspan="10"><textarea class="form-control" name="note[]" style="height:150px !important">{{ @$data->note }}</textarea></td>
            <input type="hidden" value="{{ $data->id }}" name="expense_id[]" >
            <input type="hidden" value="{{ @$data->user_id }}" name="user_id[]">
            <input type="hidden" value="{{ @$data->expense_date }}" name="expense_date[]">
            <input type="hidden" value="{{ @$data->payment_type }}" name="payment_type[]">
            <input type="hidden" value="hide_button" id="hide_button">
        </tr>

    @empty
    <tr>
        <td colspan="9">No Record Found</td>
    </tr>

@endforelse
 @else
    <tr>
        <td>
            <select  id="" class="form-control main_head" data-toggle="select2" style="width:100px" name="head[]"   required>
                <option value="">Select Head</option>
                    @forelse($heads AS $head)
                        <option value="{{ $head->id }}">{{ $head->head_name }}</option>
                    @empty
                    <p>empty</p>
                    @endforelse
            </select>

            <table style="width: 100%; height: 180px">
                <tr>
                    <td><label for="">Note</label></td>
                </tr>
            </table>
        </td>

        <td style="position: relative; vertical-align: top">
            <select id="subhead" class="form-control subhead"  data-toggle="select2" style="width:100px" name="subhead[]"
             required>
                <option value="">Select Subhead</option>

            </select>
            <table style="width: 100%">
                <tr>
                    <td>&nbsp;</td>
                </tr>
            </table>
            <div style="position: absolute;width: 735px;top: 50px;">
                <table style="width: 100%">
                    <tr>
                        <td><textarea class="form-control" name="note[]" style="height:150px !important"></textarea></td>
                    </tr>
                </table>
            </div>

        </td>

        <td style="position: relative; vertical-align: top">
            <select id="child_subhead" class="form-control child_subhead"  data-toggle="select2" style="width:100px" name="child_subhead[]">
                <option value="">Select Child Subhead</option>

            </select>
            <table style="width: 100%">
                <tr>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </td>
        <td style="position: relative; vertical-align: top">
            <select id="forth_subhead" class="form-control forth_subhead"  data-toggle="select2" style="width:100px" name="forth_subhead[]">
                <option value="">Select Forth Subhead</option>

            </select>
            <table style="width: 100%">
                <tr>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </td>

        <td style="vertical-align: top"><input type="text" class="form-control" name="work[]">
            <table style="width: 100%">
                <tr>
                    <td>&nbsp;</td>
                </tr>
            </table></td>
        <td style="vertical-align: top"><input type="text" class="form-control" name="acres[]">
            <table style="width: 100%">
                <tr>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </td>
        <td style="vertical-align: top"><input type="text" class="form-control" name="material[]">
            <table style="width: 100%">
                <tr>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </td>
        <td style="vertical-align: top"><input type="number" class="form-control quantity" step="any" name="quantity[]" required>
            <table style="width: 100%">
                <tr>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </td>
        <td style="vertical-align: top"><input type="number" step="any" class="form-control unit_rate" name="unit_rate[]" required>
            <table style="width: 100%">
                <tr>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </td>
        <td style="vertical-align: top"><input type="number" step="any" class="form-control total" name="total[]" required>
            <table style="width: 100%">
                <tr>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </td>
        <td>
            <button type="button" class="btn btn-primary add_row" style="margin-bottom: 10px;"><i class="fas fa-plus"></i></button>
            <button type="button" class="btn btn-danger delete_row" id="delete">Delete</button>
        </td>
        <input type="hidden" value="{{ Auth::id() }}" name="user_id">
        <input type="hidden" value="" name="expense_date" id="expense_date">
        <input type="hidden" value="" name="payment_type[]" id="payment_type" >
    </tr>


    {{-- <input type="hidden" name="expense_id" value=""> --}}

@endif