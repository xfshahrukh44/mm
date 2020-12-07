@csrf
<div class="modal-body">
    <!-- name -->
    <div class="form-group">
        <label for="">Name</label>
        <input id="name" type="text" name="name" placeholder="Enter name"
        class="form-control" required max="50">
    </div>
    <!-- email -->
    <div class="form-group">
        <label for="">Email</label>
        <input id="email" type="email" name="email" placeholder="Enter email"
        class="form-control" max="50">
    </div>
    @if($user_type == 'customer')
        <label for="zone">Zone</label>
        <select id="zone_id" name="zone_id" class="form-control">
            <option value="">Select Zone</option>
            @foreach($zones as $zone)
                <option value="{{$zone->id}}">{{$zone->name}}</option>
            @endforeach    
        </select>
        <br>
    @endif
    @if($user_type == 'staff')
        <!-- password -->
        <div class="form-group">
        <label for="">Password</label>
        <input id="password" type="password" name="password" placeholder="Enter password"
        class="form-control" min=8>
        </div>
    @endif
    <!-- phone -->
    <div class="form-group">
        <label for="">Phone</label>
        <input id="phone" type="text" name="phone" placeholder="Enter phone"
        class="form-control" required>
    </div>
    <!-- type -->
    @if($user_type == 'customer')
        <div class="form-group hidden_select" hidden>
            <label for="">Type</label>
            <select id="type" name="type" class="form-control">
                <option value="customer">Customer</option>
            </select>
        </div>
        <input type="hidden" value="customer" name="identifier">
    @elseif($user_type == 'rider')
        <div class="form-group hidden_select" hidden>
            <label for="">Type</label>
            <select id="type" name="type" class="form-control">
                <option value="rider">Rider</option>
            </select>
        </div>
        <input type="hidden" value="rider" name="identifier">
    @else
        <div class="form-group">
            <label for="">Type</label>
            <select id="type" name="type" class="form-control" required>
                <option value="">Select user type</option>
                <option value="admin">Admin</option>
                <option value="superadmin">Super Admin</option>
            </select>
        </div>
    @endif
    @if($user_type == 'rider')
    <!-- zones -->
    <div class="form-group">
        <label for="">Zones</label>
        <br>
        <select class="js-example-basic-multiple zone_wrapper" name="zones[]" multiple="multiple" style="width: 100%;">

        </select>
    </div>
    @endif
</div>