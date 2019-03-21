@foreach(['warning', 'info', 'success', 'danger'] as $type)
    @if(session($type))
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-{{ $type }} alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ session($type) }}
                </div>
            </div>
        </div>
    @endif
@endforeach