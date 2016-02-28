<?php $this->load->view('header'); ?>
<script type="text/javascript">
    var original_value = '';

    $(document).ready(function () {

        $('td').dblclick(function () {
            original_value = $(this).html();
            $(this).attr('contenteditable', true);
            $(this).focus();
        });

        $('td').keydown(function(e) {
            if (e.keyCode == 27) { //esc
                $(this).html(original_value);
                $(this).removeAttr('contenteditable');
            }
            else if (e.keyCode == 13) { //enter
                e.preventDefault();
                $(this).blur();
            }
        });

        $('td').blur(function() {
            save_value($(this));
        });
    });

    function save_value(element) {
        var id = element.parent('tr').attr('id');
        var field = element.attr('colname');
        var value = element.html();
        if(original_value == value) return; 

        $.post(
            '<?php echo base_url().'edit_field_serie'; ?>',
            {
                'id_serie': id,
                'field': field,
                'value': value
            },
            function( result ) {
                if(!result) {
                    element.html(original_value);
                    $('.alert-danger').html('Ha ocurrido un error');
                    $('.alert-danger').show().delay(3000).fadeOut();
                }
                element.removeAttr('contenteditable');
            }, 'json'
        );
    }
</script>
<style>
    .alert{
        position: fixed;
        top: 15%;
        right:40%;
        left:40%;
        width: auto;
        z-index: 1;
        text-align: center;
    }
    .name_col{
        font-weight: bold;
    }
    th:not(.name_col), td:not(.name_col){
        text-align: center;
    }
</style>
    <div class="alert alert-danger" role="alert" style='display:none;'></div>
    <table class="table table-hover">
        <thead>
            <tr>
                <th class="name_col">Serie</th>
                <th>VO</th>
                <th>Temporada</th>
                <th>Capítulo final</th>
                <th>Día emisión</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($series)) foreach($series as $serie) { ?>
            <tr id="<?php echo $serie['id']; ?>">
                <td colname='name' class="name_col"><?php echo $serie['name']; ?></td>
                <td colname='vo'><?php echo $serie['vo']; ?></td>
                <td colname='season'><?php echo $serie['season']; ?></td>
                <td colname='episodes'><?php echo $serie['episodes']; ?></td>
                <td colname='day_new_episode'><?php echo $serie['day_new_episode']; ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    


<?php $this->load->view('footer'); ?>
