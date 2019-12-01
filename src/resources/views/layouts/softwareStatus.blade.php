<div class="col">
    <div class="card" style="width: 18rem;">
        <div class="card-body">
            <h5 class="card-title">{{ $serviceName }}</h5>
            <h6 class="card-subtitle mb-2 text-muted">{{ $serviceInfo["Description"] }}</h6>
            <p class="card-text">
                @switch($serviceInfo["ActiveState"])
                    @case("active")
                        <span class="good-status"><i class="far fa-check-circle">
                        @break
                    @case("failed")
                        <span class="bad-status"><i class="far fa-check-circle">
                        @break
                    @case("activating")
                        <span class="good-status"><i class="fas fa-spinner"></i>
                        @break
                    @case("deactivating")
                        <span class="bad-status"><i class="fas fa-spinner"></i>
                        @break
                    @default
                        <span class="none-status"><i class="far fa-question-circle"></i>
                @endswitch
                </i></span> Active-State: {{ $serviceInfo["ActiveState"] }}
            </p>
        </div>
    </div>
</div>