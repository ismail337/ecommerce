<div class="tab-pane fade show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
    <div class="card border">
        <div class="card-body">
            <form action="{{ route('admin.settings.update-general') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Site Name</label>
                    <input type="text" class="form-control" name="site_name"
                        value="{{ $generalSetting->site_name ?? '' }}">
                </div>
                <div class="form-group">
                    <label>Layout</label>
                    <select name="layout" id="" class="form-control">
                        <option value="LTR" {{ $generalSetting->layout == 'LTR' ? 'selected' : '' }}>LTR</option>
                        <option value="RTL" {{ $generalSetting->layout == 'RTL' ? 'selected' : '' }}>RTL</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Contact Email</label>
                    <input type="text" class="form-control" name="contact_email"
                        value="{{ $generalSetting->contact_email ?? '' }}">
                </div>
                <div class="form-group">
                    <label>Contact Phone</label>
                    <input type="text" class="form-control" name="contact_phone"
                        value="{{ $generalSetting->contact_phone ?? '' }}">
                </div>
                <div class="form-group">
                    <label>Contact Address</label>
                    <input type="text" class="form-control" name="contact_address"
                        value="{{ $generalSetting->contact_address ?? '' }}">
                </div>
                <div class="form-group">
                    <label>Google Map Url</label>
                    <input type="text" class="form-control" name="map" value="{{ $generalSetting->map ?? '' }}">
                </div>
                <hr>
                <div class="form-group">
                    <label>Default Currecy Name</label>
                    <select name="currency_name" id="" class="form-control select2">
                        <option value="">Select</option>
                        @foreach (config('settings.currency_list') as $key => $currency)
                            <option value="{{ $key }}"
                                {{ $generalSetting->currency_name == $key ? 'selected' : '' }}>
                                {{ $currency }}
                            </option>
                        @endforeach

                    </select>
                </div>
                <div class="form-group">
                    <label>Currency Icon</label>
                    <input type="text" class="form-control" name="currency_icon"
                        value="{{ $generalSetting->currency_icon ?? '' }}">
                </div>
                <div class="form-group">
                    <label>Timezone</label>
                    <select name="time_zone" id="" class="form-control select2">
                        <option value="">Select</option>
                        @foreach (config('settings.time_zone') as $key => $zone)
                            <option value="{{ $zone }}"
                                {{ $generalSetting->time_zone == $zone ? 'selected' : '' }}>
                                {{ $key }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
