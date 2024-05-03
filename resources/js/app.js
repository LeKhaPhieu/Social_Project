import './bootstrap';
import jQuery from 'jquery';
window.$ = jQuery;
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
