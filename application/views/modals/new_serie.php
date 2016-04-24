<!--DIALOG-->
<div class='modal fade' id='modal_add_serie' data-backdrop='static'> 
    <div class='modal-dialog modal-sm' >
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
                    <h4 class='modal-title'>Nueva serie</h4>
            </div>
            <div class='modal-body'>
                <form method='POST' action='add_serie' id='form_new_serie'>
                    <?php $this->load->view('modals/form_input_serie'); ?>
                </form>
            </div>
            <div class='modal-footer'>
                <button type='button' class='btn btn-primary' id='submit_new_serie'>Ok</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->