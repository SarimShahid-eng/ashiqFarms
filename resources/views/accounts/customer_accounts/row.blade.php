<tr>
    <td style="position: relative">
        <div class="form-group" style="margin-bottom: 75px;">
            <label for="">Users</label>
            <select class="form-control users" name="users[]" id="" required>
                <option value="">Select User</option>
                @if(isset($customers))
                    @forelse($customers AS $customer)
                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                    @empty
                    <option value="">No Users</option>
                    @endforelse
                @endif
            </select>
        </div>

        <div style="position: absolute;width: 410%;bottom: 15px;">
            <table style="width: 100%">
                <tbody>
                    <tr>
                        <td>
                            Note
                        </td>
                    <td><input type="text" class="form-control" name="note[]"></td>
                </tr>
            </tbody></table>
        </div>
    </td>

    <td>
        <div class="form-group" style="margin-bottom: 75px;">
            <label for="">Amount</label>
            <input type="number" class="form-control" name="amount[]" required>
        </div>
    </td>
    
    <td>
        <div class="form-group" style="margin-bottom: 75px;">
            <label for="">Transaction Mode</label>
            <select class="form-control" name="mode[]" id="" required>
                <option value="" disabled selected>Select Mode</option>
               @forelse($transactions As $t)
                    <option value="{{ $t->id }}">{{ $t->mode }}</option>
               @empty
               @endforelse
            </select>
        </div>
        
    </td>

    <td>
        <div class="form-group" style="margin-bottom: 75px;">
            <label for="">Type</label>
            <select class="form-control" name="type[]" id="" required>
                <option value="" selected disabled>Select Type</option>
                <option value="in">IN</option>
                <option value="out">OUT</option>
            </select>
        </div>
    </td>

    <td>
        <div class="form-group" style="margin-bottom: 75px;">
            <label for="">Date</label>
            <input type="date" class="form-control" name="date[]" required>
        </div>    
    </td>

    <td>
        <button class="btn btn-danger remove_row">X</i></button>
    </td>
</tr>