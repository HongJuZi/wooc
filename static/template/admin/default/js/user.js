HHJsLib.register({
    init: function() {
        this.initHidden();
        this.bindParentChange();
        this.bindBankChange();
    },
    initHidden: function() {
        $('#county_id').parent().parent().addClass('hidden');
        $('#bank_id').parent().parent().addClass('hidden');       
    },
    bindParentChange: function() {
        $('#parent_id').change(function() {
            $('#county_id').parent().parent().addClass('hidden');
            $('#bank_id').parent().parent().addClass('hidden');       
            if($(this).val() == 5 || $(this).val() == 6) {
                $('#county_id').parent().parent().removeClass('hidden');
                $('#county_id').chosen("destroy");
            }
            if($(this).val() == 6) {
                $('#bank_id').parent().parent().removeClass('hidden');       
                $('#bank_id').empty();
            }
        });
    },
    bindBankChange: function() {
        var _self   = this;
        $('#county_id').change(function() {
            _self._getBankList($(this).val());
        });
    },
    _getBankList(id) {
        if(id == '' || id == 0) {
            $('#bank_id').empty()
            return ;
        }
        $.getJSON(
            queryUrl + 'admin/user/agetbanklist',
            {
                id: id
            },
            function(response) {
                if(false == response.rs) {
                    return HHJsLib.warn(response.message);
                }
                var data = response.data;
                var tpl     = '';
                for(var index in data) {
                    tpl += '<option value="' + data[index].id + '">' + data[index].name + '</option>';
                }
                $('#bank_id').empty().append(tpl);
            }
        );
    }
});
