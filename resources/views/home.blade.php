@extends('layouts.app')

@section('content')

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
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">System Status</div>
                    <div class="card-body">
                        <div class="card-deck">
                            {{-- きれいに配置したいが... --}}
                            @include('layouts.cpu', ['cpuInfo' => $cpuInfo])
                            @include('layouts.memory')
                            {{-- @include('layouts.disk') --}}
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
                    {{-- <form action="/home" method="POST">
                        @csrf --}}
                        <div class="row justify-content-center">
                            <div class="col text-center">
                                <button type="submit" class="btn btn-primary" name="updateAndUpgrade">update & upgrade</button>
                            </div>
                            <div class="col text-center">
                                <button type="submit" class="btn btn-warning" name="distUpgrade">dist upgrade</button>
                            </div>
                        </div>
                    {{-- </form> --}}
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
                <div class="card-header">PowerControl</div>

                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col text-center">
                            <button type="submit" class="btn btn-danger" name="poweroff" data-toggle="modal" data-target="#poweroffModal">Poweroff</button>
                        </div>
                        <div class="col text-center">
                            <button type="submit" class="btn btn-warning" name="reboot" data-toggle="modal" data-target="#rebootModal">Reboot</button>
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

<!-- Modal -->
<div class="modal fade" id="poweroffModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Poweroff</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
                Do you really want to poweroff?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-danger">Poweroff</button>
        </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="rebootModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Reboot</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    Do you really want to restart?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-warning">Reboot</button>
            </div>
            </div>
        </div>
    </div>
@endsection
