<div class="col">
    <div class="card" style="width: 18rem;">
        <div class="card-body">
            <h5 class="card-title">CPU</h5>
            <h6 class="card-subtitle mb-2 text-muted">{{ @$cpuInfo["modelName"] }}</h6>
            <p class="card-text">
            Core(s): {{ @$cpuInfo["cores"] }}<br>
            Temp: {{ @$cpuInfo["temp"] }}℃<br>
            {{-- Clock:  --}}
            </p>
        </div>
    </div>
</div>