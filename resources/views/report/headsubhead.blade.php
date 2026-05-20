<select name="headsubhead" id="" class="headsubhead">
    @forelse($heads AS $head)
        @foreach($head->sub AS $subhead)
            <option value="{{ $head->id.','.$subhead->id }}" data-head="{{ $head->id }}" data-subhead="{{ $subhead->id }}">{{ $head->head_name }} > {{ $subhead->head_name }} </option>
        @endforeach
    @empty    
    @endforelse
</select>