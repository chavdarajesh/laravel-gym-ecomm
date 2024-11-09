@if (!empty($data))
    <div class="d-flex justify-content-center align-items-center form-check form-switch">
        <input data-id="{{ $data['id'] }}"  style="width: 60px;height: 25px;" class="form-check-input status-toggle"
            type="checkbox" id="flexSwitchCheckDefault" {{ $data['status'] ? 'checked' : '' }} />
    </div>
@endif
