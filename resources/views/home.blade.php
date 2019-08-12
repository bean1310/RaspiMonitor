@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">PowerControl</div>

                <div class="card-body">
                    <form action="/powerControl/" method="POST">
                        <div class="row justify-content-center">
                            <div class="col text-center">
                                <button type="button" class="btn btn-danger" name="poweroff">Poweroff</button>
                            </div>
                            <div class="col text-center">
                                <button type="button" class="btn btn-warning" name="reboot">Reboot</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Network Status</div>

                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="card" style="width: 18rem;">
                                <div class="card-body">
                                    <h5 class="card-title">Wi-Fi</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">Wi-Fi status</h6>
                                    <p class="card-text">
                                        IP: {{@$wifiIpAddress}}<br>
                                        MAC: {{@$wifiMacAddress}}<br>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card" style="width: 18rem;">
                                <div class="card-body">
                                    <h5 class="card-title">Ethernet</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">Ethernet status</h6>
                                    <p class="card-text">
                                        IP: {{@$ethernetIpAddress}}<br>
                                        MAC: {{@$ethernetMacAddress}}<br>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">SoftwareControl</div>

                <div class="card-body">
                    <form action="/powerControl/" method="POST">
                        <div class="row justify-content-center">
                            <div class="col text-center">
                                <button type="button" class="btn btn-primary" name="poweroff">update</button>
                            </div>
                            <div class="col text-center">
                                <button type="button" class="btn btn-success" name="reboot">upgrade</button>
                            </div>
                            <div class="col text-center">
                                    <button type="button" class="btn btn-warning" name="reboot">dist upgrade</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Console</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
