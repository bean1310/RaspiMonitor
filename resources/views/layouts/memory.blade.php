<div class="col">
        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">Memory</h5>
                <h6 class="card-subtitle mb-2 text-muted">Memory: {{ $memoryInfo["memoryTotalSize"]}}</h6>
                <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: {{ $memoryInfo["memoryUsedPercent"] }}%" aria-valuenow="{{ $memoryInfo["memoryUsedPercent"] }}" aria-valuemin="0" aria-valuemax="100">Used</div>
                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $memoryInfo["memoryBuffersAndCachedPercent"] }}%" aria-valuenow="{{ $memoryInfo["memoryBuffersAndCachedPercent"] }}" aria-valuemin="0" aria-valuemax="100">Buffer/Cache</div>
                </div><br>
                <h6 class="card-subtitle mb-2 text-muted">Swap: {{ $memoryInfo["swapTotalSize"]}}</h6>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: {{ $memoryInfo["swapUsedPercent"] }}%" aria-valuenow="{{ $memoryInfo["swapUsedPercent"] }}" aria-valuemin="0" aria-valuemax="100">Used</div>
                </div>
            </div>
        </div>
    </div>