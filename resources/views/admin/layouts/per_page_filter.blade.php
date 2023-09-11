<fieldset class="form-group">
    <label for="per_page">Số bản ghi</label>
    <select name="per_page" id="per_page" class="form-control select2 all">
        <option value="">Tất cả</option>
        @foreach(\App\Constants\SettingConstant::CUSTOM_PER_PAGE_TEXT as $key => $value)
            <option value="{{$key}}" {{ $key == \App\Constants\SettingConstant::DEFAULT_PAGINATE ? 'selected' : '' }}>
                {{ $value }}
            </option>
        @endforeach
    </select>
</fieldset>
