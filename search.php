  <!-- Search Section Start -->
<div id="search">
    <div class="container">
        <div class="form-row">
            <div class="control-group col-md-6">
                <label>Room Type</label>
                <select class="custom-select">
                    <option value="">Select</option>
                    <option value="1" <?php echo isset($room_type) && $room_type == 1 ? 'selected' : '' ?>>Superior</option>
                    <option value="2" <?php echo isset($room_type) && $room_type == 2 ? 'selected' : '' ?>>Standard</option>
                    <option value="3" <?php echo isset($room_type) && $room_type == 3 ? 'selected' : '' ?>>Twin Bed</option>
                    <option value="4" <?php echo isset($room_type) && $room_type == 4 ? 'selected' : '' ?>>Single Bed</option>
                </select>
            </div>
            <div class="control-group col-md-3">
                <label>Check-In</label>
                <div class="form-group">
                    <div class="input-group date" id="date-3" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" data-target="#date-3"/>
                        <div class="input-group-append" data-target="#date-3" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="control-group col-md-3">
                <label>Check-Out</label>
                <div class="form-group">
                    <div class="input-group date" id="date-4" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" data-target="#date-4"/>
                        <div class="input-group-append" data-target="#date-4" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="control-group col-md-3">
                <div class="form-row">
                    <div class="control-group col-md-6">
                        <label>Adult</label>
                        <select class="custom-select">
                            <option selected>0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select>
                    </div>
                    <div class="control-group col-md-6 kid">
                        <label>Kid</label>
                        <select class="custom-select">
                            <option selected>0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="control-group col-md-3">
                <button class="btn btn-block">Search</button>
            </div>
        </div>
    </div>
</div>
<!-- Search Section End -->