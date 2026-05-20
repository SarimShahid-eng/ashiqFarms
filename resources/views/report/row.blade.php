<td>1</td>
<td><input type="date" class="date" name="date" value="{{ date('Y-m-d',strtotime(@$expense->expense_date)) }}"></td>
<td>
    <select name="first_head" id="" class="first_head">
        @foreach($heads AS $head)
        <option value="{{ $head->id }}"  @if($expense->head_id == $head->id) selected @endif>
            {{ $head->head_name }}
        </option>
        @endforeach
    </select>
</td>
<td>
    <select name="second_head" id="" class="second_head">
        <option value="">Select Second Head</option>
        @foreach($second_heads AS $second_head)
        <option value="{{ $second_head->id }}"  @if($expense->subhead_id == $second_head->id) selected @endif>
            {{ $second_head->head_name }}
        </option>
        @endforeach
    </select>
</td>
<td>
    <select name="third_head" id="" class="third_head">
        <option value="">Select Third Head</option>
        @foreach($third_heads AS $third_head)
        <option value="{{ $third_head->id }}"  @if($expense->child_subhead_id == $third_head->id) selected @endif>
            {{ $third_head->head_name }}
        </option>
        @endforeach
    </select>
</td>
<td>
    <select name="forth_head" id="" class="forth_head">
        <option value="">Select Forth Head</option>
        @foreach($fourth_heads AS $fourth_head)
        <option value="{{ $fourth_head->id }}"  @if($expense->forth_head == $fourth_head->id) selected @endif>
            {{ $fourth_head->head_name }}
        </option>
        @endforeach
    </select>
</td>
<td><input type="text" class="work" name="work" value="{{ @$expense->work }}"></td>
<td><input type="number" class="acres" name="acres" value="{{ @$expense->acres }}"></td>
<td><input type="text" style="max-width: 160px" class="material"name="material" value="{{ @$expense->material }}"></td>
<td><input type="number" class="quantity" name="quantity" quantity="0" value="{{ @$expense->quantity }}"></td>
<td><input type="number" class="unit_rate" name="rate" value="{{ @$expense->unit_rate }}"></td>
<td><input type="number" class="total" name="total" value="{{ @$expense->total }}"></td>
<td>
    <select class="type" name="type">
        <option value="0" @if($expense->payment_type == 0) selected @endif>Income</option>
        <option value="1" @if($expense->payment_type == 1) selected @endif>Expense</option>
        <option value="2" @if($expense->payment_type == 2) selected @endif>Paid</option>
    </select>
</td>
<td><input class="note" type="text" name="type" value="{{ @$expense->note }}"></td>
<td>
    <a href="" id="delete" data-delete="{{ $data->id ?? @$expense->id }}"><i class="fas fa-edit"></i>Del</a>
    <a href="" class="save" data-save="{{ @$expense->id }}">Save</a>
</td>
<td class="hide_row"><a href=""><input type="checkbox" class="move" value="{{ $expense->id }}" name="move" @if($expense->is_move==1) checked @endif></a></td>

<script>
$(document).on('change','.first_head',function(){
            var obj=$(this);
            var id = obj.val();
            // obj.parent().find('.subhead').empty().append('<option value="" selected>Select Child Subhead</option>');
            $.ajax({
                url : "{{ url('enteries/subheads') }}",
                type : "get",
                data : { id:id },
                success:function(data){
                    var data = `<option value='' selected disabled>Select Second Head</option>${data}`
                    obj.parent().parent().find('.second_head').html(data);
                }
            });
        });
        //dropdown for child subheads child_subhead
        $(document).on('change','.second_head',function(){
            var obj=$(this);
            var id = obj.val();
            $.ajax({
                url : "{{ url('enteries/child-subheads') }}",
                type : "get",
                data : { id:id },
                success:function(data){
                    var data = `<option value='' selected disabled>Select Third Head</option>${data}`
                    obj.parent().parent().find('.third_head').html(data);
                }
            });
        });
        //dropdown for child subheads
        $(document).on('change','.third_head',function(){
            var obj=$(this);
            var id = obj.val();
            $.ajax({
                url : "{{ url('enteries/forth-subheads') }}",
                type : "get",
                data : { id:id },
                success:function(data){
                    var data = `<option value='' selected disabled>Select Fourth Head</option>${data}`
                    obj.parent().parent().find('.forth_head').html(data);
                }
            });
        });
</script>
