<!--DIALOG-->
<div class='modal' id='modal_add_serie'> 
    <div class='modal-content'>
    	<div class="row">
	        <h4 class='modal-title'>Nueva serie</h4>
	        <form method='POST' action='add_serie' id='form_new_serie' class='col s12'>
	            <?php $this->load->view('modals/form_input_serie'); ?>
	        </form>
        </div>
    </div>
    <div class='modal-footer'>
    	<a class="btn light-blue waves-effect waves-light" id="submit_new_serie">Añadir serie</a>
    </div>
</div>