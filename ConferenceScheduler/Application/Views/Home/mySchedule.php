<div class="col-lg-offset-3">
    <?php if(count($model['toVisit']) === 0) : ?>
        <h2 class="col-lg-offset-2">No Lectures To Visit!</h2>
    <?php else:  ?>
        <h2 class="col-lg-offset-2">Lectures to visit: </h2>
        <?php foreach($model['toVisit'] as $lecture) : ?>
            <div>
                <p style="color:#2077b2">You have to visit lecture <u><?php echo $lecture->getName() ?></u>
                from <u><?php echo $lecture->getStartDate() ?></u>
                to <u><?php echo $lecture->getEndDate() ?></u></p>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if(count($model['toSpeak']) === 0) : ?>
        <h2 class="col-lg-offset-2">No Lectures To Be Speaker To!</h2>
    <?php else:  ?>
        <h2 class="col-lg-offset-2">Lectures to be Speaker: </h2>
        <?php foreach($model['toSpeak'] as $lecture) : ?>
            <div>
                <p style="color:#2077b2">You have to visit lecture <u><?php echo $lecture->getName() ?></u>
                    from <u><?php echo $lecture->getStartDate() ?></u>
                    to <u><?php echo $lecture->getEndDate() ?></u></p>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>