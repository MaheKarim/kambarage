<script>
    function errorMessage(message){
        Snackbar.show({text: message, pos: 'bottom-center'});
    }

    function showMessage(message){
        Snackbar.show({text: message, pos: 'bottom-center'});
    }

    function ajaxMethodCall(selectDiv) {

        var $this = $(selectDiv),
            loadurl = $this.attr('data-href'),
            targ = $this.attr('data-target'),
            id = selectDiv.id || '';

        $.post(loadurl, function(data) {
            $(targ).html(data);
            $('form').append('<input type="hidden" name="active_tab" value="'+id+'" />');
        });

        $this.tab('show');
        return false;
    }

    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(".calentimDatepickerCurr").calentim({
            showHeader :false,
            singleDate: true,
            autoAlign : true,
            calendarCount: 1,
            showTimePickers: false,
            format : 'DD-MM-Y',
            autoCloseOnSelect : true,
            startEmpty : true,
        });

        $(document).on('mouseenter','table.dataTable .tooltip',function(){
            $(this).parent().addClass('overflow-visible').removeClass('overflow-hidden');
        });
        $(document).on('mouseout','table.dataTable .tooltip',function(){
            $(this).parent().addClass('overflow-hidden').removeClass('overflow-visible');
        });

        $(document).on('click', '.loadRemoteModel', function(e)
        {
            e.preventDefault();
            var url = $(this).attr('href');
            if (url.indexOf('#') == 0) {
                $(url).modal('open');
            }
            else {
                $.get(url, function(data)
                {
                     $('#remoteModelData').html(data);
                     $('#remoteModelData').modal();
                });
            }
        });

        $(document).on('click', '[data-toggle="tabajax"]', function(e) {
            e.preventDefault();
            var selectDiv = this;
            ajaxMethodCall(selectDiv);
        });
    });
</script>
