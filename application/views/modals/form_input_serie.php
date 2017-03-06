<div class='row'>
    <div class='input-field col s12'>
        <input name='name' id='name_modal' type='text' class="validate">
        <label for='name_modal'>Nombre:</label>
    </div>
</div>

<div class='row'>
    <div class='switch col s12'>       
        <label>
            <strong>VO:</strong>
            <input name='vo' id='vo_modal' type='checkbox'>
            <span class="lever"></span>
        </label>
    </div>
</div>

<div class='row'>
    <div class='input-field col s6'>
        <input name='season' id='season_modal' type='number' min='0' required class="validate">
        <label for='season_modal'>Temporada:</label>
    </div>

    <div class='input-field col s6'>
        <input name='episodes' id='episodes_modal' type='number' min='1' required class="validate">
        <label for='episodes_modal'>Episodios de la temporada:</label>
    </div>
</div>

<div class='row'>
    <div class='input-field col s12'>
        <select name='day_new_episode' id='day_new_episode_modal' required class="validate">
            <option value='0'>Selecciona un día</option>
            <option value='1'>Lunes</option>
            <option value='2'>Martes</option>
            <option value='3'>Miércoles</option>
            <option value='4'>Jueves</option>
            <option value='5'>Viernes</option>
            <option value='6'>Sábado</option>
            <option value='7'>Domingo</option>
        </select>
        <label for='day_new_episode_modal'>Día disponible:</label>
    </div>
</div>
<input type='hidden' name='id_serie' id='id_serie_modal' value=''>