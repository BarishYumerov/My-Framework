<?php /** @model = InviteViewModel */?>
<div class="col-lg-offset-1">
    <?php if(count($this->model) == 0) : ?>
        <h2>You do not have lecture invites at this moment!</h2>
    <?php else : ?>
        <?php foreach ($this->model as $invite): ?>
            <div>
                <p style="color:#00a379">You have been invited to lecture <u><?php echo $invite->getLectureName() ?></u>
                at Conference <b><?php echo $invite->getConferenceName() ?></b>
                <a href="/Invite/<?php echo $invite->getId() ?>/Accept" class="btn btn-success btn-xs">Accept</a>
                <a href="/Invite/<?php echo $invite->getId() ?>/Decline" class="btn btn-danger btn-xs">Decline</a>
                </p>
            </div>
        <?php endforeach; ?>
    <?php endif ?>
</div>
