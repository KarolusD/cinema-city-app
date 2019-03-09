<div class="row">
    <div class="input-field flex-row">
        <select class="select select--cinema" id="cinemaSelect" name="cinema">
            <option disabled>Choose your option</option>
            <?php foreach ($aCinemas as $k => $c) : ?>
            <option value="<?= $c ?>">
                <?= $k ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>
</div> 