<fieldset class="form-group">
    <label for="search_status">Trạng thái</label>
    <select name="search_status" id="search_status" class="form-control select2 status">
        <option value=''>Tất cả</option>
        @foreach($typeConstant as $key => $val)
            <option value="{{ $key }}">{{ $val }}</option>
        @endforeach
    </select>
</fieldset>
