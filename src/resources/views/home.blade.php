@extends('layouts.app')

@section('content')

    @if (!is_null($nics))
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Network Status</div>
                        <div class="card-body">
                            <div class="card-deck">
                                @foreach ($nics as $nic)
                                    @include('layouts.nic', ['nic' => $nic])
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
    @endif

    @if (!is_null($softwareInfo))
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Software Status</div>
                        <div class="card-body">
                            <div class="card-deck">
                                @foreach ($softwareInfo as $serviceName => $serviceInfo)
                                    @include('layouts.softwareStatus', ['serviceName' => $serviceName, "serviceInfo" => $serviceInfo])
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
    @endif

    @if (!is_null($dockerInfo))
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Docker Containers</div>
                        <div class="card-body">
                            <div class="card-deck">
                                <div class="row row-cols-1 row-cols-sm-1 row-cols-md-2">
                                @foreach ($dockerInfo as $containerId => $containerInfo)
                                    @include('layouts.dockerInfo', ['containerId' => $containerId, "containerInfo" => $containerInfo])
                                @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
    @endif

    @if (!is_null($cpuInfo) || !is_null($memoryInfo) || !is_null($disksInfo))
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">System Status</div>
                        <div class="card-body">
                            <div class="card-deck">
                                {{-- きれいに配置したいが... --}}
                                @if(!is_null($cpuInfo))
                                    @include('layouts.cpu')
                                @endif
                                @if(!is_null($memoryInfo))
                                    @include('layouts.memory')
                                @endif
                                @if(!is_null($disksInfo))
                                    @include('layouts.disk')
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
    @endif

    @if($powerControl)
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">PowerControl</div>
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col text-center" id="poweroff">
                                    <poweroff-component></poweroff-component>
                                </div>
                                <div class="col text-center" id="reboot">
                                    <reboot-component></reboot-component>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <br>

    <!-- Modal -->
    {{-- <div class="modal fade" id="updateAndUpgradeModal" tabindex="-1" role="dialog" aria-labelledby="updateAndUpgradeModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateAndUpgradeModal">update & upgrade</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h4>
                    <i class="far fa-check-circle fa-lg" style="vertical-align: middle; color:forestgreen"></i>
                    -
                    update
                </h4>
                <h4>
                    <div class="spinner-border text-danger" style="width: 1.3em; height: 1.3em;" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    -
                    upgrade
                </h4>
            </div>
            <div class="modal-footer">
                <div id="cancel-reboot-process">
                    <cancel-shutdown-process-component></cancel-shutdown-process-component>
                </div>
                <div id="quick-poweroff">
                    <quick-poweroff-component></quick-poweroff-component>
                </div>
            </div>
            </div>
        </div>
    </div> --}}

    <!-- Modal -->
    <div class="modal fade" id="poweroffModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Poweroff</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    1分後にシャットダウンを実行します。<br>
                    もし、キャンセルするのであればキャンセルボタンを押してください。<br>
                    もし、即時にシャットダウンを実行する場合には即時実行ボタンを押してください。
                </div>
                <div class="modal-footer">
                    <div id="cancel-reboot-process">
                        <cancel-shutdown-process-component></cancel-shutdown-process-component>
                    </div>
                    <div id="quick-poweroff">
                        <quick-poweroff-component></quick-poweroff-component>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="rebootModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Reboot</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    1分後に再起動を実行します。<br>
                    もし、キャンセルするのであればキャンセルボタンを押してください。<br>
                    もし、即時に再起動を実行する場合には即時実行ボタンを押してください。
                </div>
                <div class="modal-footer">
                    <div id="cancel-poweroff-process">
                        <cancel-shutdown-process-component></cancel-shutdown-process-component>
                    </div>
                    <div id="quick-reboot">
                        <quick-reboot-component></quick-reboot-component>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
