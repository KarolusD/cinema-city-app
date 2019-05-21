<div class="input-field col s6">
    <select style="display:none" class="select-filter" name="filter">
        <option value="" disabled>Typ seansu</option>
        <?php foreach ($aFormats as $f) : ?>
            <option value="<?= $f ?>"><?= $f ?></option>
        <?php endforeach; ?>
        <!-- <option value="" disabled>Opracowanie</option> -->
        <?php foreach ($aLang as $l) : ?>
            <option value="<?= $l ?>"><?= $l ?></option>
        <?php endforeach; ?>
    </select>
</div>