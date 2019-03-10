<div class="row">
    <div class="input-field">
        <select style="display:none" class="select-cinema" name="cinema">
            <option value="" disabled>Wybierz kino</option>
            <?php foreach ($aCinemas as $k => $c) : ?>
            <option value="<?= $c ?>"><?= $k ?></option>
            <?php endforeach; ?>
        </select>
        <div class="arrow">
            <span></span>
            <span></span>
        </div>
    </div>
</div> 