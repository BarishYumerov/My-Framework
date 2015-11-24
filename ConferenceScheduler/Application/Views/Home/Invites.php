<?php /** @model = InviteViewModel */?>
<div class="col-lg-offset-1">
    <?php foreach ($this->model as $invite): ?>
        <div>
            <p style="color:#00a379">You have been invited to lecture <u><?php echo $invite->getLectureName() ?></u>
            at Conference <b><?php echo $invite->getConferenceName() ?></b></p>
        </div>
    <?php endforeach; ?>
</div>
