<div class="col">
    <div class="card" style="width: 18rem;">
        <div class="card-body">
            <h5 class="card-title">Disks</h5>
            @foreach ($disksInfo as $index => $diskInfo)
            <h6 class="card-subtitle mb-2 text-muted">{{ $diskInfo["fileSystem"] }} => {{ $diskInfo["mountPoint"] }} : {{ $diskInfo["size"] }}iB</h6>
            <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: {{ $diskInfo["usedPercent"] }}%" aria-valuenow="{{ $diskInfo["usedPercent"] }}" aria-valuemin="0" aria-valuemax="100">Used</div>
            </div>
            @if ($index != count($disksInfo) - 1)
                <br>
            @endif
            @endforeach
        </div>
    </div>
</div>