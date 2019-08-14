<div class="col">
<div class="card" style="width: 18rem;">
    <div class="card-body">
        <h5 class="card-title">{{ @$nic["name"] }}</h5>
        <h6 class="card-subtitle mb-2 text-muted">{{ @$nic["ifname"] }}</h6>
        <p class="card-text">
        @foreach ($nic["details"] as $addressInfo)
            {{ $addressInfo["ipVersion"]}}: {{ @$addressInfo["ipAddress"] }}<br>
        @endforeach
        MAC: {{ @$nic["macAddress"] }}<br>
        </p>
    </div>
</div>
</div>