<div class="col mb-sm-2 mb-2">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $containerInfo['name'] }}</h5>
            <h6 class="card-subtitle mb-2 text-muted">{{ $containerId }}</h6>
            <p class="card-text">
                Image: {{ $containerInfo['image'] }}<br>
                Status: {{ $containerInfo['status'] }}<br>
            </p>
        </div>
    </div>
</div>