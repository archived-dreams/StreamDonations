@yield('modals')

<script src="{{ asset('assets/js/vendor.js') }}"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap-notify-master/bootstrap-notify.min.js') }}"></script>
<script src="{{ asset('assets/js/notify.js') }}"></script>
<script src="{{ asset('assets/vendor/jqueryForm/jquery.form.min.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap-select/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap-colorpicker-master/js/bootstrap-colorpicker.min.js') }}"></script>
<script src="{{ asset('assets/vendor/noUiSlider/nouislider.min.js') }}"></script>
<script src="{{ asset('assets/vendor/howler/howler.min.js') }}"></script>
<script src="{{ asset('assets/js/project.js') }}"></script>
<script type="text/javascript" src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/1.10.15/js/dataTables.bootstrap4.min.js"></script>
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
</script>
@yield('scripts')