<div class='form-group'>
    <label class='control-label' for='name'>Nombre:</label>
    <input class='form-control' name='name' type='text'>
</div>

<div class='checkbox'>
    <label>
        <input name='vo' type='checkbox'><strong>VO?</strong>
    </label>
</div>

<div class='form-group'>
    <label class='control-label' for='season'>Temporada:</label>
    <input class='form-control' name='season' type='number' min='0' required>
</div>

<div class='form-group'>
    <label class='control-label' for='episodes'>Episodios de la temporada:</label>
    <input class='form-control' name='episodes' type='number' min='1' required>
</div>

<div class='form-group'>
    <label class='control-label' for='day_new_episode'>Día disponible:</label>
    <select class='form-control' name='day_new_episode' required>
        <option value='0'>Selecciona un día</option>
        <option value='1'>Lunes</option>
        <option value='2'>Martes</option>
        <option value='3'>Miércoles</option>
        <option value='4'>Jueves</option>
        <option value='5'>Viernes</option>
        <option value='6'>Sábado</option>
        <option value='7'>Domingo</option>
    </select>
</div>
<input type='hidden' name='id_serie' value=''>